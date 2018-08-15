<?php

return [
    'components' => [
//        'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=localhost;dbname=suflist',
//            'username' => 'root',
//            'password' => '',
//            'charset' => 'utf8',
//        ],
       'db' => [
           'class' => 'yii\db\Connection',
           'dsn' => 'mysql:host=localhost;dbname=iconsult_myschedule',
           'username' => 'admin',
           'password' => 'OwoLFbt4UsbP', // this change on docker run
           'charset' => 'utf8',
       ],
        // 'db' => [
        //     'class' => 'yii\db\Connection',
        //     'dsn' => 'mysql:host=localhost;dbname=iconsult_myschedule',
        //     'username' => 'iconsult_carlos',
        //     'password' => 'iConsulting360',
        //     'charset' => 'utf8',
        // ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'noreplyiconsulting.group@gmail.com',
                'password' => 'confidencial',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
];
