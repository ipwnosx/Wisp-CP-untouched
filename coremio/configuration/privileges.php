<?php
    return [
        'privileges' => [
            'ACCOUNT' => [
                'EDIT_YOUR_ACCOUNT',
            ],
            'DASHBOARD' => [
                'DASHBOARD_STATISTIC_INCOME',
                'DASHBOARD_STATISTIC_CASH',
                'DASHBOARD_STATISTIC_USER',
                'DASHBOARD_STATISTIC_TICKETS',
                'DASHBOARD_STATISTIC_OVINV',
                'DASHBOARD_STATISTIC_UPDS',
                'DASHBOARD_STATISTIC_SEPS',
                'DASHBOARD_STATISTIC_TYRS',
                'DASHBOARD_PANEL_LAST_ORDERS',
                'DASHBOARD_PANEL_NOTES',
                'DASHBOARD__PANEL_ONLINES',
                'DASHBOARD__PANEL_CLIENT_ONLINES',
                'DASHBOARD_PANEL_PENDING_INVOICES',
                'DASHBOARD_PANEL_PENDING_TICKETS',
                'DASHBOARD_PANEL_REMINDERS',
                'DASHBOARD_PANEL_TASKS',
            ],
            'SETTINGS' => [
                'SETTINGS_FRAUD_PROTECTION',
                'SETTINGS_INFORMATIONS_CONFIGURE',
                'SETTINGS_THEME_CONFIGURE',
                'SETTINGS_HOME_CONFIGURE',
                'SETTINGS_LOCALIZATION_CONFIGURE',
                'SETTINGS_SEO_CONFIGURE',
                'SETTINGS_BACKGROUNDS_CONFIGURE',
                'SETTINGS_MEMBERSHIP_CONFIGURE',
                'SETTINGS_OTHER_CONFIGURE',
            ],

            'NOTIFICATIONS' => [
                'NOTIFICATIONS_TEMPLATES',
            ],

            'FINANCIAL' => [
                'FINANCIAL_TAXATION',
                'MODULES_PAYMENT_SETTINGS',
                'FINANCIAL_CURRENCIES',
                'FINANCIAL_PROMOTIONS',
                'FINANCIAL_COUPONS',
            ],

            'SECURITY' => [
                'SECURITY_SETTINGS',
                'SECURITY_BACKUP',
            ],
            'ADMIN' => [
                'ADMIN_CONFIGURE',
                'ADMIN_PRIVILEGES',
                'ADMIN_DEPARTMENTS',
            ],

            'AUTOMATION' => [
                'AUTOMATION_SETTINGS',
            ],

            'MODULES' => [
                'MODULES_MAIL_SETTINGS',
                'MODULES_SMS_SETTINGS',
                'MODULES_REGISTRARS_SETTINGS',
                'MODULES_SERVERS_SETTINGS',
            ],

            'PRODUCTS' => [
                'PRODUCTS_LOOK',
                'PRODUCTS_OPERATION',
                'PRODUCTS_GROUP_LOOK',
                'PRODUCTS_GROUP_OPERATION',
                'PRODUCTS_API',
            ],

            'ORDERS' => [
                'ORDERS_LOOK',
                'ORDERS_OPERATION',
                'ORDERS_DELETE',
            ],

            'INVOICES' => [
                'INVOICES_LOOK',
                'INVOICES_OPERATION',
                'INVOICES_DELETE',
                'INVOICES_CASH',
            ],

            'CONTACT_FORM' => [
                'CONTACT_FORM_LOOK',
                'CONTACT_FORM_OPERATION',
                'CONTACT_FORM_DELETE',
            ],

            'TICKETS' => [
                'TICKETS_LOOK',
                'TICKETS_OPERATION',
                'TICKETS_DELETE',
                'TICKETS_PREDEFINED_REPLIES',
                'TICKETS_CUSTOM_FIELDS',
            ],

            'KNOWLEDGEBASE' => [
                'KNOWLEDGEBASE_LOOK',
                'KNOWLEDGEBASE_OPERATION',
                'KNOWLEDGEBASE_DELETE',
            ],

            'USERS' => [
                'USERS_LOOK',
                'USERS_OPERATION',
                'USERS_DELETE',
                'USERS_MANAGE_CREDIT',
                'USERS_AFFILIATE',
                'USERS_DEALERSHIP',
                'USERS_DOCUMENT_VERIFICATION',
                'USERS_BLACKLIST',
            ],

            'MANAGE_WEBSITE' => [
                'MANAGE_WEBSITE_LOOK',
                'MANAGE_WEBSITE_OPERATION',
                'MANAGE_WEBSITE_DELETE',
            ],
            'WANALYTICS' => ['WANALYTICS'],
            'TOOLS' => [
                'TOOLS_ADDONS',
                'TOOLS_BULK_MAIL',
                'TOOLS_BULK_SMS',
                'TOOLS_SMS_LOGS',
                'TOOLS_MAIL_LOGS',
                'TOOLS_ACTIONS',
                'TOOLS_IMPORTS',
                'TOOLS_REMINDERS',
                'TOOLS_TASKS',
                Config::get("general/country") == "tr" ? 'TOOLS_BTK_REPORTS' : '',
            ],

            'LANGUAGES' => [
                'LANGUAGES_LOOK',
                'LANGUAGES_OPERATION',
            ],

            'HELP' => [
                'HELP_HEALTH',
                'HELP_UPDATES_LOOK',
                'HELP_UPDATES_OPERATION',
                'HELP_LICENSE',
                'HELP_USE_GUIDE',
            ],

            'EDITOR' => [
                'UPLOAD_EDITOR_PICTURE',
            ],
        ],
    ];