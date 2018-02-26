<?php
/**
 * Модель для таблицы "sys_Users".
 *
 * Поля:
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $activkey
 * @property string $created_at
 * @property string $lastvisit_at
 * @property integer $status
 */
class User extends CActiveRecord {
    /**
     * @return User the static model class
     */
    public $verifyCode;
    public $password_repeat;
    public $rememberMe;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string title of model
     */
    public static function modelTitle() {
        return 'Администратор';
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sys_Users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('email', 'required'),
            array(
                'status', 'numerical',
                'integerOnly' => true),
            array('email', 'email'),
            array('email', 'unique'),
            array(
                'email', 'length',
                'max' => 100),
            array(
                'password, password_repeat', 'required',
                'on' => 'reg'),
            array('password', 'compare'),
            array(
                'password, password_repeat', 'length',
                'min' => 6
            ),
            array(
                'activkey', 'length',
                'max' => 32),
            array('rememberMe', 'boolean'),
            array(
                'agree', 'compare',
                'compareValue' => 1,
                'message'      => 'Вы должны принять наши Правила портала',
                'on'           => 'reg'),

            array(
                'created_at, lastvisit_at', 'length',
                'max' => 10),
            array(
                'id, email, password, activkey, created_at, lastvisit_at, status', 'safe',
                'on' => 'search'),
//            array(
//                'verifyCode', 'captcha',
//                'message'    => 'Введите код проверки!',
//                'allowEmpty' => !extension_loaded('gd') || Yii::app()->controller->action->id == 'settings'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(

            'id'              => Yii::t('site', 'ID'),
            'email'           => Yii::t('site', 'Email'),
            'password'        => Yii::t('site', 'Пароль'),
            'activkey'        => Yii::t('site', 'Activkey'),
            'created_at'      => Yii::t('site', 'Дата создания'),
            'lastvisit_at'   => Yii::t('site', 'Последний визит'),
            'status'          => Yii::t('site', 'Видимость'),
            'password_repeat' => Yii::t('site', 'Повтор пароля'),
            'rememberMe'      => Yii::t('site', 'Запомнить вас?'),
        );
    }

    /**
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('activkey', $this->activkey, true);
        $criteria->compare('status', $this->status);
        return new CActiveDataProvider($this, array(
                                                   'criteria' => $criteria,
                                              ));
    }

    public function beforeValidate() {
        if($this->isNewRecord) $this->created_at = time();        
        return true;
    }

    public function getTitle() {
        return $this->email;
    }

    /**
     * @return array of model options
     */
    public function options() {
        return array();
    }

}