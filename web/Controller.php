<?php
namespace sky\yii\web;

use Yii;
use sky\yii\web\ActiveForm;
use yii\web\Response;
use yii\base\Model;

/**
 * @property \yii\web\Application $app
 */
class Controller extends \yii\web\Controller
{       
    
    public function jsonValidateModel(Model $model, $attributes = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model, $attributes);
    }
    
    public function isAjaxValidation(Model $model, $formName = null)
    {
        return Yii::$app->request->isAjax && $model->load(Yii::$app->request->post(), $formName);
    }
    
    public function renderPjax($view, $params = [])
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax($view, $params);
        } else {
            return $this->render($view, $params);
        }
    }
    
    public function renderSubLayout(Model $model, $layout, $view, $params = [])
    {
        $params = array_merge(['model' => $model], $params);
        return $this->render($layout, [
            'content' => $this->renderPartial($view, $params),
            'model' => $model,
        ]);
    }
    
    public function getApp()
    {
        return Yii::$app;
    }
}
