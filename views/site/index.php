<?php
/* @var $this yii\web\View */
$this->title = 'Dodeso - Url Shorter';

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'url-form']); ?>
            <?= $form->field($model, 'url') ?>
            <?php if ($model->captchaNeeded): ?>
                <?=
                $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])
                ?>
            <?php endif; ?>
            <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-6">
            <?php if (Yii::$app->session->hasFlash('urlFormSubmitted')): ?>
                <div class="alert alert-success">
                    <?php echo Yii::$app->session->getFlash('urlFormSubmitted') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
