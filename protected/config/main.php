<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Modern Times',
    
	// 'theme'=>'bootstrap',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
                'application.models.relations.*',
                'application.models.forms.*',
		'application.components.*',
                'application.components.events.*',
                'application.components.events.behaviors.*',
                'application.components.widgets.*',
                'application.controllers.actions.*',
                'application.controllers.actions.battle.*',
                'application.controllers.actions.inventory.*',
                'application.controllers.actions.shop.*',
                'application.controllers.actions.consultant.*',

		/**
                'ext.bootstrap-theme.widgets.*',
		'ext.bootstrap-theme.helpers.*',
		'ext.bootstrap-theme.behaviors.*',
                */
            
                'ext.giix-components.*', // giix components
                'ext.Kint.*',
                'ext.EUserFlash',
            
                'application.modules.user.models.*',
                'application.modules.user.components.*',
        ),

        'preload'=>array(
            'log',
            'kint', // To be able to use d(), dd(), s() and sd()
            'cd', // Initializes global static function CD() which returns the Character model
            'bootstrap',
        ),

	'modules'=>array(
            // 'game',

            'user'=>array(
                    'loginUrl' => array('/user/login'),
                    'returnUrl' => array('/site/manageCharacters'),
                    // 'tableUsers' => 'mt_users',
                    // 'tableProfiles' => 'mt_profiles',
                    // 'tableProfileFields' => 'mt_profiles_fields',
            ),
            
            'gii'=>array(
                'class'=>'system.gii.GiiModule',
                'generatorPaths' => array(
                        'ext.giix-core', // giix generators
                        'ext.gtc',       // gii template collection
                        'bootstrap.gii', // since 0.9.1
                        // 'ext.bootstrap-theme.gii',
                ),
                'password'=>'pass',
                // If removed, Gii defaults to localhost only. Edit carefully to taste.
                'ipFilters'=>array('127.0.0.1','::1'),
            ),
	),

	// application components
	'components'=>array(
            // Nice var_dump alternative
            'kint' => array(
                'class' => 'ext.Kint.Kint',
            ),

            'cache'=>array(
                'class'=>'CFileCache',
            ),
            
            'user'=>array(
                    'loginUrl' => array('/user/login'),
                    'returnUrl' => array('/site/manageCharacters'),
                    // enable cookie-based authentication
                    'allowAutoLogin'=>true,
                    // makes it possible to display flash messages after redirects
                    'autoUpdateFlash' => false, 
            ),

            'urlManager'=>array(
                    'urlFormat'=>'path',
                    'showScriptName'=>false,
                    'rules'=>array(
                            '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                            '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    ),
            ),

            'session',

            'db'=>array(
                    'connectionString' => 'mysql:host=localhost;dbname=mt',
                    'emulatePrepare' => true,
                    'username' => 'root',
                    'password' => '',
                    'charset' => 'utf8',
                    'tablePrefix' => 'mt_',

                    'enableProfiling' => true,
                    // Set to false in deployment
                    'enableParamLogging' => true,

                    // Increase in deployment to reduce number of SQL queries drastically
                    'schemaCachingDuration' => 300,
            ),

            /*
            'authManager'=>array(
                'class'=>'CDbAuthManager',
                'connectionID'=>'db',
                'defaultRoles'=>array('registered', 'guest'),
            ),
            */

            'errorHandler'=>array(
                // use 'site/error' action to display errors
                'errorAction'=>'site/error',
            ),

            'log'=>array(
                    'class'=>'CLogRouter',
                    'routes'=>array(
                            array(
                                    'class'=>'CFileLogRoute',
                                    'levels'=>'error, warning',
                            ),
                            array(
                                    'class'=>'application.extensions.pqp.PQPLogRoute',
                                    'categories' => 'application.*, exception.*',
                                    // 'levels'=>'error., warning, trace, info',
                            ),
                    ),
            ),

            'bootstrap'=>array(
                'class'=>'ext.bootstrap.components.Bootstrap',
                /**
                 * whether to register the Bootstrap core CSS 
                 * (bootstrap.min.css), defaults to true
                 */
                'coreCss'=>true, 
                /**
                 * whether to register the Bootstrap responsive CSS 
                 * (bootstrap-responsive.min.css), default to false
                 */
                'responsiveCss'=>false, 
                'plugins'=>array(
                    /**
                     * Optionally you can configure the "global" plugins 
                     *(button, popover, tooltip and transition)
                     * To prevent a plugin from being loaded set it to false
                     */
                    // disable CSS transitions
                    'transition'=>true, 
                    'tooltip'=>array(
                        /**
                         * bind the plugin tooltip to anything with
                         * the tooltip attribute
                         */
                        'selector'=>'*[title]', 
                        'options'=>array(
                            'placement'=>'top', 
                        ),
                    ),
                    /**
                     * If you need help with configuring the plugins, please 
                     * refer to Bootstrap's own documentation:
                     * http://twitter.github.com/bootstrap/javascript.html
                     */
                ),
            ),
            
            'cd'=>array('class'=>'CharacterData'),
            'tools'=>array('class'=>'Tools'),
        ),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);