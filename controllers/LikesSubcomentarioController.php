<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\LikesSubcomentario;
use yii\web\NotFoundHttpException;
use app\controllers\BaseController;
use app\models\LikesSubcomentarioSearch;

/**
 * LikessubcomentarioController implements the CRUD actions for LikesSubcomentario model.
 */
class LikessubcomentarioController extends BaseController
{
    public $modelClass = 'app\models\LikesSubcomentario';
    public $authexcept = ["index", "view"];

    public function indexProvider()
    {
        return new ActiveDataProvider([

            'query' => LikesSubcomentario::find()->orderBy('id'),
            'pagination' => false
        ]);
        
    }
     
    public function actions()
    {
        $actions = parent::actions();
        //Eliminamos acciones de crear y eliminar apuntes. Eliminamos update para personalizarla
        unset($actions['delete'], $actions['create'], $actions['update']);
        $actions['index']['prepareDataProvider'] = [$this, 'indexProvider'];
        return $actions;
    }

   
    public function actionCreatelike()
    {
        $model = new LikesSubcomentario();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $uid = Yii::$app->user->identity->id;
        $model->id_usuario = $uid;
        $existe = LikesSubcomentario::find()->where(["id_subcomentario" => $model->id_subcomentario, "id_usuario" => $model->id_usuario])->one();
       
        // POR SI ACASO SE PRUEBA A SPAMEAR EL BOTON DE LIKES
        if (!$existe) {
            if ($model->save()) {
                return $model;
            } else {
                return ["error" => $model->getErrors()];
            }
        }
    }
    public function actionDeletelike($id_subcomentario)
    {
      
        // Hacemos lo queramos y devolvemos información con return (un array, un objeto...)
        $uid = Yii::$app->user->identity->id;
        $model = LikesSubcomentario::find()->where(["id_subcomentario" => $id_subcomentario, "id_usuario" => $uid])->one();
        // En realidad las comprobaciones de si es mio o no, no serían necesarias,
        // solo la de si existe
        if (!$model) { //No existe
            throw new NotFoundHttpException('No existe ese Like');
        } else {
            if ($uid != $model->id_usuario) //No es mío
                throw new NotFoundHttpException('Acceso no permitido');

            if ($model->delete()) {
                return "Like borrado correctamente";
            }
            return $model;
        }
        
    }
    /*
    public function actionGetlikes()
    {
        
        //$uid = Yii::$app->user->identity->id;
        $model = LikesSubcomentario::find()->orderBy('id');
        var_dump($model);
        return $model;
    }*/
}
