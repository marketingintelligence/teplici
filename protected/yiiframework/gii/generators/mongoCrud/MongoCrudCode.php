<?php

class MongoCrudCode extends CCodeModel {

    public $model;
    public $controller;
    public $baseControllerClass = 'CMongoController';
    private $_modelClass;
    private $_collection;
    public $columns;
    public $vars;

    public function rules() {
        return array_merge(parent::rules(), array(
            array('model, controller', 'filter', 'filter' => 'trim'),
            array('model, controller, baseControllerClass', 'required'),
            array('model', 'match', 'pattern' => '/^\w+[\w+\\.]*$/', 'message' => '{attribute} should only contain word characters and dots.'),
            array('controller', 'match', 'pattern' => '/^\w+[\w+\\/]*$/', 'message' => '{attribute} should only contain word characters and slashes.'),
            array('baseControllerClass', 'match', 'pattern' => '/^\w+$/', 'message' => '{attribute} should only contain word characters.'),
            array('model', 'validateModel'),
            array('baseControllerClass', 'sticky'),
        ));
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'model' => 'Название модели',
            'controller' => 'Название контроллера',
            'baseControllerClass' => 'Базовый класс',
        ));
    }

    public function requiredTemplates() {
        return array(
            'controller.php',
        );
    }

    public function init() {
        if (Yii::app()->db === null)
            throw new CHttpException(500, 'Нет соединения с БД');
        parent::init();
    }

    public function successMessage() {
        $link = CHtml::link('тестировать!', Yii::app()->createUrl($this->controller), array('target' => '_blank'));
        return "Контроллер был успешно сгенерирован. Вперёд $link.";
    }

    public function validateModel($attribute, $params) {
        if ($this->hasErrors('model'))
            return;
        $class = @Yii::import($this->model, true);
        if (!is_string($class) || !class_exists($class, false))
            $this->addError('model', "Класс '{$this->model}' не существует.");
        else if (!is_subclass_of($class, 'SMongo'))
            $this->addError('model', "'{$this->model}' должен быть потомком от SMongo.");
        else {
            $n =new $class;
            $opt=$n->modelOption();
            if(sizeof($opt['fields'])==0){
                $this->addError('model', " У класса '{$this->model}' должны быть определены поля. (fields)");
            }else{
                $this->_modelClass = $class;
                $this->_collection = $class;
                $this->vars = get_object_vars($n);
                $this->columns = $opt['fields'];

            }


        }
    }

    public function prepare() {
        $this->files = array();
        $templatePath = $this->templatePath;
        $controllerTemplateFile = $templatePath . DIRECTORY_SEPARATOR . 'controller.php';

        $this->files[] = new CCodeFile(
            $this->controllerFile,
            $this->render($controllerTemplateFile)
        );

        $files = scandir($templatePath);
        foreach ($files as $file) {
            if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php' && $file !== 'controller.php') {
                $this->files[] = new CCodeFile(
                    $this->viewPath . DIRECTORY_SEPARATOR . $file,
                    $this->render($templatePath . '/' . $file)
                );
            }
        }
    }

    public function getModelClass() {
        return $this->_modelClass;
    }

    public function getControllerClass() {
        if (($pos = strrpos($this->controller, '/')) !== false)
            return ucfirst(substr($this->controller, $pos + 1)) . 'Controller';
        else
            return ucfirst($this->controller) . 'Controller';
    }

    public function getModule() {
        if (($pos = strpos($this->controller, '/')) !== false) {
            $id = substr($this->controller, 0, $pos);
            if (($module = Yii::app()->getModule($id)) !== null)
                return $module;
        }
        return Yii::app();
    }

    public function getControllerID() {
        if ($this->getModule() !== Yii::app())
            $id = substr($this->controller, strpos($this->controller, '/') + 1);
        else
            $id = $this->controller;
        if (($pos = strrpos($id, '/')) !== false)
            $id[$pos + 1] = strtolower($id[$pos + 1]);
        else
            $id[0] = strtolower($id[0]);
        return $id;
    }

    public function getUniqueControllerID() {
        $id = $this->controller;
        if (($pos = strrpos($id, '/')) !== false)
            $id[$pos + 1] = strtolower($id[$pos + 1]);
        else
            $id[0] = strtolower($id[0]);
        return $id;
    }

    public function getControllerFile() {
        $module = $this->getModule();
        $id = $this->getControllerID();
        if (($pos = strrpos($id, '/')) !== false)
            $id[$pos + 1] = strtoupper($id[$pos + 1]);
        else
            $id[0] = strtoupper($id[0]);
        return $module->getControllerPath() . '/' . $id . 'Controller.php';
    }

    public function getViewPath() {
        return $this->getModule()->getViewPath() . '/' . $this->getControllerID();
    }
    
    public function generateActiveLabel($modelClass, $column) {
        return "\$form->labelEx(\$model,'{$column}')";
    }

    public function generateActiveField($modelClass, $name,$field,$lang=false) {
        if ($field['type'] == 'boolean' || $field['type'] == 'checkbox')
            return "<?php echo \$form->checkBox(\$model,'{$name}')"."; ?>\n";
        else if($field['type']=='date' || $field['type']=='datetime'){
            return "
        <?php echo CHtml::activeTextField(\$model, '{$name}', array('id' => '_date-{$name}', 'class' => 'date')); ?>
        <?php \$this->widget('application.extensions.anyTime.CAnyTime', array('inputDate' => '_date-{$name}','tz'=>true))?>
            ";
        }elseif($field['type']=='image'){
            return "
        <?php echo CHtml::fileField('{$name}'); ?>
        <?php
        if(\$model->{$name}){
        echo '<div class=\"picture\">' . CHtml::link(CHtml::image('/img/show/id/' . \$model->{$name}), '/img/show/type/full/id/' . \$model->{$name}.'.png', array('target' => '_blank')) . '</div>';
        echo CHtml::hiddenField('{$name}-src', \$model->{$name});
    }
    ?>";
        }elseif ($field['type'] == 'textarea'){
            if($lang==false){
                $editor=$field['editor']===false?'':"<?php \$this->widget('application.extensions.elrte.elRTE', array('model' => \$model, 'attribute' => '$name')); ?>";
                // TODO подключить больше вариантов редакторов
                return "<?php echo \$form->textArea(\$model,'{$name}',array('rows'=>6, 'cols'=>50))"."; ?>
            ".$editor."\n";
            }else{
                $editor=$field['editor']===false?'':"<?php \$this->widget('application.extensions.elrte.elRTE', array('model' => \$model,'textId'=>'{$modelClass}_{$name}_'.\$lang)); ?>";
                // TODO подключить больше вариантов редакторов
                // $this->widget('application.extensions.redactor.redactor',array('attribute'=>'Page_text_ru')); Вариант №1
                
                return "<?=CHtml::textArea('{$modelClass}[{$name}]['.\$lang.']',\$model->{$name}[\$lang],array('rows'=>6, 'cols'=>50,'id'=>'{$modelClass}_{$name}_'.\$lang))"."; ?>
            ".$editor."\n";
            }
        }elseif($field['type']=='parent'){
            return '<span id="parentTitle"><?=$parent[\'title\']?$parent[\'title\']:\'Не выбран\'?></span>
        <button class="btn" type="button" onclick="_parents();"><span><span class="folders">Выбрать</span></span></button>
        <?php echo $form->hiddenField($model, \'parent\',array(\'id\'=>\'parentId\')); ?>'."\n";
        }
        else {
            if ($field['type'] == 'password')
                $inputField = 'passwordField';
            else
                $inputField = 'textField';

            if ($field['size']==0)
                if ($lang==true)
                    return "<?=CHtml::textField('{$modelClass}[{$name}]['.\$lang.']',\$model->{$name}[\$lang])"."; ?>\n";
                else
                    return "<?php echo \$form->{$inputField}(\$model,'{$name}')"."; ?>\n";
            else {
                if (($size = $maxLength = $field['size']) > 60)
                    $size = 60;
                if ($lang==true)
                    return "<?=CHtml::textField('{$modelClass}[{$name}]['.\$lang.']',\$model->{$name}[\$lang],array('size'=>$size,'maxlength'=>".$field['size']."))"."; ?>\n";
                else
                    return "<?php echo \$form->{$inputField}(\$model,'{$name}',array('size'=>$size,'maxlength'=>".$field['size']."))"."; ?>\n";
            }
        }
    }

    public function guessNameColumn($columns) {

        foreach ($columns as $column) {
            if (strstr($column->name, 'name'))
                return $column->name;
            if (strstr($column->name, 'title'))
                return $column->name;

        }
        foreach ($columns as $column) {
            if ($column->isPrimaryKey)
                return $column->name;
        }
        return 'id';
    }

}