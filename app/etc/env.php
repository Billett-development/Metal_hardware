<?php
return [
    'backend' => [
        'frontName' => 'SDF4fdsa_sdfeasdfAASDeraag4_asdfEfasTOMdf4dDFSA3_34aA'
    ],
    'crypt' => [
        'key' => '6c96f483c9991754d546d6202f11b4fc'
    ],
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => 'devserver.ci3uj2kvqvcg.eu-west-2.rds.amazonaws.com',
                'dbname' => 'magento2_db',
                'username' => 'admin',
                'password' => '%\'m4rB1301\'%',
                'active' => '1'
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'developer',
    'session' => [
        'save' => 'files'
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '40d_'
            ],
            'page_cache' => [
                'id_prefix' => '40d_'
            ]
        ]
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => NULL
        ]
    ],
    'cache_types' => [
        'config' => 0,
        'layout' => 0,
        'block_html' => 0,
        'collections' => 0,
        'reflection' => 0,
        'db_ddl' => 0,
        'compiled_config' => 0,
        'eav' => 0,
        'customer_notification' => 0,
        'config_integration' => 0,
        'config_integration_api' => 0,
        'full_page' => 0,
        'config_webservice' => 0,
        'translate' => 0,
        'vertex' => 0
    ],
    'install' => [
        'date' => 'Fri, 16 Aug 2019 07:52:11 +0000'
    ]
];
