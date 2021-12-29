<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Зарплатный проект';
?>
<?php $s = ActiveForm::begin(); ?>
  <?= $s->field($salary, 'salary')->label('Оклад'); ?>
  <?= $s->field($salary, 'normalDays')->textInput()->hint('Норма дней в месяц (обычно 22)')->label('Норма дней в месяц'); ?>
  <?= $s->field($salary, 'spentDay')->label('Отработанное количество дней'); ?>
  <?= $s->field($salary, 'taxDeduction')->checkbox(['uncheck'=> 0, 'value'=>false, 'label' => 'Имеется ли налоговый вычет 1 МЗП']); ?>
  <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-primary'])?>
<?php ActiveForm::end(); ?>

<?php if ($result) { ?> 
<p> Зарплата на руки - <?= $onHand ?> </p> 
<p> Индивидуальный подоходный налог (ИПН) - <?= $ipn ?> </p> 
<p> Обязательные пенсионные взносы (ОПВ) - <?= $opv ?> </p> 
<p> Обязательное социальное медицинское страхование (ОСМС) - <?= $osms ?> </p>
<p> Текущий месяц - <?= $month ?> </p>
<p> Текущий год -<?= $year ?> </p>

<?php } ?>
