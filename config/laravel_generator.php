<?php

$apiVersionPrefix = sprintf('V%s', config('app.api_version'));

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    */

    'path' => [

        'migration'         => database_path('migrations/'),

        'model'             => app_path('Models/'),

        'datatables'        => app_path('DataTables/'),

        'livewire_tables'   => app_path('Http/Livewire/'),

        'repository'        => app_path('Repositories/'),

        'routes'            => base_path('routes/web.php'),

        'api_routes'        => base_path(sprintf('routes/api_v%s.php', config('app.api_version'))),

        'request'           => app_path('Http/Requests/'),

        'api_request'       => app_path(sprintf('Http/Requests/API/%s/', $apiVersionPrefix)),

        'controller'        => app_path('Http/Controllers/'),

        'api_controller'    => app_path(sprintf('Http/Controllers/API/%s/', $apiVersionPrefix)),

        'api_resource'      => app_path(sprintf('Http/Resources/API/%s/', $apiVersionPrefix)),

        'schema_files'      => resource_path('model_schemas/'),

        'seeder'            => database_path('seeders/'),

        'database_seeder'   => database_path('seeders/DatabaseSeeder.php'),

        'factory'           => database_path('factories/'),

        'view_provider'     => app_path('Providers/ViewServiceProvider.php'),

        'tests'             => base_path('tests/'),

        'repository_test'   => base_path('tests/Repositories/'),

        'api_test'          => base_path('tests/APIs/'),

        'views'             => resource_path('views/'),

        'menu_file'         => resource_path('views/layouts/menu.blade.php'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => [

        'model'             => 'App\Models',

        'datatables'        => 'App\DataTables',

        'livewire_tables'   => 'App\Http\Livewire',

        'repository'        => 'App\Repositories',

        'controller'        => 'App\Http\Controllers',

        'api_controller'    => sprintf('App\Http\Controllers\API\%s', $apiVersionPrefix),

        'api_resource'      => sprintf('App\Http\Resources\API\%s', $apiVersionPrefix),

        'request'           => 'App\Http\Requests',

        'api_request'       => sprintf('App\Http\Requests\API\%s', $apiVersionPrefix),

        'seeder'            => 'Database\Seeders',

        'factory'           => 'Database\Factories',

        'tests'             => 'Tests',

        'repository_test'   => 'Tests\Repositories',

        'api_test'          => 'Tests\APIs',
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    */

    'templates' => 'adminlte-templates',

    /*
    |--------------------------------------------------------------------------
    | Model extend class
    |--------------------------------------------------------------------------
    |
    */

    'model_extend_class' => 'Illuminate\Database\Eloquent\Model',

    /*
    |--------------------------------------------------------------------------
    | API routes prefix & version
    |--------------------------------------------------------------------------
    |
    */

    'api_prefix'  => sprintf('api/v%s', config('app.api_version')),

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    */

    'options' => [

        'soft_delete' => false,

        'save_schema_file' => false,

        'localized' => false,

        'repository_pattern' => true,

        'resources' => true,

        'factory' => false,

        'seeder' => false,

        'swagger' => false, // generate swagger for your APIs

        'tests' => false, // generate test cases for your APIs

        'excluded_fields' => ['id'], // Array of columns that doesn't required while creating module
    ],

    /*
    |--------------------------------------------------------------------------
    | Prefixes
    |--------------------------------------------------------------------------
    |
    */

    'prefixes' => [

        'route' => '',  // e.g. admin or admin.shipping or admin.shipping.logistics

        'namespace' => '',  // e.g. Admin or Admin\Shipping or Admin\Shipping\Logistics

        'view' => '',  // e.g. admin or admin/shipping or admin/shipping/logistics
    ],

    /*
    |--------------------------------------------------------------------------
    | Table Types
    |
    | Possible Options: blade, datatables, livewire
    |--------------------------------------------------------------------------
    |
    */

    'tables' => 'blade',

    /*
    |--------------------------------------------------------------------------
    | Timestamp Fields
    |--------------------------------------------------------------------------
    |
    */

    'timestamps' => [

        'enabled'       => true,

        'created_at'    => 'created_at',

        'updated_at'    => 'updated_at',

        'deleted_at'    => 'deleted_at',
    ],

    /*
    |--------------------------------------------------------------------------
    | Specify custom doctrine mappings as per your need
    |--------------------------------------------------------------------------
    |
    */

    'from_table' => [

        'doctrine_mappings' => [],
    ],

];
