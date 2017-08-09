<?php
use Yii;

?>
<div style="padding: 20px 60px 30px 60px">
    <div style="width: 100%;display: inline-block;text-align: right;line-height: 50px">
        <img src="/img/letter/btcstat.png" style="float:left;display: inline-block;margin-top: 10px"/>
        <a href="mailto:info@btcstat.net" style="text-decoration: none;color:#ec2809;float:right;display: inline-block">info@btcstat.net</a>
    </div>
    <p style="padding-top: 30px">Detailed financial model for production of Bitcoin</p>
    <table style="width: 100%">
        <tr>
            <td style="width: 60%">
                <table style="width: 100%">
                    <tr style="text-transform: uppercase;font-size: 16px">
                        <td style="padding: 15px 0 0 10px;" colspan="2">
                            <table>
                                <tr>
                                    <td style="border-right: 4px solid #eaeced;display: inline-block;padding: 10px 30px;text-align: center;width: 200px;">
                                        <p
                                                style="margin: 0; padding: 0 0 10px 0;">
                                            Period</p><span
                                                style="font-weight: 700;font-size: 30px;">3 years</span></td>
                                    <td style="display: inline-block;padding: 10px 30px;text-align: center;width: 250px">
                                        <p
                                                style="margin: 0; padding: 0 0 10px 0;">Investments</p>
                                        <span style="font-weight: 700;font-size: 30px;white-space: nowrap"><?= number_format(
                                                $invest, 0, '.', ',') ?>
                                            usd</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:30px">
                            <p style="line-height: 24px">All calculations were made according to the characteristics of
                                T9 Units. If you are interested in other options of the equipment, please write us here:
                                <a href="mailto:info@btcstat.net">info@btcstat.net</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            style="line-height:24px; color:#999999;padding-top: 9cm;padding-left: 60px">

                        </td>
                    </tr>
                </table>
            </td>
            <td style="text-align: right;vertical-align: top">
                <table class="tech">
                    <tr>
                        <td>Investment</td>
                        <td><?= number_format($invest, 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td> Price per T9 unit</td>
                        <td><?= number_format($server->price, 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td> T9 Units
                        </td>
                        <td><?= number_format($server->getCountServerByInvest($invest), 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td>Hash rate per unit GH/s</td>
                        <td><?= number_format($server->hashRate, 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td> Total hash rate GH/s
                        <td><?= number_format(
                                $server->hashRate * $server->getCountServerByInvest($invest), 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td> Power per unit, W
                        </td>
                        <td><?= number_format($server->powerWatt, 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td> Power (Watts)
                        </td>
                        <td><?= number_format(
                                $server->powerWatt * $server->getCountServerByInvest($invest), 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td> Block reward
                        </td>
                        <td><?= number_format($server->blockReward, 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td>Bitcoin to Dollar
                        </td>
                        <td><?= number_format(Yii::$app->calculator->getExchangeRate(), 2, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td> Bitcoin difficulty</td>
                        <td><?= number_format(Yii::$app->calculator->getDifficulty(), 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td> Difficulty increase
                        </td>
                        <td><?= number_format($server->difficultyIncrease*100, 0, '.', ',') ?>%</td>
                    </tr>
                    <tr>
                        <td>Conversion increase
                        </td>
                        <td><?= number_format($server->conversionIncrease*100, 0, '.', ',') ?>%</td>
                    </tr>
                    <tr>
                        <td> Pool Fees
                        </td>
                        <td><?= number_format($server->poolFees, 0, '.', ',') ?>%</td>
                    </tr>
                    <tr>
                        <td> Management fee
                        </td>
                        <td><?= number_format($server->managementFee, 0, '.', ',') ?>%</td>
                    </tr>
                    <tr>
                        <td> Hosting fees, $ cents kW/h
                        </td>
                        <td><?= number_format($server->hostingFees, 2, '.', ',') ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div style="padding: 0px 60px 30px 60px">
    <table class="stat">
        <thead>
        <tr>
            <th>Month
            <th>BTC Coins</th>
            <th>Monthly Revenue</th>
            <th>Monthly Costs</th>
            <th>Profit</th>
            <th>Management Fee</th>
            <th>Net CF</th>
            <th>Cumulative CF</th>
            <th>Cumulative before investment</th>
            <th>Cumulative % Return</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $cf = 0;
        $bitcoins = 0;
        $profit = 0;
        $inv = $server->price * $server->getCountServerByInvest($invest);
        ?>
        <?php foreach ($stat as $item): ?>
            <?php
            $cf += $item[4] - $server->managementFee * 0.01 * $inv / 12;
            $bitcoins += $item[1];
            $profit += $item[4];
            ?>
            <tr>
                <td><?= $item[0] ?></td>
                <td><?= number_format($item[1], 7, '.', ',') ?></td>
                <td><?= number_format($item[2], 0, '.', ',') ?></td>
                <td><?= number_format($item[3], 0, '.', ',') ?></td>
                <td><?= number_format($item[4], 0, '.', ',') ?></td>
                <td><?= number_format(
                        $server->managementFee * 0.01 * $inv / 12,
                        2, '.', ',') ?></td>
                <td><?= number_format(
                        $item[4] - $server->managementFee * 0.01 * $inv / 12, 0, '.', ',') ?></td>
                <td><?= number_format(-$invest + $cf, 0, '.', ',') ?></td>
                <td><?= number_format($cf, 0, '.', ',') ?></td>
                <td><?= number_format($cf * 100 / $inv, 0, '.', ',') ?>%</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th>Total 3 years</th>
            <th><?= number_format($bitcoins, 7, '.', ',') ?></th>
            <th></th>
            <th></th>
            <th><?= number_format($profit, 0, '.', ',') ?></th>
        </tr>
        </tfoot>
    </table>
</div>