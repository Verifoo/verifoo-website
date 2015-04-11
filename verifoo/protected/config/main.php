<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Verifoo Business Search',

	// preloading 'log' component
	'preload'=>array('log'),
	'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
    ),
	// autoloading model and component classes

	'import'=>array(
		
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
		'application.modules.user.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.rights.components.dataproviders.RAuthItemDataProvider',
        
        'bootstrap.helpers.TbHtml',
        'bootstrap.helpers.TbArray',
	    'bootstrap.behaviors.TbWidget',
	    'bootstrap.behaviors.*',
        'bootstrap.helpers.*',
        'bootstrap.widgets.*',
       'bootstrap.components.*',
	    'application.helpers.*', // yii image
	    'ext.SAImageDisplayer.*',// SAImageDisplayer
	    'ext.easyimage.EasyImage',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths' => array('bootstrap.gii'),
		),
		'user'=>array(
	            'hash' => 'md5',
	            'sendActivationMail' => true,
	 			'loginNotActiv' => false,
                'tableUsers' => 'users',
                'tableProfiles' => 'profiles',
                'tableProfileFields' => 'profiles_fields',
               // 'profileRelations'=>array(
                 //       'team'=>array(CActiveRecord::BELONGS_TO, 'Team', 'team_id'),
                 //       ),
        ),
        'rights'=>array(
                'install'=>false,
                'debug'=>true
        ),
		'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',
            # send activation email
            'sendActivationMail' => true,
            # allow access for non-activated users
            'loginNotActiv' => false,
 			# activate user on registration (only sendActivationMail = false)
            //'activeAfterRegister' => false, 
            # automatically login from registration
            //'autoLogin' => true,
            # registration path
            'registrationUrl' => array('/user/registration'),
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
            # login form path
            'loginUrl' => array('//user/login'),
            # page after login
            'returnUrl' => array('/user/profile'),
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
	),

	// application components
	'components'=>array(
		'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',   
        ),
        'easyImage' => array(
		    'class' => 'application.extensions.easyimage.EasyImage',
		    //'driver' => 'GD',
		    //'quality' => 100,
		    //'cachePath' => '/assets/easyimage/',
		    //'cacheTime' => 2592000,
		    //'retinaSupport' => false,
		  ),
		'cache' => array('class' => 'system.caching.CDummyCache'),
		'clientScript'=>array(
            'packages'=>array(
                'jquery'=>array(
                    'baseUrl'=>'/js/',
                    'js'=>array('jquery.1.8.2.min.js',),
                )
            ),
        ),
        'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
        'widgetFactory'=>array(
            'widgets'=>array(
                'SAImageDisplayer'=>array(
                   'baseDir' => 'uploads/images',
                    'originalFolderName'=> 'originals',
                    'sizes' =>array(
                        'p190' => array('width' => 190, 'height' => 190),	
                        'p128' => array('width' => 128, 'height' => 128),
                        'big' => array('width' => 640, 'height' => 480),
                        'thumb' => array('width' => 400, 'height' => 300),
                    ),
                    'groups' => array(
                    	'users' => array(
                    		'p800' => array('width' => 800, 'height' => 800),
                    		'p190' => array('width' => 190, 'height' => 190),	
                            'p128' => array('width' => 128, 'height' => 128),
                            'p160' => array('width' => 160, 'height' => 160),
                            'p64' => array('width' => 64, 'height' => 64),
                            'p32' => array('width' => 32, 'height' => 32),
                          ),
                        'news' => array(
                            'tiny' => array('width' => 40, 'height' => 30),
                            'big' => array('width' => 640, 'height' => 480),
                          ),
                        'business' => array(
                            'p240' => array('width' => 240, 'height' => 240),
                            'p160' => array('width' => 160, 'height' => 160),
                          ),
                      /*  'reviews' => array(
                            'thumb' => array('width' => 400, 'height' => 300),
                         ),*/ 
                    ),
                ),
            ),
        ),
        // uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'profile/friends/<id:\d>'=>'profile/friends',
				'home' => 'site/index',
				'<alias:about>' => 'site/page',
				'page/<alias>' => 'site/page',
		 		'page/<name>-<id:\d+>.html'=>'cms/node/page', // clean URLs for pages
			),
		),
		'user'=>array(
            // enable cookie-based authentication
            'class' => 'RWebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login'),
        ),
		 
		'authManager'=>array(
                'class'=>'RDbAuthManager',
                'assignmentTable'=>'authassignment',
                'connectionID'=>'db',
                'defaultRoles'=>array('Authenticated', 'Guest'),
        ),
		
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=verifoo_db',
			//'connectionString' => 'mysql:host=localhost;dbname=verifoo_production',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			/*'username' => 'verifoo_pro',
			'password' => 'MOnGOL#2',*/
			'charset' => 'utf8',
			'enableParamLogging'=>true,
			'tablePrefix' => '',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		/*'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),/*delete the open tag of this comment*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'effie@verifoo.com',
	),
);