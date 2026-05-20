<?php
namespace Harman\ReverbChat\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'reverb-chat:install';

    protected $description = 'Install Reverb Chat Package';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--tag' => 'reverb-chat-config',
        ]);

        $this->info('Reverb Chat Installed Successfully.');
    }
}
