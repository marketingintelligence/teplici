<?php
/**
 * Модель для таблицы "sys_Setting".
 *
 * Поля:
 * @property integer $id
 * @property integer $parent_Module_id
 * @property string $title
 * @property string $name
 * @property string $value
 */
class Setting extends CActiveRecord
{
	/**
	 * @return Setting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string title of model
	 */
	public static function modelTitle()
	{
		return 'Setting';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sys_Setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('parent_Module_id, title, name, value', 'required'),
			array('parent_Module_id', 'numerical', 'integerOnly'=>true),
			array('language', 'length', 'max'=>5),
			array('id, parent_Module_id, title, name, value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_Module_id' => 'Parent Module',
			'title' => 'Заголовок',
			'name' => 'Name',
			'value' => 'Value',
			'language' => 'Язык',
		);
	}

	/**
	 *
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('parent_Module_id',$this->parent_Module_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('language',$this->language, true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeValidate() {
        return true;
    }
        
    /**
	 * @return array of model options
	 */
	public function options()
	{
        return array();
	}
    }