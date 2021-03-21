<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\Stream;

class ViewController extends Controller
{
    public function beforeAction($action)
    {
        $this->layout = 'view';
        
        return parent::beforeAction($action);
    } 

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionStream($id)
    {
        $model = Stream::findOne($id);
        $modelsProduct = Product::find()->where(['stream_id' => $id, 'activity' => 1])->asArray()->all();

        if (!isset($modelsProduct)) {
            throw new \yii\web\ForbiddenHttpException('Товары не были выбраны. Пожалуйста, выберите');
        }

        if (!isset($model)) {
            throw new \yii\web\ForbiddenHttpException('Стрима с таким ID не сущетсвует');
        }

        return $this->render('index', [
            'id' => $model->id,
            'youtubeURL' => $this->_getYoutubeEmbedUrl($model->youtube_url),
            'products' => json_encode($modelsProduct)
        ]);   
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
}
