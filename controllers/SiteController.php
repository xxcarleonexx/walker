<?php

namespace app\controllers;

use app\models\InsideUrl;
use app\models\InsideUrlForm;
use app\models\UrlLinking;
use nizsheanez\jsonRpc\Action;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

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

    public function actions()
    {
        return [
            'jsonrpc' => [
                'class' => Action::className(),
            ],
        ];
    }


    /**
     * Lists all UrlLinking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UrlLinking::find()->with('insideUrls', 'logErrors', 'weekErrors'),
        ]);

        $insideDataProvider = new ActiveDataProvider([
            'query' => InsideUrl::find()->where(['!=', 'status', 301])->with('siteLink'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'insideDataProvider' => $insideDataProvider,
        ]);
    }


    /**
     * @param array $data
     * @return bool
     */
    public function tryToSave($data)
    {
        $form = new InsideUrlForm();
        if ($form->load($data, '') && $form->save()) {
            return true;
        }
        return false;
    }

    /**
     * @param null|int $id
     * @return string
     */
    public function search($id = null)
    {
        return InsideUrl::checkUrls($id);
    }
}
