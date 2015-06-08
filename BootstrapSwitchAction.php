<?php

namespace hiqdev\bootstrap_switch;

use hiqdev\hiart\Collection;
use Yii;
use yii\base\Action;
use yii\console\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

/**
 * usage:
 * in your controller you may write this
 * public function actions()
 *   {
 *       return [
 *           'editable' => [
 *           'class' => 'hiqdev\bootstrap_switch\BootstrapSwitchAction',
 *           //'scenario'=>'editable',  //optional
 *           'modelclass' => Model::className(),
 *           ],
 *       ];
 *   }
 *
 * Class XEditableAction
 * @package hiqdev\xeditable
 */
class BootstrapSwitchAction extends Action
{
    public $modelclass;

    public $scenario = '';

    /**
     * @var \hiqdev\hiart\Collection
     */
    protected $collection = null;

    /**
     * @throws NotFoundHttpException
     */
    public function run()
    {
        if (Yii::$app->request->isAjax) {
            $pk = Yii::$app->request->post('pk');
            $name = Yii::$app->request->post('name');
            $value = Yii::$app->request->post('value');

            $this->collection = new Collection(['model' => $this->modelclass, 'scenario' => $this->scenario]);
            if ($this->collection === null)
                throw new NotFoundHttpException();

            $this->saveAction([
                'id' => $pk,
                'name' => $name,
                'value' => $value,
            ]);
        }
    }

    protected function saveAction($data)
    {
        $id = ArrayHelper::remove($data, 'id');
        $name = ArrayHelper::remove($data, 'name');
        $value = ArrayHelper::remove($data, 'value');

        $a[array_shift($this->collection->model->primaryKey())] = $id;
        $a[$name] = $value;
        $data[] = $a;

        $this->collection->load($data);
        $this->collection->save();
    }
}