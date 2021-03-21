<?php

namespace app\controllers;

use Yii;
use app\models\Stream;
use app\models\Product;
use app\models\Event;
use Symfony\Contracts\EventDispatcher\Event as EventDispatcherEvent;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use \Datetime;
use DateInterval;


/**
 * AdminController implements the CRUD actions for Stream model.
 */
class AdminController extends Controller
{
    public function beforeAction($action)
    {
        $this->layout = 'main';
        
        return parent::beforeAction($action);
    }

    /**
     * Lists all Stream models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Stream::find(),
        ]);
        $models = Stream::find()->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'models' => $models,
        ]);
    }

    /**
     * Displays a single Stream model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $models = Product::find()->where(['stream_id' => $id, 'activity' => 1])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'models' => $models,
        ]);
    }

    /**
     * Creates a new Stream model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stream();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // https://opencart.fokin-team.ru
            
            // После сохранения модели загружаются товары в бд по ключу
            
            $response = array(json_decode(file_get_contents($model->domain . '?route=api/product')));

            Product::deleteAll(['stream_id' => $model->id]);

            foreach ($response[0]->products as $product) {

                $modelProduct = new Product();
                
                if (is_string($product->special)) {
                    $modelProduct->special = $product->special;
                } else if (is_array($product->special)) {
                    $modelProduct->special = $product->special[0];
                }

                $modelProduct->product_id = $product->product_id;
                $modelProduct->name = $product->name;
                $modelProduct->image = $product->thumb;
                $modelProduct->description = $product->description;
                $modelProduct->price = $product->price;
                $modelProduct->tax = $product->tax;
                $modelProduct->minimum = $product->minimum;
                $modelProduct->rating = $product->rating;
                $modelProduct->url = $product->href;
                $modelProduct->stream_id = $model->id;

                if(!$modelProduct->save()) return print_r($modelProduct->errors);

            }

            $modelsProduct = Product::findAll(['stream_id' => $model->id]);

            return $this->render('products', [
                'models' => $modelsProduct
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Select products to stream
     * 
     * @param array $arrayID
     */
    public function actionCheckboxForm()
    {
        $arr = Yii::$app->request->post('arrayID');

        if (!isset($arr)) {
            return $this->render('error', array('message' => 'Вы не выбрали ни один товар.'));
        } else {
            foreach ($arr as $id) {
                $model = Product::findOne($id);

                $model->activity = true;

                if(!$model->save()) return print_r($model->errors);
            }

            $dataProvider = new ActiveDataProvider([
                'query' => Stream::find(),
            ]);
            $models = Stream::find()->all();
    
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'models' => $models,
            ]);
        }
    }


    /**
     * Updates an existing Stream model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // После сохранения модели загружаются товары в бд по ключу
            $response = array(json_decode(file_get_contents('https://opencart.fokin-team.ru?route=api/product')));

            Product::deleteAll(['stream_id' => $model->id]);

            foreach ($response[0]->products as $product) {

                $modelProduct = new Product();
                
                if (is_string($product->special)) {
                    $modelProduct->special = $product->special;
                } else if (is_array($product->special)) {
                    $modelProduct->special = $product->special[0];
                }

                $modelProduct->product_id = $product->product_id;
                $modelProduct->name = $product->name;
                $modelProduct->image = $product->thumb;
                $modelProduct->description = $product->description;
                $modelProduct->price = $product->price;
                $modelProduct->tax = $product->tax;
                $modelProduct->minimum = $product->minimum;
                $modelProduct->rating = $product->rating;
                $modelProduct->url = $product->href;
                $modelProduct->stream_id = $model->id;

            if (!$modelProduct->save()) {
                return print_r($modelProduct->errors);
            } 

            }

            $modelsProduct = Product::find()->where(['stream_id' => $model->id])->all();

            return $this->render('products', [
                'models' => $modelsProduct
            ]);
            // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Stream model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * first stream for client
     * 
     * @param integer $id - ID Stream
     */
    public function actionSelfStream($id)
    {
        $model = Stream::findOne($id);
        $modelsProduct = Product::find()->where(['stream_id' => $id, 'activity' => 1])->all();

        if (!isset($modelsProduct)) {
            return $this->render('error', array('message' => 'Товары не были выбраны. Пожалуйста, выберите'));
        }

        if (!isset($model)) {
            return $this->render('error', array('message' => 'Стрима с таким ID не сущетсвует'));
        }

        return $this->render('self_stream', [
            'youtubeURL' => $this->_getYoutubeEmbedUrl($model->youtube_url),
            'products' => json_encode($modelsProduct),
        ]); 
    }

    /**
     * output statistics
     */
    public function actionDashboard($id)
    {
        $models = Event::find()->where(['stream_id' => $id])->all();
        $modelStream = Stream::findOne($id);
        $youtubeURL = $this->_getYouTubeVideoID($modelStream->youtube_url);
        $arrayMinutes = [];

        $api_key = 'AIzaSyCTNbabh8HmG1S8QaFPNKePhfbUix8CFaQ';

        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . $youtubeURL . '&key=' . $api_key;

        $data = json_decode(file_get_contents($api_url));

        // Время в UNIX после публикации стрима
        $publishedAt = strtotime($data->items[0]->snippet->publishedAt);
        // Продолжительность стрима
        $duration = $data->items[0]->contentDetails->duration;

        $published = new DateTime($data->items[0]->snippet->publishedAt);
        $duration = $published->add(new DateInterval($duration));
        // Время в UNIX окончания стрима
        $duration = strtotime($duration->format('Y-m-d H:i:s'));
        // Длина промежутка времени стрима
        $interval = $duration - $publishedAt;
        // Количество шагов по времени (1 минута)
        $countStep = intdiv($interval, 60);

        if (!isset($models)) {
            return $this->render('error', array('message' => 'Никто не зашел на Ваш стрим ('));
        }

        // ------------------------количество зрителей на стриме--------------------------- 
        $countViewers = Event::find()
            ->where(['stream_id' => $id])
            ->groupBy(['uid'])
            ->count();

            // ---------------------КОЛ-ВО ПОЛЬЗОВАТЕЛЕЙ ПО МИНУТАМ--------------------------
        // все модели сгруппированные по uid. Каждая моделька отдельный User
        $modelsGroupUid = Event::find()
            ->where(['stream_id' => $id])
            ->groupBy(['uid'])
            ->all();

        // перебираем всех изменения каждого пользователя
        foreach ($modelsGroupUid as $value) {

            for($i = 0; $i <= $countStep; $i++) {
                
                $timeStep = $publishedAt + (60 * $i);

                // поиск изменения статуса присутствия пользователя на стриме
                $modelUid = Event::find()
                    ->where(['stream_id' => $id])
                    ->andWhere(['uid' => $value->uid])
                    ->andWhere(['>', 'datetime', $timeStep])
                    ->orderBy(['datetime' => SORT_ASC])
                    ->one();

                if (isset($modelUid)) {
                    // запись в массив количество пользователей. Ключ - минута, значения - кол-во пользователей
                    if ($modelUid->type == 0) {
                        if (array_key_exists($i, $arrayMinutes)) {
                            $arrayMinutes[$i] = $arrayMinutes[$i]+1;
                        } else {
                            $arrayMinutes[$i] = 1;
                        }
                    }
                }
            }
        }

        $maxViewers = ($arrayMinutes) ? max($arrayMinutes) : 0;

        // $dataUpdate = '{"data":{"datasets":[{"data":' . implode(",", $arrayMinutes) . '}]}}';
        // return $dataUpdate;
        // echo '<pre>';
        // return print_r($arrayMinutes);

        return $this->render('dashboard', [
            'models' => $models,
            'countViewers' => $countViewers,
            'arrayMinutes' => $arrayMinutes,
            'maxViewers' => $maxViewers,
        ]);
    }

        
    /**
     * Finds the Stream model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stream the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stream::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChatTest() {
        return $this->render('contact');
    }

    private function _getYoutubeEmbedUrl($url){
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';
    
        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
    
        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        return 'https://www.youtube.com/embed/' . $youtube_id ;
    }

    function _getYouTubeVideoID($url) {
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';
    
        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
    
        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        return $youtube_id;
    }
}
