<?php

class SysSetting extends CActiveRecord {
    /**
     * The followings are the available columns in table 'sys_Setting':
     * @var integer $id
     * @var integer $parent_Module_id
     * @var string $title
     * @var string $name
     * @var string $value
     */

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sys_setting';
    }
    public function modelTitle() {
        return 'Настройки модуля';
    }


    public function modelOptions() {
        return array();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
                array('title, name, value, value_kaz, value_eng, type', 'required'),
                array('name', 'unique'),
                array('parent_Module_id', 'numerical', 'integerOnly'=>true),
                array('title', 'length', 'max'=>255),
                array('name', 'length', 'max'=>50),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, parent_Module_id, title, name, value, value_kaz', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                'SysSettingM' => array(self::BELONGS_TO, 'SysModule', 'parent_Module_id'),
        );
    }
    public function relationsTitle() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                'SysSettingM' => 'Модуль',
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'id' => '№',
                'parent_Module_id' => 'Модуль',
                'title' => 'Название',
                'name' => 'Имя',
                'value' => 'Значение',
				'value_kaz' => 'Значение KZ',
				'value_eng' => 'Значение ENG',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id);
        $criteria->compare('parent_Module_id',$this->parent_Module_id);
        $criteria->compare('type',$this->type);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('name',$this->name,true);
        return new CActiveDataProvider('sysSetting', array(
                        'criteria'=>$criteria,
        ));
    }


    public function beforeValidate() {
        return true;
    }

    static public function getValue($name){

        $value=  SysSetting::model()->findByAttributes(array('name' =>$name));
        if($value!=null){
			if ($_SESSION['language'] == 'kz' and $value->value_kaz != NULL) {
				return $value->value_kaz;
			} else if ($_SESSION['language'] == 'eng' and $value->value_eng != NULL) {
				return $value->value_eng;
			}

        } elseif(!defined(YII_DEBUG)){
            $S=new SysSetting();
            $S->name=$name;
            $S->title=$name;
            $S->value=$name;
			$S->value_kaz=$name;
			$S->value_eng=$name;
            $S->type='text';
            $S->save();
            $S->value='<a href="/timesafe/sysSetting/update/id/'.$S->id.'.html">Изменить "'.$name.'"</a>';
            $S->save();
        }
        
    }
}