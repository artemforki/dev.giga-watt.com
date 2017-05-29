<section id="screen-0" class="screen-0">
    <header><a href="/"><img src="/img/svg/logo.svg"></a></header>
    <div class="screen-0_text" id="header_text">
        <span class="screen-0_text_animated t1 span30">Would you like to know how much</span>
        <span class="screen-0_text_animated t2">BITCOIN</span>
        <span class="screen-0_text_animated span30 t3">is really worth?</span>
        <span class="screen-0_text_animated t4 span22">YOU WILL BE SHOCKED TO FIND OUT THE REAL GAIN:&nbsp;&nbsp;</span>
        <span class="screen-0_text_animated t6 span36 <?= $profit >= 100 ? ' digit3' : '' ?>"><?= $profit ?>%</span>
        <span class="screen-0_text_animated t5"><div class="btn" id="scroll_down">SHOW PRICES</div></span>
    </div>
</section>
<div class="wrap-container">
    <section class="block with_down_arrow" id="screen-1">
        <span class="title"><span class="title_num">1. </span>You can buy Bitcoin</span>
        <span class="sub-title">CHOOSE THE BEST OFFER ON THE MARKET</span>
        <div class="block_currency">
            <?php foreach ($groups as $name => $item): ?>
                <a class="block_currency_item" href="<?= $item['url'] ?>" target="_blank">
                    <div class="block_currency_item_logo <?php echo $name ?>"></div>
                    <div class="block_currency_item_block">
                        <div class="block_currency_item_block_pair">BTC / USD</div>
                        <div class="block_currency_item_block_cost"><?php echo number_format($item['rate'], 1) ?></div>
                    </div>
                    <div class="block_currency_item_change <?php echo $item['dynamic'] > 0 ? 'positive' : ($item['dynamic'] < 0 ? 'negative' : '') ?>"><?php echo number_format(
                            $item['dynamic'], 2) ?>%
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <span class="block_avg span36">1 btc<span></span><?php echo number_format($avg_groups, 1) ?> usd</span>
    </section>
    <section class="block with_down_arrow">
        <span class="title"><span class="title_num">2. </span>You can mine your own Bitcoin</span>
        <span class="sub-title">CALCULATE HOW MUCH IT WILL COST YOU TO MINE</span>
        <div class="block_currency min-input">
            <form action="/calculate" method="POST" id="input_self_result">
                <div class="block_input">
                    <div class="block_input_title inform-question" data-hint="Cost of your miner, USD" data-mobile>Mainer
                        cost
                    </div>
                    <div class="block_input_box hosting-fee">
                        <input type="text" value="1200" type-number name="Server[price]">
                    </div>
                </div>
                <div class="block_input">
                    <div class="block_input_title inform-question"
                         data-hint="Performance of your miner, GH/s" data-mobile>Hash Rate
                    </div>
                    <div class="block_input_box hash-rate">
                        <input type="text" value="11500" type-number name="Server[hashRate]">
                    </div>
                </div>
                <div class="block_input">
                    <div class="block_input_title inform-question"
                         data-hint="Power consumption of your miner, W" data-mobile>Power consumption
                    </div>
                    <div class="block_input_box power-watt">
                        <input type="text" value="1500" type-number name="Server[powerWatt]">
                    </div>
                </div>
                <div class="block_input">
                    <div class="block_input_title inform-question" data-hint="Electricity and other hosting costs, kW/h<br/>In you mine at home, enter electricity costs here." data-mobile>Cost per
                        KW/h
                    </div>
                    <div class="block_input_box hosting-cent">
                        <input type="text" value="15.00" type-price name="Server[hostingFees]">
                    </div>
                </div>
            </form>
        </div>
        <span class="block_equal span36">1 btc<span></span><b id="self_server_result_usd"><?php echo number_format(
                    $avg_groups, 1) ?></b> usd</span>
        <div class="block_result">
            <span class="block_result_num span36" id="self_server_result">0%</span>
            <span class="block_result_text">CHEAPER THAN BUYING</span>
        </div>
    </section>
    <section class="block">
        <span class="title"><span class="title_num">3. </span>You can mine Bitcoin with </span>
        <a class="title_with_logo" href="https://cryptonomos.com/wtt/"></a>
        <span class="block_equal big"><div>1 btc</div><span>&nbsp;</span><b id="self_server_result_usd"><?= $rate ?> usd</b></span>
        <div class="block_result">
            <span class="block_result_num span36<?= $profit < 100 ? ' digit2' : '' ?>"
                  id="self_server_result"><?= $profit ?>%</span>
            <span class="block_result_text">CHEAPER THAN BUYING</span>
        </div>
        <span class="block_inform">Calculation for T9 miners. Price for WTT token holders. Details at <a
                    href="http://cryptonomos.com" target="_blank">cryptonomos.com</a></span>
        <div class="block_subscription">
            <span class="title span48">Want to see detailed financial model?</span>
            <span class="sub-title">WE CAN CALCULATE YOUR MINING REWARDS FOR THE NEXT 3 YEARS</span>
            <div class="block_currency">
                <form action="/order" method="POST" id="form_order">
                    <div class="block_input">
                        <div class="block_input_title">Equipment cost</div>
                        <div class="block_input_box hosting-fee">
                            <input type="text" value="10000" type-number name="Client[investmentSum]">
                        </div>
                    </div>
                    <div class="block_input">
                        <div class="block_input_title">Your email</div>
                        <div class="block_input_box">
                            <input type="email" value="" type-email name="Client[email]">
                        </div>
                    </div>
                    <div class="btn" id="btn_order" onclick="Btc.order();">GET YOUR CALCULATIONS</div>
                </form>
            </div>
            <span class="block_inform">Your email address is safe: We will not share it with anybody.</span>
        </div>
    </section>
    <section class="block with_down_line advantages">
        <span class="title">Advantages</span>
        <span class="sub-title">GIGA WATT</span>
        <div class="advantages_block">
            <div class="advantages_block_item">
                <span class="circle span36">2.8&cent;<br/><b class="span22">kW/h</b></span>
                <span class="service span22">Electricity</span>
                <span class="service_desc span16">Effective elecricity rate</span>
            </div>
            <div class="advantages_block_item">
                <span class="circle span36">0.5&cent;<br/><b class="span22">kW/h</b></span>
                <span class="service span22">MAINTENANCE</span>
                <span class="service_desc span16">Ongoing support</span>
            </div>
            <div class="advantages_block_item">
                <span class="circle span36">16<br/><b class="span22">nm</b></span>
                <span class="service span22">Equipment</span>
                <span class="service_desc span16">S9 and T9 bitcoin miners</span>
            </div>
            <div class="advantages_block_item">
                <span class="circle span36">0<br/><b class="span22">days</b></span>
                <span class="service span22">DownTime</span>
                <span class="service_desc span16">On-site service center</span>
            </div>
        </div>
    </section>
    <section class="about">
        <a class="about_logo" href="https://cryptonomos.com/wtt/"></a>
        <span class="about_text">See details at</span>
        <a class="about_site" href="https://cryptonomos.com/wtt/">cryptonomos.com</a>
    </section>
</div>
<?php

use \yii\helpers\Html;


/*
echo Html::tag('div', 'BTC/USD average: ' . Yii::$app->calculator->getExchangeRate(), [
    'style' => 'margin: 20px 0;'
]);

$group = Yii::$app->calculator->getCurrencyGroup();
echo Html::beginTag('table', [
    'class' => 'exchange-rate',
]);
echo Html::beginTag('tr');
echo Html::tag('td', 'URL');
echo Html::tag('td', 'RATE');
echo Html::endTag('tr');

foreach ($group as $row) {
    echo Html::beginTag('tr');
    echo Html::tag('td', Html::a($row['url'], $row['url']));
    echo Html::tag('td', '$'.$row['rate']);
    echo Html::endTag('tr');
}
echo Html::endTag('table');

echo \frontend\widgets\bitcoinCalculator\Widget::widget(['actionUrl' => \yii\helpers\Url::to('site/calculate')]);
*/