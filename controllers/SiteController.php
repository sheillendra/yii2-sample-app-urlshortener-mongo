<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UrlForm;
use yii\mongodb\Query;
use yii\helpers\Url;

class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new UrlForm();
        if ($model->load(Yii::$app->request->post()) ) {
            $isCodeExist=true;
            $query = new Query;
            $query->select(['code'])->from('shortener');
            while ($isCodeExist){
                $isCodeExist=false;
                $code=$this->getShortCode();
                $query->where(['code'=>$code]);
                if($query->one()){
                    $isCodeExist=true;
                }
            }
            
            $collection = Yii::$app->mongodb->getCollection('shortener');
            $collection->insert(['userId' => Yii::$app->user->identity?Yii::$app->user->identity->id:'', 'code'=>$code,'url' => $model->url]);
            
            Yii::$app->session->setFlash('urlFormSubmitted', Yii::$app->urlManager->createAbsoluteUrl('/').$code);
            $submitCount=Yii::$app->session->get('_submit_count', 0);
            $submitCount=$submitCount > 3?0:$submitCount;
            Yii::$app->session->set('_try_login', $submitCount + 1);
            return $this->refresh();
        } 
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    protected function getShortCode($length=6){
        return substr(str_shuffle('abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ1234567890'),rand(0,60-$length),$length);
    }
    
    public function actionTranslate($code){
        $query = new Query;
        $query->select(['url'])->from('shortener')->where(['code'=>$code]);
        $url=$query->one();
        if($url){
            $this->layout='redirect';
            return $this->render('translate', [
                'url' => $url,
            ]);
        }
        Yii::$app->session->setFlash('urlFormSubmitted','Sorry, shorturl '.$code.' not found.');
        $this->redirect('/');
    }
}