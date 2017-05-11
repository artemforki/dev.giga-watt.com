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

    public function actionTest()
    {
        //echo Yii::$app->params['infoEmail'];
        //mail(Yii::$app->params['infoEmail'], 'test', 'test');
        Yii::$app->mailer->compose(['html' => 'finance-information'], [])
                         ->setFrom([Yii::$app->params['infoEmail'] => Yii::$app->name . ' robot'])
                         ->setTo(Yii::$app->params['supportEmail'])
                         ->setSubject('Финансовая модель')
                         ->send();

    }
}
