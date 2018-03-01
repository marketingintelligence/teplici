<?php
class ExfilesController extends RController
{
    public $filterOption = array(
        'model'  => 'Exfiles',
        'fields' => array(
            'name_text'=>array('type'=>'text'),
            'status_int'=>array('type'=>'checkbox'),
        )
    );

    public $defaultAction = 'list';

    public function actionIndex() {
        $this->redirect('list');
    }

    public function actionList() {
        $model = new Exfiles('search');
        $model->unsetAttributes();

        if (isset($_GET['Exfiles'])) {
            $model->attributes = $_GET['Exfiles'];
            Yii::app()->user->setState('_filter_Exfiles', $_GET['Exfiles']);
        } else
            if (Yii::app()->user->hasState('_filter_Exfiles')) {
                $model->attributes = Yii::app()->user->getState('_filter_Exfiles');
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
        $model = new Exfiles;

        $this->performAjaxValidation($model);

        if (isset($_POST['Exfiles'])) {
            $model->attributes = $_POST['Exfiles'];
            $model->image=$this->saveFile($model,'image');
            $model->file=$this->saveFile($model,'file');
            $model->engfile=$this->saveFile($model,'engfile');

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
        $page = (int)Yii::app()->request->getParam('Exfiles_page');

        if (isset($_POST['Exfiles'])) {
            $model->attributes = $_POST['Exfiles'];
            $model->image=$this->saveFile($model,'image');
            $model->file=$this->saveFile($model,'file');
            $model->engfile=$this->saveFile($model,'engfile');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Сохранено');

                $this->redirect(
                    array(
                        'list',
                        'Exfiles_page' => $page));
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
        $model = Exfiles::model()->find("id = '".$id."'");
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
        $model = Exfiles::model()->find("id = '".$id."'");

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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'Exfiles-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function beforeAction($action) {
        if ($_GET['ajax'] === 'state')
            if (count($_GET['ExfilesCheck']) > 0) {
                foreach ($_GET['ExfilesCheck'] as $column => $value) {
                    foreach ($value as $id => $val) {
                        Exfiles::model()->updateByPk((int)$id, array($column => (int)$val));
                    }
                }
                Yii::app()->end();
            }

        return parent::beforeAction($action);
    }
}


