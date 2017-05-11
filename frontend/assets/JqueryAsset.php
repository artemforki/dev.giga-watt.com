<?php

namespace frontend\assets;

class JqueryAsset extends \yii\web\JqueryAsset {

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $js = [
        'jquery.min.js'
    ];

}
