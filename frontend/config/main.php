<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Api'
        ],
    ],
    'components' => [
        'assetManager' => [
            'forceCopy' => !YII_ENV_PROD,
            //'appendTimestamp' => true,
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
        ],
        'calculator' => [
            'class' => 'frontend\widgets\bitcoinCalculator\Calculator',
            'exchangeRateURLs' => [
                'bitfinex' => 'https://www.cryptocoincharts.info/markets/show/bitfinex',
                'poloniex' => 'https://www.cryptocoincharts.info/markets/show/poloniex',
                'kraken' => 'https://www.cryptocoincharts.info/markets/show/kraken',
                'yobit' => 'https://www.cryptocoincharts.info/markets/show/yobit',
                'btc-e' => 'https://www.cryptocoincharts.info/markets/show/btc-e',
                'quoine' => 'https://www.cryptocoincharts.info/markets/show/quoine',
                'bittrex' => 'https://www.cryptocoincharts.info/markets/show/bittrex',
                'hitbtc' => 'https://www.cryptocoincharts.info/markets/show/hitbtc',
                'okcoin' => 'http://www.cryptocoincharts.info/markets/show/okcoin'
            ],
            'servers' => [
                's9' => [
                    'class' => 'frontend\widgets\bitcoinCalculator\servers\S9Server',
                    'price' => 1245, //Price per S9 unit
                    'hashRate' => 12500, //Hash rate per unit GH/s
                    'powerWatt' => 1576, //Power per unit, W
                    'blockReward' => 12.50,//Block reward
                    'difficultyIncrease' => 0.08, //Difficulty increase
                    'conversionIncrease' => 0.08, //Conversion increase
                    'hostingFees' => 3.3,// cost per KW/h
                    'poolFees' => 0 //Pool Fees
                ]
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'fileCache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'exchange-rate' => 'site/bitcoin-cost',
                'calculate' => 'site/calculate',
                'calculations/<data:.+>' => 'site/calculation-pdf',
                'order' => 'site/order'
            ],
        ],
    ],
    'params' => $params,
];
