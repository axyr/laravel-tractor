<?php

return [
    'base_path' => 'app-modules',
    'base_namespace' => 'App\\Modules',
    'src_directory' => 'src',
    'test_directory' => 'tests',
    'default_role_name' => 'admin',
    'default_guard_name' => 'web',
    'user_factory_class' => \Database\Factories\UserFactory::class,
    'route_middleware' => 'web',
    'route_prefix' => 'api',
    'composer' => [
        'vendor_prefix' => 'modules',
    ],
];
