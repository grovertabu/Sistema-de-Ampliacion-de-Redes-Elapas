<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => '',
    'title_prefix' => 'Elapas |',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>ELAPAS</b> sistema',
    'logo_img' => 'vendor/adminlte/dist/img/elapas-logo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Elapas',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-danger',
    'usermenu_image' => false,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => 'd-none',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => 'bg-info',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-info elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'dash',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [

        [
            'text' => 'Buscar',
            'search' => false,
            'topnav' => true,
        ],
        [
            'text' => 'Inicio',
            'route'  => 'dash',
        ],
        ['header' => 'GESTION USUARIOS'],
        [
            'text' => 'Perfil',
            'url'  => 'user/profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'Lista Usuarios',
            'route'  => 'users.index',
            'icon' => 'fa fa-fw fa-users',
            'can' => 'users.index',
        ],
        // [
        //     'header' => 'SOLICITUDES AMPLIACION',
        //     'can' => ''
        // ],
        [
            'header' => 'SOLICITUDES AMPLIACION',
            'can' => 'menu-solicitud'
        ],
        [
            'text' => 'Solicitudes',
            'route'  => 'solicitud.index',
            'icon' => 'fas fa-fw fa-folder',
            'can' => 'solicitud.index',

        ],


        [
            'header' => 'INFORMES DE AMPLIACION',
            'can' => 'menu-informes'
        ],
        [
            'text' => 'Inspecciones',
            'route'  => 'monitoreo.index',
            'icon' => 'fas fa-fw fa-folder',
            'can' => 'Monitor',

        ],
        [
            'text' => 'Inspecciones',
            'route'  => 'proyectos.index',
            'icon' => 'fas fa-fw fa-folder',
            'can' => 'Proyectista',

        ],

        // [
        //     'text' => 'Inspecciones',
        //     'route'  => 'informes.index',
        //     'icon' => 'fa fa-fw fa-file-pdf',
        //     'can' => 'informes.index',
        // ],
        // [
        //     'text' => 'Inspecciones Autorizadas',
        //     'route'  => 'informes.autorizado',
        //     'icon' => 'fa fa-fw fa-file-pdf',
        //     'can' => 'inspector',

        // ],
        // [
        //     'text' => 'Inspecciones en Ejecución',
        //     'route'  => 'informes.concluido',
        //     'icon' => 'fa fa-fw fa-file-pdf',
        //     'can' => 'inspector',

        // ],
        [
            'text'    => 'Informes de Ampliación',
            'icon'    => 'fa fa-fw fa-file-pdf',
            'submenu' => [
                [
                    'text' => 'Inspecciones',
                    'route'  => 'informes.index',
                    'icon' => 'fa fa-fw fa-file-pdf'
                ],
                [
                    'text' => 'Inspecciones Autorizadas',
                    'route'  => 'informes.autorizado',
                    'icon' => 'fa fa-fw fa-file-pdf',


                ],
                [
                    'text' => 'Inspecciones en Ejecución',
                    'route'  => 'informes.concluido',
                    'icon' => 'fa fa-fw fa-file-pdf',


                ],

            ],
            'can' => 'informes.index'
        ],




        [
            'text'    => 'Programación',
            'icon' => 'fas fa-calendar-alt',
            'submenu' => [
                [
                    'text'       => 'Asignar inspector',
                    'icon_color' => 'red',
                    'route'  => 'cronograma.index',
                    'can' => 'jefe-red',
                ],
                [
                    'text'       => 'Cronograma de inspecciones',
                    'icon_color' => 'yellow',
                    'route'  => 'cronograma.reporte',
                    'can' => 'jefe-red',
                ]

            ],
            'can' => 'jefe-red'
        ],
        // [
        //     'text'       => 'Ampliacion en ejecucion',
        //     'icon_color' => 'yellow',
        //     'url'        => '#',
        //     'can' => 'inspector',
        // ],

        [
            'text'    => 'Recursos de Ampliación',
            'icon' => 'fas fa-tools',
            'submenu' => [
                [
                    'text' => 'Actividades',
                    'route'  => 'actividad.index',
                    'icon_color' => 'red',
                    'can' => 'jefe-red',
                ],
                [
                    'text' => 'Material',
                    'icon' => 'fas fa-fw fa-box-open',
                    'route' => 'materials.index',
                    'can' => 'jefe-red'
                ],

            ],
            'can' => 'jefe-red'
        ],
        // [
        //     'text' => 'Descargo de material',
        //     'route'  => 'descargo.index',
        //     'icon' => 'fa fa-fw fa-file-pdf',
        //     // 'can' => 'informes.index',
        // ],

        [
            'header' => 'ESTADO SOLICITUDES',
            'can' => 'Secretaria'
        ],
        [
            'text' => 'Monitoreo de Solicitudes',
            'route'  => 'monitoreo.index_secre',
            'icon' => 'fas fa-eye',
            'can' => 'Secretaria',

        ],
        [
            'header' => 'REPORTES',
            'can' => 'jefe-red'
        ],
        [
            'text'    => 'Reportes',
            'submenu' => [
                [
                    'text' => 'Reporte Inversión',
                    'route'  => 'proyectos.reporte',
                    'icon' => 'fas fa-fw fa-folder ',
                    'can' => 'jefe-red',
                ],
                [
                    'text' => 'Reporte Ampliaciones',
                    'icon' => 'fas fa-fw fa-folder',
                    'route' => 'proyectos.reporte_ampliaciones',
                    'can' => 'jefe-red'
                ],

            ],
            'can' => 'jefe-red'
        ],
        // [
        //     'text'       => 'information',
        //     'icon_color' => 'cyan',
        //     'url'        => '#',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.min.css',
                ],
            ],
        ],
        'Pace' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/pace/blue/pace-theme-flash.css',
                    // 'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/pace/pace.min.js',
                    // 'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'funciones' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/funciones/funciones.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/funciones/estilos.css',
                ],
            ],
        ],
        'funciones' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/funciones/funciones.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/funciones/estilos.css',
                ],
            ],
        ],
        // [
        //     'name' => 'AdminLTE-Components-DG',
        //     'active' => true,
        //     'files' => [
        //         [
        //             'type' => 'js',
        //             'asset' => true,
        //             'location' => '/vendor/dg-plugins/moment/moment.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => true,
        //             'location' => '/vendor/dg-plugins/moment/moment-with-locales.min.js',
        //         ],
        //         [
        //             'type' => 'css',
        //             'asset' => true,
        //             'location' => '/vendor/dg-plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => true,
        //             'location' => '/vendor/dg-plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => true,
        //             'location' => '/vendor/dg-plugins/daterangepicker/daterangepicker.js',
        //         ],
        //         [
        //             'type' => 'css',
        //             'asset' => true,
        //             'location' => '/vendor/dg-plugins/daterangepicker/daterangepicker.css',
        //         ],
        //     ],
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => false,
];
