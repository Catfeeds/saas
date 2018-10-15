<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'sourceLanguage' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'version' => '1.0',
    'modules' => [
        'v1' => [
            'class' => 'backend\modules\v1\Module',
        ],
        'v2' => [
            'class' => 'backend\modules\v2\Module',
        ],
        'v3' => [
            'class' => 'backend\modules\v3\Module',
        ],
        'rbac' => [
            'class' => 'backend\\rbac\\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf_backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'keyPrefix' => 'backend_',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'user' => [
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'as adminLog' => 'backend\\behaviors\\AdminLogBehavior',
    'as permission' => 'backend\\rbac\\PermissionBehaviors',
    'params' => $params,
];
