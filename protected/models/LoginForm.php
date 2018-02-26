<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {
    public $username;
    public $password;
    public $rememberMe;
    public $returnUrl;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            array('username', 'email',
                  'message' => 'Логин или пароль неверный'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            array('returnUrl', 'safe'),
            // password needs to be authenticated
            array('password', 'authenticate', 'on' => 'login'),
        );
    }

    /**
     * Declares attribute labels.
     */

    public function attributeLabels()
    {
        return array(
            'username' => Yii::t('site', 'Ваш E-mail'),
            'password' => Yii::t('site', 'Ваш пароль'),
            'rememberMe' => Yii::t('site', 'Запомнить вас?'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) // we only want to authenticate when no input errors
        {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
            switch ($this->_identity->errorCode)
            {
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('username', Yii::t('site', 'Неверный e-mail'));
                    break;
                case UserIdentity::ERROR_STATUS_NOTACTIV:
                    $this->addError('username', Yii::t('site', 'Пользователь неактивирован'));
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password', Yii::t('site', 'Неверный пароль'));
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {

        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }

        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days

            Yii::app()->user->login($this->_identity, $duration);
            User::model()->updateByPk(Yii::app()->user->getId(), array('lastvisit_at' => time()));
            return true;
        }
        else
            return false;
    }
}
