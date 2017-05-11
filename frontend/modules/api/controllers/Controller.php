<?php

namespace frontend\modules\api\controllers;

class Controller extends \yii\rest\Controller {

    public function behaviors() {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }

}
