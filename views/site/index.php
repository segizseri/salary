<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Зарплатный проек';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Зарплатный проект</h1>

    <p>
        <?= Html::a('Зарплатный калькулятор', ['/site/calculate'], ['class' =>"btn btn-lg btn-success"]) ?>
    </div>


</div>
