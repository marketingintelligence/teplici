<?php

Yii::import('vii.components.UserIdentity');

class LoginForm extends CFormModel
{
	public $password;

	private $_identity;

	public function rules()
	{
		return array(
			array('password', 'required'),
			array('password', 'authenticate'),
		);
	}

	public function authenticate($attribute,$params)
	{
		$this->_identity=new UserIdentity('yiier',$this->password);
		if(!$this->_identity->authenticate())
			$this->addError('password','Неверный пароль.');
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity('yiier',$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($this->_identity);
			return true;
		}
		else
			return false;
	}
}
