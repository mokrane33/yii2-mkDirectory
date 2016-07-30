<?php
/**
 * Created by PhpStorm.
 * User: mp
 * Date: 01/02/2016
 * Time: 15:46
 */

namespace app\controllers;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{

    public function permissionRedirect()
    {
        if(\Yii::$app->user->isGuest)
            return \Yii::$app->user->loginRequired();
        throw new ForbiddenHttpException;
    }
}