<?php
    /**
     * @author Sitemio Bilişim Teknolojileri Tic. Ltd. Şti.
     * @project Sitemio Temel Kaynak Kod Çekirdek Yapısı
     * @date 2017-07-01 09:00 AM
     * @contract http://www.sitemio.com/hizmet-sozlesmesi.html
     * @copyright Tüm Hakları Sitemio Bilişim Teknolojileri Tic. Ltd. Şti. adına saklıdır
     * @warning Lisanssız kopyalanamaz, dağıtılamaz ve kullanılamaz.
     **/

    defined('CORE_FOLDER') OR exit('You can not get in here!');
    return
        ['admin-routes' =>
             [
                 'dashboard'        => ['dashboard','index'],
                 'sign-in'          => ['login','sign/in'],
                 'sign-out'         => ['logout','sign/out'],
                 'sign-forget'      => ['forget-password','sign/forget'],
                 'ac-settings'      => ['my-account','ac-settings'],
                 'settings'         => ['settings','settings'],
                 'settings-p'       => ['settings/(?)','settings/(1)'],
                 'admins-p'         => ['admins/(?)','admins/(1)'],
                 'admins'           => ['admins','admins'],
                 'admins-dl'        => ['admin/(?)','admins/detail/(1)'],
                 'privileges-dl'    => ['privilege/(?)','privileges/detail/(1)'],
                 'privileges'       => ['privileges','privileges'],
                 'privileges-p'     => ['privileges/(?)','privileges/(1)'],
                 'departments'      => ['departments','departments'],
                 'modules'          => ['module/(?)','modules/(1)'],
                 'financial'        => ['financial/(?)','financial/(1)'],
                 'products-2'       => ['products/(?)/(?)','products/(1)/(2)'],
                 'products'         => ['products/(?)','products/(1)'],
                 'languages'        => ['languages','languages'],
                 'languages-1'      => ['languages/(?)','languages/(1)'],
                 'orders-2'         => ['orders/(?)/(?)','orders/(1)/(2)'],
                 'orders-1'         => ['orders/(?)','orders/(1)'],
                 'orders'           => ['orders','orders'],
                 'users-2'          => ['customers/(?)/(?)','users/(1)/(2)'],
                 'users-1'          => ['customers/(?)','users/(1)'],
                 'users'            => ['customers','users'],
                 'invoices-2'       => ['invoices/(?)/(?)','invoices/(1)/(2)'],
                 'invoices-1'       => ['invoices/(?)','invoices/(1)'],
                 'invoices'         => ['invoices','invoices'],
                 'tickets-2'        => ['tickets/(?)/(?)','tickets/(1)/(2)'],
                 'tickets-1'        => ['tickets/(?)','tickets/(1)'],
                 'tickets'          => ['tickets','tickets'],
                 'tools-2'          => ['tools/(?)/(?)','tools/(1)/(2)'],
                 'tools-1'          => ['tools/(?)','tools/(1)'],
                 'tools'            => ['tools','tools'],
                 'manage-website-2' => ['manage-website/(?)/(?)','manage-website/(1)/(2)'],
                 'manage-website-1' => ['manage-website/(?)','manage-website/(1)'],
                 'manage-website'   => ['manage-website','manage-website'],
                 'knowledgebase-2'  => ['knowledgebase/(?)/(?)','knowledgebase/(1)/(2)'],
                 'knowledgebase-1'  => ['knowledgebase/(?)','knowledgebase/(1)'],
                 'knowledgebase'    => ['knowledgebase','knowledgebase'],
                 'download-id'      => ['download/(?)/(?)', 'download/(1)/(2)'],
                 'download'         => ['download/(?)', 'download/(1)'],
                 'notifications-2'  => ['notifications/(?)/(?)', 'notifications/(1)/(2)'],
                 'notifications-1'  => ['notifications/(?)', 'notifications/(1)'],
                 'notifications'    => ['notifications', 'notifications'],
                 'automation'       => ['automation-settings', 'automation'],
                 'help-2'           => ['help/(?)/(?)','help/(1)/(2)'],
                 'help-1'           => ['help/(?)','help/(1)'],
                 'help'             => ['help','help'],
             ]
        ];