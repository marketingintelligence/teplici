<?php
// Yii::import('system.gii.generators.crud.CrudCode');

class CrudCode extends CCodeModel
{
	public $model;
	public $controller;
	

	private $_modelClass;
	private $_table;
	public $generateLangs = false;
	public $generateMeta = true;
	public $baseControllerClass = 'RController';
	public $langs = array('ru','en','kz','cn','ae');
	public $filter = array();
    public $filterExpert = array(
    //	'parent_User_id'=>'parent|title|email'
    );

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('controller, model','required'),
			array('model','validateModel'),
			array('filter,filterExpert','safe'),
			array('generateLangs,generateMeta', 'sticky'),
		));
	}

	public function validateModel($attribute,$params)
	{
		if($this->hasErrors('model'))
			return;
		$class=@Yii::import($this->model,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('model', "Класса '{$this->model}' несуществует.");
		else if(!is_subclass_of($class,'CActiveRecord'))
			$this->addError('model', "'{$this->model}' должен быть наследован от CActiveRecord.");
		else
		{
			$table=CActiveRecord::model($class)->tableSchema;
			if($table->primaryKey===null)
				$this->addError('model',"Таблица '{$table->name}' не имеет первичного ключа.");
			else if(is_array($table->primaryKey))
				$this->addError('model',"Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			else
			{
				$this->_modelClass=$class;
				$this->_table=$table;
			}
		}
	}
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'generateLangs' => 'Языки',
			'generateMeta' => 'META',
			'model' => 'Модель',
			'controller'=>'Путь',
			'baseControllerClass'=>'Родительский класс',			
		));
	}

	public function requiredTemplates()
	{
		return parent::requiredTemplates();
	}

	public function prepare()
	{
		$this->files = array();
		$templatePath = $this->templatePath;
		$controllerTemplateFile = $templatePath . DIRECTORY_SEPARATOR . 'controller.php';
		$this->files[] = new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);
		$files = scandir($templatePath);
		foreach ($files as $file)
		{
			if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php' && $file !== 'controller.php')
			{
				$this->files[] = new CCodeFile(
					$this->viewPath . DIRECTORY_SEPARATOR . $file,
					$this->render($templatePath . '/' . $file)
				);
			}
		}
		
	}

	public function getLayoutPath()
	{
		return rtrim($this->getModule()->getLayoutPath() . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $this->layoutPrefix), DIRECTORY_SEPARATOR);
	}

	public function getRelativeLayoutPath()
	{
		return rtrim('layouts/' . str_replace('.', '/', $this->layoutPrefix), '/');
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}

	public function getControllerID()
	{
		if($this->getModule()!==Yii::app())
			$id=substr($this->controller,strpos($this->controller,'/')+1);
		else
			$id=$this->controller;
		
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		
		return $id;
	}

	public function getUniqueControllerID()
	{
		$id=$this->controller;

		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();		
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}

	public function getViewPath()
	{
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass, $column)
	{
		return "CHtml::activeLabelEx(\$model, '{$column->name}')";
	}

	public function generateActiveLabel($modelClass, $column)
	{
		return "\$form->labelEx(\$model, '{$column->name}')";
	}

	public function generateInputField($modelClass, $column)
	{
		$lang = substr($column->name,-2);
		var_dump($lang);

		if ($column->type === 'boolean')
		{
			return "\$form->checkBoxRow(\$model, '{$column->name}');";
		}
		else
		{
			if (stripos($column->dbType, 'text') !== false)
			{
				return "
				\$form->textAreaRow(\$model, '{$column->name}',array('class'=>'span12'),'ru');
				CHtml::activeTextArea(\$model, '{$column->name}', array('rows' => 6, 'cols' => 50, 'class' => 'text_area'))";
			}
			else
			{
				if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
				{
					$inputField = 'activePasswordField';
				}
				else
				{
					$inputField = 'activeTextField';
				}
				if ($column->type !== 'string' || $column->size === null)
				{
					return "CHtml::{$inputField}(\$model, '{$column->name}', array('class' => 'text_field'))";
				}
				else
				{
					if (($size = $maxLength = $column->size) > 60)
					{
						$size = 60;
					}
					return "CHtml::{$inputField}(\$model, '{$column->name}', array('size' => {$size}, 'maxlength' => {$maxLength}, 'class' => 'text_field'))";
				}
			}
		}
	}

	public function generateActiveField($modelClass, $column)
	{
        $title=$this->guessNameColumn($this->tableSchema->columns);
        $lang = explode('_',$column->name);
        $lang = $lang[count($lang)-1];
        if(!in_array($lang,$this->langs)) $lang='';
        else{
        	$lang = ",'{$lang}'";
        }		

		if ($column->type === 'boolean' || $column->dbType=='tinyint(1)' || stripos($column->name, 'status') !== false)
		{
			return "\$form->checkBoxRow(\$model, '{$column->name}');";
		}
        else if (stripos($column->name, 'image') !== false || stripos($column->name, 'file') !== false)
                return "\$form->fileFieldRow(\$model, '{$column->name}',array('class'=>'input-file'));";
        else if (stripos($column->name, '_at') !== false || stripos($column->name, 'date') !== false)
                return "\$form->dateFieldRow(\$model, '{$column->name}',array('class'=>'span2'));";
        else if ($column->name == 'parent_id')
            return "false;
                function find{$modelClass}(\$arr=array(),\$id=0,\$s='-'){
                    \$ms={$modelClass}::model()->findAll(array('condition'=> '`parent_id`='.\$id,'order'=>'$title','select'=>array('id','$title')));
                    foreach (\$ms as \$m){
                        \$arr[\$m->id]=\$s.'>'.\$m->$title;
                        if({$modelClass}::model()->count(array('condition'=> '`parent_id`='.\$m->id,'order'=>'$title','select'=>array('id','$title')))>0){
                            \$arr=find{$modelClass}(\$arr,\$m->id,(\$s.'-'));
                        }
                    }
                    return \$arr;
                }
                \$arr=find{$modelClass}(array('0'=>'Верхний уровень'),0);
                if(\$arr[\$model->id]!=''){
                    \$arr[\$model->id].=' <<<';
                }
                echo \$form->dropDownListRow(\$model, 'parent_id',\$arr,array('class'=>'span12'));";
        else if (preg_match("/^parent_(\w+)_id$/", $column->name, $a)) { //&& $column->isForeignKey
            //Определения модули по названию поля.        	
            $a = ucfirst($a[1]);
            $basePath = Yii::getPathOfAlias('application.models');
            if (is_file($basePath . '/' . $a . '.php')) {                
                $model = CActiveRecord::model($a);
                $t = $model->attributes;
                $title=$this->guessNameColumn($model->tableSchema->columns);
                return "\$form->autoFieldRow(\$model, '{$column->name}', array('class' => 'span6'), array('relation'=>'parent{$a}','title'=>'{$title}'));";
            } else {
                return "\$form->textFieldRow(\$model, '{$column->name}',array('class'=>'span12')$lang);";
            }
        }
		else
		{
			if (stripos($column->dbType, 'text') !== false || (stripos($column->name, 'content') !== false))
			{
				return "\$form->textAreaRow(\$model, '{$column->name}',array('class'=>'span12')$lang);";
			}
			else
			{
				if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
				{
					$inputField = 'passwordFieldRow';
				}
				else
				{
					$inputField = 'textFieldRow';
				}
				if ($column->type !== 'string' || $column->size === null)
				{
					return "\$form->{$inputField}(\$model, '{$column->name}',array('class'=>'span12')$lang)";
				}
				else
				{
					if (($size = $maxLength = $column->size) > 60)
					{
						$size = 60;
					}
					return "\$form->{$inputField}(\$model, '{$column->name}', array('size' => {$size}, 'maxlength' => {$maxLength}, 'class'=>'span12')$lang)";
				}
			}
		}
	}

	public function guessNameColumn($columns)
	{
		
		foreach($columns as $column)
		{
			if(strstr($column->name,'title'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if(strstr($column->name,'name'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if($column->isPrimaryKey)
				return $column->name;
		}
		return 'id';
	}
}
