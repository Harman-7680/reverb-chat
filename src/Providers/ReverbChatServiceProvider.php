<?php
namespace Harman\ReverbChat\Providers;

use Illuminate\Support\ServiceProvider;

class ReverbChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/reverb-chat.php',
            'reverb-chat'
        );
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'reverb-chat');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/reverb-chat.php' => config_path('reverb-chat.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {

            $this->commands([
                \Harman\ReverbChat\Console\Commands\InstallCommand::class,
            ]);

        }
    }
}
