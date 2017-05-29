<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use kartik\mpdf\Pdf;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->title = 'Would you like to know how much BITCOIN is really worth?';
        $groups = Yii::$app->calculator->getCurrencyGroup()['group'];
        $sort = array_map(
            function ($item) {
                return $item['rate'];
            }, $groups);
        asort($sort);
        $avg_groups = array_sum(array_slice($sort, 0, 6)) / 6;
        $sort = array_merge($sort, $groups);
        $s9 = Yii::$app->calculator->getIdentity('s9');
        $rate = $s9->getBitcoinCost(1, 36);
        $exchange = Yii::$app->calculator->getExchangeRate();
        $view = Yii::$app->mobileDetect->isMobile() ? 'mobile/index' : 'index';
        return $this->render(
            $view, [
            'groups' => array_slice($sort, 0, 6),
            'avg_groups' => round($avg_groups, 1),
            'rate' => number_format($s9->getBitcoinCost(1, 36), 1),
            'profit' => round($exchange * 100 / $rate - 100, 0)
        ]);
    }

    public function actionCalculate()
    {
        $settings = Yii::$app->request->post('Server', []);
        $settings = array_map(
            function ($setting) {
                return str_replace(' ', '', $setting);
            }, $settings);

        $s9 = Yii::$app->calculator->getIdentity('s9', $settings);
        $rate = $s9->getBitcoinCost(1, 36);
        $exchange = Yii::$app->calculator->getExchangeRate();

        return \yii\helpers\Json::encode(
            [
                'error' => false,
                'rate' => number_format($s9->getBitcoinCost(1, 36), 1),
                'profit' => round($exchange * 100 / $rate - 100, 0)
            ]);
    }

    public function actionBitcoinCost()
    {
        $units = Yii::$app->request->get('units', 1);
        $s9 = Yii::$app->calculator->getIdentity('s9');

        return \yii\helpers\Json::encode(
            [
                'rate' => $s9->getBitcoinCost($units, 36),
            ]);
    }

    public function actionCalculationPdf($data)
    {
        $data = json_decode(base64_decode($data), true);
        if ($data && isset($data['hash'])) {
            $hash = $data['hash'];
            unset($data['hash']);
            if ($hash === md5(json_encode($data) . Yii::$app->params['keyDownloadPdf'])) {
                $invest = $data['invest'];
                $s9 = Yii::$app->calculator->getIdentity('s9');
                $stat = $s9->getStatToMonthByInvestment($invest, 36);
                //print_r($stat);
                $content = $this->renderPartial('pdf', ['invest' => $invest, 'server' => $s9, 'stat' => $stat]);
                //echo $content;
                //exit;
                $pdf = new Pdf(
                    [
                        // set to use core fonts only
                        'mode' => '',
                        // A4 paper format
                        'format' => Pdf::FORMAT_A4,
                        // portrait orientation
                        'orientation' => Pdf::ORIENT_LANDSCAPE,
                        // stream to browser inline
                        'destination' => Pdf::DEST_BROWSER,
                        // your html content input
                        'content' => $content,
                        'defaultFont' => 'Arial',
                        // format content from your own css file if needed or use the
                        // enhanced bootstrap css built by Krajee for mPDF formatting
                        'cssFile' => '@frontend/web/css/pdf.css',
                        // any css to be embedded if required
                        'cssInline' => '.kv-heading-1{font-size:18px}',
                        // set mPDF properties on the fly
                        'options' => ['title' => 'CALCULATE YOUR MINING'],
                        // call mPDF methods on the fly
                        'methods' => [
                            'SetFooter' => ['{PAGENO}'],
                        ]
                    ]);

                // return the pdf output as per the destination setting
                $pdf->render();
                exit;
            }
        }
    }

    public function actionOrder()
    {
        if (isset($_POST['Client'], $_POST['Client']['investmentSum'], $_POST['Client']['email'])) {
            $inv = (float)str_replace(' ', '', $_POST['Client']['investmentSum']);
            $email = $_POST['Client']['email'];
            if ($inv > 0 && filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
                $data = ['invest' => $inv, 'email' => $email];
                $data['hash'] = md5(json_encode($data) . Yii::$app->params['keyDownloadPdf']);
                $data = base64_encode(json_encode($data));
                $url = \yii\helpers\Url::toRoute(['site/calculation-pdf', 'data' => $data], true);
                Yii::$app->mailer->compose(
                    ['html' => 'finance-information'], ['invest' => $inv, 'email' => $email, 'download_url' => $url])
                                 ->setFrom([Yii::$app->params['infoEmail'] => Yii::$app->name])
                                 ->setTo($email)
                                 ->setSubject('Financial model')
                                 ->send();

            }
        }
    }

    public function actionTest()
    {
        echo Yii::$app->params['infoEmail'];
        //mail(Yii::$app->params['supportEmail'], 'test', 'test');
        $data = ['invest' => 3000, 'email' => 'asd'];
        $data['hash'] = md5(json_encode($data) . Yii::$app->params['keyDownloadPdf']);
        $data = base64_encode(json_encode($data));
        $url = \yii\helpers\Url::toRoute(['site/calculation-pdf', 'data' => $data], true);
        Yii::$app->mailer->compose(
            ['html' => 'finance-information'], ['invest' => 3000, 'email' => 'sdadasd', 'download_url' => $url])
                         ->setFrom([Yii::$app->params['infoEmail'] => Yii::$app->name])
                         ->setTo(Yii::$app->params['supportEmail'])
                         ->setSubject('Финансовая модель')
                         ->send();

    }
}
