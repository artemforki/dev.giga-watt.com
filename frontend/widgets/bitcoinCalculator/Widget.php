<?php

namespace frontend\widgets\bitcoinCalculator;

class Widget extends \yii\base\Widget
{
    public $actionUrl;

    public function run(){
        CalculatorAsset::register($this->getView());
        return $this->render('index', [
            'actionUrl' => $this->actionUrl
        ]);
    }
}