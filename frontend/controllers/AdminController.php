<?php

namespace frontend\controllers;

use Yii;

class AdminController extends \yii\web\Controller{


    public function actionEmails()
    {
        $data = "Email;Investment;Date\r\n";
        $emails = Yii::$app->db->createCommand("SELECT email,investments, createdAt  FROM formMail ORDER BY 3")
                               ->queryAll();
        foreach ($emails as $value) {
            $data .= $value['email'] .
                ';' . $value['investments'] .
                ';' . $value['createdAt'] .
                "\r\n";
        }
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="export_' . date('d.m.Y') . '.csv"');
        return $data;
    }

}