<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Salary extends ActiveRecord
{
 /* public $salary; // Оклад
	public $normalDays; // Норма дней в месяц (обычно 22)
	public $spentDay; // Отработанное количество дней
	public $taxDeduction; // Имеется ли налоговый вычет 1 МЗП
	public $year;
	public $month; */

	public function rules()
	{
		return [
			[
				['name','salary','normalDays', 'spentDay'], 'required', 'message'=>'Поля не заполнено!'],
				['taxDeduction', 'boolean'],				
		];
	}
}

?>