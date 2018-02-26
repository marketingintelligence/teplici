<?php

return array(
    'basePath'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'           => 'Вернуться на сайт',

    'preload'        => array(
        'log',
        'bootstrap',
		'languages',
    ),
    'sourceLanguage' => 'ru',
    'language'       => 'ru',
    //bootstrap

    'import'         => array(
        'application.models.*',
        'application.widgets.*',
        'application.components.*',
        'application.modules.timesafe.components.*',
        'ext.bootstrap.widgets.*',
        'ext.yiiext.components.shoppingCart.*'

    ),

    'modules'        => array(
        'timesafe',
        'vii' => array(
            'generatorPaths' => array(
                'application.gii',
            ),
            'class'          => 'application.vii.ViiModule',
            'password'       => '123',
            'ipFilters'      => array('127.0.0.1', '192.168.254.23', '192.168.254.50', '192.168.254.40'),
        ),
    ),

    'components'     => array(

        'phpBB'=>array(
            'class'=>'ext.phpBB.phpBB',
            'path'=>'webroot.forum',
        ),
        /*'user'=>array(
            'class'=>'PhpBBWebUser',
            'loginUrl'=>array('/site/login'),
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),*/
        'request'=>array(
            // Возможно это и костыль, но без него никуда не поехать, тут мы определяем базовый URL нашего приложения.
            'baseUrl'=>$_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'] != $_SERVER['SCRIPT_FILENAME'] ? 'http://'.$_SERVER['HTTP_HOST'] : '',
            // ...
        ),
        'user'        => array(
            'class'          => 'RWebUser',
            'allowAutoLogin' => true,
        ),

        'authManager' => array(
            'class' => 'RDbAuthManager',
        ),
        // 'cache' => array(
        //     'class' => 'CDbCache',
        // ),
        'urlManager'  => array(
            'showScriptName' => false,
            'urlFormat'      => 'path',
            'urlSuffix'      => '.html',
            'rules'          => array(
                /*'p/<id:\w+>'          => 'article/show',
                'upload/<path:[\/.\-_\w]+>'=> 'upload/render',
				'map'=>'site/map',*/

                'authorization'=>'site/authorization',
                'registration'=>'site/registration',
                'exit'=>'site/exit',
                'news/<url:[\w_-]+>'=>'news/show',

            ),
        ),

        'cache'=>array(
            'class'=>'CDbCache',
            'connectionID'=>'db'
        ),

		'db'          => array(
            'connectionString'   => 'mysql:host=localhost;dbname=teplici',
            'emulatePrepare'     => true,
            'username'           => 'root',
            'password'           => '',

            'charset'            => 'utf8',
            'enableProfiling'    => true,
            'enableParamLogging' => true
        ),

        'log'         => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'     => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('127.0.0.1', '192.168.254.23', '192.168.254.50', '192.168.254.40'),
                ),
//                array(
//                    'class' => 'CFileLogRoute',
//                    'levels' => 'error, warning',
//                ),
                // uncomment the following to show log messages on web pages

//                    array(
//                        'class'=>'CWebLogRoute',
//                    ),

            ),
        ),
        'clientScript'=>array(
            'scriptMap'=>array(
               // 'jquery.min.js'=>false,
            ),
           // 'enableJavaScript'=>false,    // Эта опция отключает любую генерацию javascript'а фреймворком
        ),
        'messages'=>array(
            'class'=>'CDbMessageSource',
            'sourceMessageTable'=>'sys_SourceMessage',
            'translatedMessageTable'=>'sys_Message',
            'onMissingTranslation'=>array('MissingMessages', 'load'),
        ),
    ),
    'params'         => array(
        'adminEmail'   => 'savezhanov@maint.kz',
        'noreplyEmail' => 'savezhanov@maint.kz',
    ),
);
