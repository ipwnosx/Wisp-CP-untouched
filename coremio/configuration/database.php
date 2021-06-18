<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    return [
        'database' =>
            [
                'driver' => 'mysql',
                'tool' => 'pdo',
                'host' => 'localhost',
                'port' => '3306',
                'prefix' => '',
                'name' => '',
                'username' => '',
                'password' => '',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'language-tables' =>
                    [
                        'slides_lang',
                        'countries_lang',
                        'categories_lang',
                        'customer_feedbacks_lang',
                        'knowledgebase_lang',
                        'menus_lang',
                        'pages_lang',
                        'products_lang',
                        'products_addons_lang',
                        'products_requirements_lang',
                        'tickets_departments_lang',
                        'tickets_predefined_replies_lang',
                        'tickets_custom_fields_lang',
                    ],
            ],
    ];