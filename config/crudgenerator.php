<?php

return [
    'base_path' => 'app-modules',
    'base_namespace' => 'App\\Modules',
    'src_directory' => 'src',
    'test_directory' => 'tests',
    'default_role_name' => 'admin',
    'default_guard_name' => 'web',
    'composer' => [
        'vendor_prefix' => 'app',
    ],

    'routes' => [
        // Make sure this file is added to bootstrap/app.php
        'default_file' => 'routes/web.php',
    ],
];
