<?php

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/engine.js',
        'js/jquery.priceformat.min.js',
        'js/tooltipster.bundle.min.js'
    ];
    public $depends = [
        'frontend\assets\JqueryAsset'
    ];

    public function init()
    {
        parent::init();

        $this->css = [
            Yii::$app->mobileDetect->isMobile() ? 'css/mobile.css' : 'css/calculator.css',
            'css/tooltipster.bundle.css'
        ];

    }

    //public $jsOptions = [ 'position' => \yii\web\View::POS_HEAD ];
}
