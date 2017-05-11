<?php

namespace frontend\widgets\bitcoinCalculator;

use yii\web\AssetBundle;

class CalculatorAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/bitcoinCalculator/assets';
    public $js = ['js/engine.js'];
    public $depends = ['yii\web\JqueryAsset'];
    public $publishOptions = [
        'except' => [
            'js/src'
        ]
    ];
}