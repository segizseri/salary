<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Html;
use app\models\Salary;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCalculate()
    {
        $salary = new Salary();
        $month = date("m");
        $year = date("Y");
        


        if ($salary->load(Yii::$app->request->post()) && $salary->validate())
        {
            if ($salary->taxDeduction == '0') 
                {
                    $mzp = 42500;
                } 
                else
                {
                    $mzp = 0;
                }
           $result = (Html::encode($salary->salary) / Html::encode($salary->normalDays)) * Html::encode($salary->spentDay);            
            $opv = $result * 0.15;
            $osms = $result * 0.02;         
            $ipn = (Html::encode($salary->salary) - $opv - $mzp - $osms) * 0.1;           
            $onHand = $result - $ipn - $opv - $osms;
        } 
        else
        {
            $result = '';
            $ipn = '';
            $opv = '';
            $osms = '';
            $onHand = '';
            $tax = '';
        } 


        return $this->render('salary',
            ['salary' => $salary,
             'result' => $result,
             'ipn' => round($ipn, 2),
             'opv' => round($opv, 2),
             'osms' => round($osms,2),
             'onHand' => round($onHand, 2),
             'month' => $month,
             'year' => $year,
            ],           
        );
    }

    public function actionStaff()
    {
        $salary = new Salary();
        $month = date("m");
        $year = date("Y");
        


        if ($salary->load(Yii::$app->request->post()) && $salary->validate())
        {
            if ($salary->taxDeduction == '0') 
                {
                    $mzp = 42500;
                } 
                else
                {
                    $mzp = 0;
                }
           $result = (Html::encode($salary->salary) / Html::encode($salary->normalDays)) * Html::encode($salary->spentDay);            
            $opv = $result * 0.15;
            $osms = $result * 0.02;         
            $ipn = (Html::encode($salary->salary) - $opv - $mzp - $osms) * 0.1;           
            $onHand = $result - $ipn - $opv - $osms;
            $averageSalary = (Html::encode($salary->salary) / Html::encode($salary->normalDays)); // Нужно для рассчета отпускных
                $salary->months = $month;
                $salary->year = $year;
                $salary->averageSalary = $averageSalary;
                $salary->save(); 
                Yii::$app->getSession()->setFlash('success', 'Запись успешно сохранён');
        } 
        else
        {
            $result = '';
            $ipn = '';
            $opv = '';
            $osms = '';
            $onHand = '';
            $tax = '';
        } 

        return $this->render('staff',
            ['salary' => $salary,
             'result' => $result,
             'ipn' => round($ipn, 2),
             'opv' => round($opv, 2),
             'osms' => round($osms,2),
             'onHand' => round($onHand, 2),
             'month' => $month,
             'year' => $year,
            ],           
        );
    }
}
