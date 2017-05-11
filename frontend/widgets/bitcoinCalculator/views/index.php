<?php

use yii\bootstrap\Html;

//print_r(Yii::$app->calculator->getIdentity('s9')->getBitcoinCost(1, 24));

echo Html::dropDownList('units', 0, [1, 2, 3, 4, 5], [
    'class' => 'form-control table',
    'style' => 'width:150px;display:inline-block',
    'id' => 'units'
]);
echo Html::button('Calculate', ['class' => 'btn', 'data-url' => $actionUrl, 'onclick' => 'BitCoin.calculator.calculate()']);
echo Html::beginTag('div', [
    'id' => 'result',
    'style' => 'margin: 20px 0;'
]);

echo Html::endTag('div');