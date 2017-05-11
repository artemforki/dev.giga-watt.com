<?php

namespace frontend\modules\api;

/**
 * api module definition class
 */
class Api extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\api\controllers';

    public function init() {
        parent::init();

        Yii::$app->user->enableSession = false;
        Yii::$app->user->enableAutoLogin = false;
        Yii::$app->user->identityClass = 'frontend\modules\api\models\User';
        Yii::$app->urlManager->enableStrictParsing = true;

        Yii::$app->response->on('beforeSend', function($event) {
            $response = $event->sender;
            if (!$response->isSuccessful) {
                if (is_array($response->data)) {
                    $response->data = [
                        'error' => !$response->isSuccessful,
                        'status' => $response->statusCode,
                        'text' => $response->statusCode == 401 ? 'Неверный пароль или почта' : (isset($response->data, $response->data['message']) ? $response->data['message'] : ''),
                        'data' => '',
                    ];
                } else {
                    if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
                        $exception = new \yii\web\HttpException(404, Yii::t('yii', 'Метод не существует.'));
                    }
                    $response->data = json_encode([
                                                      'error' => true,
                                                      'status' => 500,
                                                      'text' => $exception->getMessage(),
                                                      'data' => '',
                                                  ]);
                }
            } elseif (empty($response->data) && Yii::$app->response->format === \yii\web\Response::FORMAT_JSON) {
                $response->data = new \frontend\modules\api\helpers\Result();
            }
        });

        Yii::$app->errorHandler->errorAction = 'api/user/error';
    }

}
