<?php

namespace app\models;

use Yii;
//use yii\base\Model;
use app\components\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UrlForm extends Model
{
    public $url;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['url'], 'required'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha','captchaAction'=>'site/captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'url'=>'Paste your long URL here',
            'verifyCode' => 'Verification Code',
        ];
    }
    
    /**
     * Check if captcha is needed.
     *
     * @return boolean whether the user try to login more than 3 times
     */
    public function getCaptchaNeeded()
    {
        return Yii::$app->session->get('_submit_count', 0) > 3;
    }
}
