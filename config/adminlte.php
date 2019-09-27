<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Coupon',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Coupon</b>',

    'logo_mini' => '<b>CPN</b>',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'SITE SETINGS',
        [
            'text' => 'Site setings',
            'can' => 'manage site setings',
            'submenu' => [
                [
                    'text' => 'Logo',
                    'url' => 'site-setings/logo',
                ],
                [
                    'text' => 'Favicon',
                    'url' => '/site-setings/favicon',
                ],
                [
                    'text' => 'Top Offer Icon',
                    'url' => '/site-setings/top-icon',
                ],
                [
                    'text' => 'Search Text',
                    'url' => '/site-setings/edit/search-text',
                ],
            ],
        ],
        'USERS',
        [
            'text' => 'Users',
            'can' => 'manage users',
            'submenu' => [
                [
                    'text' => 'All Users',
                    'url' => '/users',
                ],
                [
                    'text' => 'Add User',
                    'url'  => '/create/user',
                ],
            ]
        ],
        'ROLES',
        [
            'text' => 'Roles',
            'can' => 'manage roles',
            'submenu' => [
                [
                    'text' => 'All Roles',
                    'url' => '/roles',
                ],
                [
                    'text' => 'Add Role',
                    'url'  => '/create/role',
                ],
            ]
        ],
        'SLIDER',
        [
            'text' => 'Slider',
            'can' => 'manage slider',
            'submenu' => [
                [
                    'text' => 'All Slides',
                    'url' => '/slides',
                ],
                [
                    'text' => 'Add Slide',
                    'url'  => '/create/slide',
                ],
            ]
        ],
        'TAGLINE',
        [
            'text' => 'Tagline',
            'can' => 'manage tagline',
            'url' => '/tagline',
        ],
        'SEARCH QUERIES',
        [
            'text' => 'Search Queries',
            'url' => '/search-queries',
        ],
        'BRANDS',
        [
            'text' => 'Brands',
            'can' => 'manage brands',
            'submenu' => [
                [
                    'text' => 'All Brands',
                    'url' => '/brands',
                ],
                [
                    'text' => 'Brands with Offers',
                    'url' => '/brands-with-offers',
                ],
                [
                    'text' => 'Add Brand',
                    'url'  => '/create/brand',
                ],
                [
                    'text' => 'All brand meta tags',
                    'url'  => '/meta/brand',
                    'can' => 'manage seo',
                ],
            ]
        ],
        'OFFER TYPES',
        [
            'text' => 'Offer Types',
            'can' => 'manage offer types',
            'submenu' => [
                [
                    'text' => 'All Offer types',
                    'url' => '/offer-types',
                ],
                [
                    'text' => 'Add Offer Type',
                    'url'  => '/create/offer-type',
                ],
            ]
        ],
        'OFFERS',
        [
            'text' => 'Offers',
            'can' => 'manage offers',
            'submenu' => [
                [
                    'text' => 'All Offers',
                    'url' => '/offers',
                ],
                [
                    'text' => 'Add Offer',
                    'url'  => '/create/offer',
                ],
                [
                    'text' => 'Upload Offer',
                    'url'  => '/upload/csv',
                ],
                [
                    'text' => 'Download Offer',
                    'url'  => '/download/csv',
                ],
                [
                    'text' => 'All offer meta tags',
                    'can' => 'manage seo',
                    'url' => '/meta/offer',
                ],
            ]
        ],
        'CATEGORIES',
        [
            'text' => 'Categories',
            'can' => 'manage categories',
            'submenu'  => [
                [
                    'text' => 'All categories',
                    'url' => '/categories',
                ],
                [
                    'text' => 'Create category',
                    'url' => '/create/category',
                ],
                [
                    'text' => 'Front page categories',
                    'url' => '/front-page/categories',
                ],
                [
                    'text' => 'All category meta tags',
                    'can' => 'manage seo',
                    'url' => '/meta/category',
                ],
                [
                    'text' => 'Exclude keywords',
                    'url' => '/exclude-keywords',
                ],
            ],
            
        ],
        'CUSTOM SEO',
        [
            'text' => 'Custom SEO',
            'can' => 'manage seo',
            'submenu'  => [
                [
                    'text' => 'All custom meta tags',
                    'url' => '/meta/custom',
                ],
                [
                    'text' => 'Create custom meta tag',
                    'url' => '/create/meta/custom',
                ],
            ],
            
        ],
        'POPUPS',
        [
            'text' => 'Popups',
            'can' => 'manage popup',
            'submenu' => [
                [
                    'text' => 'Subscription popup',
                    'url' => '/subscribe/popup',
                ],
                [
                    'text' => 'Redirect popup',
                    'url' => '/redirect/popup'
                ]
            ]
            
        ],
        'CUSTOM PAGES',
        [
            'text' => 'Custom page',
            'can' => 'manage custom pages',
            'submenu'  => [
                [
                    'text' => 'All custom pages',
                    'url' => '/customPages',
                ],
                [
                    'text' => 'Create custom page',
                    'url' => '/create/customPage',
                ],
            ],
            
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
