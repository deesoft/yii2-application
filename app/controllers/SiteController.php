<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\SignupForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'only' => ['logout', 'index', 'user-list'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'page' => [
                'class' => 'yii\web\ViewAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $parent = $this->module;
        $modules = [];
        foreach ($parent->modules as $id => $module) {
            $module = $parent->getModule($id);
            $class = new \ReflectionClass($module);
            $comment = strtr(trim(preg_replace('/^\s*\**( |\t)?/m', '', trim($class->getDocComment(), '/'))), "\r", '');
            if (preg_match('/^\s*@\w+/m', $comment, $matches, PREG_OFFSET_CAPTURE)) {
                $comment = trim(substr($comment, 0, $matches[0][1]));
            }
            $modules[$module->uniqueId] = [
                'name' => \yii\helpers\Inflector::camel2words($module->id),
                'comment' => $comment
            ];
        }

        return $this->render('index', ['modules' => $modules]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                    'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                'model' => $model,
        ]);
    }

    public function actionMessage()
    {
        $sse = new \app\components\SSE();
        $counter = rand(1, 10);
        $t = time();

        //$sse->retry(3000);
        while ((time() - $t) < 15) {
            // Every second, sent a "ping" event.

            $curDate = date(DATE_ISO8601);
            $sse->event('ping', ['time' => $curDate]);

            // Send a simple message at random intervals.

            $counter--;
            if (!$counter) {
                $sse->message("This is a message at time $curDate");
                $counter = rand(1, 10);
            }

            $sse->flush();
            sleep(1);
        }
        exit();
    }

    public function actionImsakiyah()
    {
        $model = new \app\models\Imsakiyah();
        $jadwal = null;
        // 7.004 112.425
        if ($model->load(\Yii::$app->request->get(), '') && $model->validate()) {
            $jadwal = $model->getImsakiyah();
        }
        return $this->render('imsakiyah', ['model' => $model, 'jadwal' => $jadwal]);
    }
}