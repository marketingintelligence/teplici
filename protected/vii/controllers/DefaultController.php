<?php

class DefaultController extends Controller
{
	public $layout='column1';

	public function getPageTitle()
	{
		if($this->action->id==='index')
			return 'Vii: Генератор кода';
		else
			return 'Vii - Генератор "'.ucfirst($this->action->id).'"';
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=Yii::createComponent('vii.models.LoginForm');

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->createUrl('vii/default/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$this->redirect(Yii::app()->createUrl('vii/default/index'));
	}
}