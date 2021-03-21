<?php

namespace app\controllers;

use Yii;
use app\models\Stream;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for Stream model.
 */
class ApiController extends Controller
{
    public function beforeAction($action)
    {
        $this->layout = 'main';
        
        return parent::beforeAction($action);
    }

    public function actionTest()
    {
        $output = Yii::$app->orderhelp->Test();
        echo "<pre>";
        print_r($output);
        exit(0);
        return json_encode($output);
    }

    // POST
    // array products
    // string firstname
    // string lastname
    // string address_1
    // string city'
    // string email
    // string telephone
    public function actionCheckoutOld()
    {
        $post = Yii::$app->request->post();

        $order_id = Yii::$app->orderhelp->Checkout($post);
        return $order_id;
    }

    public function actionGetStatus($token)
    {
        $output = Yii::$app->orderhelp->CStatusOrder($token);
        return $output;
    }

    /**
     * 
     * 
     * $products ids of products
     *
     * 
     */
    public function actionCheckout()
    {
        $request = Yii::$app->request->get();

        // print_r($request);
        // exit(0);
        // $request['products'] = ["54","32","57"];
        
        $api_token = Yii::$app->orderhelp->SetCheckout($request['products']);
        
        $this->redirect('https://opencart.fokin-team.ru/index.php?route=checkout/cart&streamId='. $request['streamId'] . "&userId=" . $request['userId']);
    }

    public function actionOrder() {
        $this->enableCsrfValidation = false;
        $data = $_GET;
        $_COOKIE[$data['nameToken']] = $data['valueToken'];
        $output = Yii::$app->orderhelp->COrderInfo(intval($data['orderId']));
        // return $output;
        file_put_contents('/www/live/htdocs/info.txt', print_r($output, true));
    }

    public function actionStatus()
    {
        $result = Yii::$app->orderhelp->COrderInfo('65aff33621c888afe645a195e5');
        
        return json_encode($result);
    }
}
