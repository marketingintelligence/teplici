<?php
class UserController extends RController
{
    public $filterOption = array(
        'model'  => 'User',
        'fields' => array(            
            'email'=>array('type'=>'text'),
			'created_at'=>array('type'=>'date'),
			'lastvisit_at'=>array('type'=>'date'),
			'status'=>array('type'=>'checkbox'),
			            
        )
    );

    public $defaultAction = 'list';


    public function actionIndex() {
        $this->redirect('list');
    }

    public function actionList() {
        $model = new User('search');
        $model->unsetAttributes();

        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
            Yii::app()->user->setState('_filter_User', $_GET['User']);
        } else
            if (Yii::app()->user->hasState('_filter_User')) {
                $model->attributes = Yii::app()->user->getState('_filter_User');
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

    /**
     * Создание модели
     */
    public function actionCreate() {
        $model = new User;
		if (isset($_POST['User'])) 
        	$_POST['User']['password_repeat'] = $_POST['User']['password'];

        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            
            $model->password = md5($model->password);
            $model->password_repeat = $model->password;
            $model->activkey = md5($model->email . 'sfjom8y934tfvet342' . time());            

            if ($model->save()) {
                Rights::assign('Authenticated', $model->id);
                Yii::app()->user->setFlash(
                    'flashMessage', array(
                                         'type'  => 'success',
                                         'text'  => 'Сохранено'));
                $this->redirect(array('list'));
            } else {
                Yii::app()->user->setFlash(
                    'flashMessage', array(
                                         'type'  => 'error',
                                         'text'  => 'Ошибка при сохранении'));
            }            
        } else {
			$model->created_at = date("d-m-Y");
			$model->lastvisit_at = date("d-m-Y");            
        }
        $this->render(
            'create', array(
                           'model' => $model,
                      ));
    }

    /**
     * Редактирование
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['User'])) 
        	$_POST['User']['password_repeat'] = $_POST['User']['password'];
        $this->performAjaxValidation($model);
        $page = (int)Yii::app()->request->getParam('User_page');

        if (isset($_POST['User'])) {
        	$oldPassword = $model->password;
            $model->attributes = $_POST['User'];            
            if($model->password==='') {
	            $model->password = $oldPassword;
	        }
            else{
            	$model->password = md5($model->password);
            }
            $model->password_repeat = $model->password;
            $model->activkey = md5($model->email . 'sfjom8y934tfvet342' . time());            
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    'flashMessage', array(
                                         'type'  => 'success',
                                         'text'  => 'Сохранено'));
                $this->redirect(
                    array(
                         'list',
                         'User_page' => $page));
            } else {
                Yii::app()->user->setFlash(
                    'flashMessage', array(
                                         'type'  => 'error',
                                         'text'  => 'Ошибка при сохранении'));
            }
        }else{
        	$model->password = '';
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
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id, true)->delete();
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('list'));
            }
        }
        else
        {
            throw new CHttpException(400, 'Неверный запрос.');
        }
    }
    /**
     * Загрузка модели по ID
     *
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $removed = false) {
                    $model = User::model()->findByPk($id);

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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function beforeAction($action) {
        if ($_GET['ajax'] === 'state')
            if (count($_GET['UserCheck']) > 0) {
                foreach ($_GET['UserCheck'] as $column => $value) {
                    foreach ($value as $id => $val) {
                        User::model()->updateByPk((int)$id, array($column => (int)$val));
                    }
                }
                Yii::app()->end();
            }

        return parent::beforeAction($action);
    }
}


