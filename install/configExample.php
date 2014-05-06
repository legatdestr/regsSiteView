<?php

return array(
    'sourceLanguage' => 'en',
    'language' => 'ru',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Rg Component',

    'import' => array(
        'application.models.*',
        'application.components.*',
        
        // Rg component
        'ext.regsSiteView.components.*',
    ),
       // Rg constructor module
    'modules' => array(
        'rgdesigner' => array(
            'class' => 'ext.regsSiteView.modules.rgdesigner.RgdesignerModule',
            'dbPrefix' => 'reg_',
            'printFlashes' => true,
            'sendFlashes' => true,
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),

        'db' => array(
            'connectionString' => 'pgsql:host=127.0.1.1;dbname=test',
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
        'request' => array(
            'enableCsrfValidation' => true,
        ),

    ),

);
