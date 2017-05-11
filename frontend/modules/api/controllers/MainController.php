<?php

namespace frontend\modules\api\controllers;

use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class MainController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        echo 'test';
    }
}
