<?php

return [

    'route_prefix' => 'chat',

    'middleware'   => ['web', 'auth'],

    'models'       => [
        'user'    => config('auth.providers.users.model'),
        'message' => \Harman\ReverbChat\Models\Message::class,
    ],

];
