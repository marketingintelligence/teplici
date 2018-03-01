<?php
class CombinatesController extends RController
{
    public $filterOption = array(
        'model'  => 'Combinates',
        'fields' => array(
            'name_text'=>array('type'=>'text'),
            'engname_text'=>array('type'=>'text'),
            'status_int'=>array('type'=>'checkbox'),
        )
    );

    public $defaultAction = 'list';

    public function actionIndex() {
        $this->redirect('list');
    }

    public function actionList() {
        $model = new Combinates('search');
        $model->unsetAttributes();

        if (isset($_GET['Combinates'])) {
            $model->attributes = $_GET['Combinates'];
            Yii::app()->user->setState('_filter_Combinates', $_GET['Combinates']);
        } else
            if (Yii::app()->user->hasState('_filter_Combinates')) {
                $model->attributes = Yii::app()->user->getState('_filter_Combinates');
            }
        $this->filter = $model->attributes;
        if (isset($_GET['ajax'])) {
            $this->renderPartial(
                '_list', array(
                'model' => $model,
            ));
        } else
            $this->render(
                'list', array(
                'model' => $model,
            ));
    }

    public function actionCreate() {
        $model = new Combinates;

        $this->performAjaxValidation($model);

        if (isset($_POST['Combinates'])) {
            $model->attributes = $_POST['Combinates'];
            $model->image=$this->saveFile($model,'image');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Сохранено');
                $this->redirect(array('list'));
            } else {
                Yii::app()->user->setFlash('error', 'Ошибка при сохранении');

            }
        } else {
            $model->created_at = time();
        }
        $this->render(
            'create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $page = (int)Yii::app()->request->getParam('Combinates_page');

        if (isset($_POST['Combinates'])) {
            $model->attributes = $_POST['Combinates'];
            $model->image=$this->saveFile($model,'image');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Сохранено');

                $this->redirect(
                    array(
                        'list',
                        'Combinates_page' => $page));
            } else {
                Yii::app()->user->setFlash('error', 'Ошибка при сохранении');
            }
        }
        $this->render(
            'update', array(
            'model' => $model,
            'page'  => $page
        ));
    }

    /**
     * Удаление модели
     */
    public function actionDelete($id) {
        //$id = Yii::app()->request->getParam('id');
        //$this->loadModel(1)->delete();
        $model = Combinates::model()->find("id = '".$id."'");
        $model->delete();
        if (!isset($_GET['ajax'])) {
            // $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('list'));
        }

    }
    /**
     * Загрузка модели по ID
     *
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Combinates::model()->find("id = '".$id."'");

        if ($model === null) {
            throw new CHttpException(404, 'Страница не существует.');
        }
        return $model;
    }

    /**
     * AJAX валидация
     *
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'Combinates-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function beforeAction($action) {
        if ($_GET['ajax'] === 'state')
            if (count($_GET['CombinatesCheck']) > 0) {
                foreach ($_GET['CombinatesCheck'] as $column => $value) {
                    foreach ($value as $id => $val) {
                        Combinates::model()->updateByPk((int)$id, array($column => (int)$val));
                    }
                }
                Yii::app()->end();
            }

        return parent::beforeAction($action);
    }
}


