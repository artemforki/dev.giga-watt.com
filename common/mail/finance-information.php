<?php
use yii\helpers\Url;

?>
<table border="0" cellpadding="0" cellspacing="0" style="font-size:16px;margin:0; padding:0;font-family: Arial;"
       width="100%"
       bgcolor="#eaeced">
    <tr>
        <td style=""></td>
        <td style="height:100px;width: 80%;text-align: center">
            <a style="margin-right: 40px;line-height: 100px;height: 100px" href="http://btcstat.net"><img
                        src="<?= Url::to('img/letter/btcstat.png', true) ?>" style="vertical-align: middle"/></a>
            <span style="color:#ec2809;font-size: 18px;line-height: 100px;height: 100px;">&</span>
            <a style="margin-left: 40px;line-height: 100px;height: 100px" href="https://cryptonomos.com/wtt/"><img
                        src="<?= Url::to('img/letter/giga-watt.png', true) ?>" style="vertical-align: middle"/></a>
        </td>
        <td style=""></td>
    </tr>
    <tr>
        <td style=""></td>
        <td style="width: 80%;text-align: center;padding: 50px;background: #fff;">
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0" width="100%" bgcolor="#fff">
                <tr>
                    <td colspan="2" style="font-size: 30px; font-weight: 700">Hello!</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 40px 0;line-height: 24px">
                        You have requested personal detailed financial model for Bitcoin mining with T9 miner model on the email <b><?= $email ?></b>
                    </td>
                </tr>
                <tr style="text-transform: uppercase;font-size: 16px">
                    <td style="padding:15px 0;width: 50%;border-right: 4px solid #eaeced"><p
                                style="margin: 0; padding: 0 0 10px 0;">
                            Period</p><span
                                style="font-weight: 700;font-size: 30px;">3 года</span></td>
                    <td style="width: 50%"><p style="margin: 0; padding: 0 0 10px 0;">Investments</p>
                        <span style="font-weight: 700;font-size: 30px;"><?= number_format($invest,0,'.',',') ?> usd</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;padding-top: 50px">
                        <a href="<?= $download_url?>" style="text-decoration: none;display:inline-block;text-transform:uppercase;font-weight:700;border-radius:8px;background: #ec2809 url(<?= Url::to('img/letter/pdf.png', true) ?>) no-repeat 40px 50%;color:#fff;width: 280px;height: 60px;line-height: 60px;box-sizing: border-box;padding-left: 60px">
                            Download calculations
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 40px;line-height: 24px">
                        For all the questions, you can<br/>
                        contact <a href="mailto:info@btcstat.com" style="color:#ec2809;font-weight: 700">info@btcstat.com</a>
                    </td>
                </tr>
            </table>
        </td>
        <td style=""></td>
    </tr>
    <tr>
        <td colspan="3" style="height:100px;"></td>
    </tr>
</table>