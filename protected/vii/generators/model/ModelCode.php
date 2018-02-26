<?php

class ModelCode extends CCodeModel {
    public $tablePrefix;
    public $tableName;
    public $modelClassName;
    public $modelClass;
    public $modelPath = 'application.models';
    public $baseClass = 'CActiveRecord';
    public $buildRelations = true;
    public $trash = true;
    public $hasImage = false;
    public $images = array(
        'path'=> array('full', 'sm','tm'),
        'size'=> array('600x600', '120x120', '160x120'),
        'type'=> array('resize', 'resize','crop'),
    );
    public $labels = array();

    /**
     * @var array list of candidate relation code. The array are indexed by AR class names and relation names.
     * Each element represents the code of the one relation in one AR class.
     */
    protected $relations;

    public function rules() {
        return array_merge(
            parent::rules(), array(
                                  array(
                                      'tablePrefix, baseClass, tableName, modelClass, modelPath', 'filter',
                                      'filter'=> 'trim'),
                                  array('tableName, modelPath, baseClass, modelClassName', 'required'),
                                  array(
                                      'tablePrefix, tableName, modelPath', 'match',
                                      'pattern'=> '/^(\w+[\w\.]*|\*?|\w+\.\*)$/',
                                      'message'=> '{attribute} should only contain word characters, dots, and an optional ending asterisk.'),
                                  array(
                                      'tableName', 'validateTableName',
                                      'skipOnError'=> true),
                                  array(
                                      'tablePrefix, modelClass, baseClass', 'match',
                                      'pattern'=> '/^[a-zA-Z_]\w*$/',
                                      'message'=> '{attribute} должен содержать только буквы.'),
                                  array(
                                      'modelPath', 'validateModelPath',
                                      'skipOnError'=> true),
                                  array(
                                      'baseClass, modelClass', 'validateReservedWord',
                                      'skipOnError'=> true),
                                  array(
                                      'baseClass', 'validateBaseClass',
                                      'skipOnError'=> true),
                                  array('tablePrefix, modelPath, baseClass, buildRelations', 'sticky'),
                                  array('trash', 'checkTrashField'),
                                  array('hasImage', 'checkHasImage'),
                                  array('images,labels', 'safe'),
                                  array('images','createFolders')
                             ));
    }

    public function attributeLabels() {
        return array_merge(
            parent::attributeLabels(), array(
                                            'tablePrefix'   => 'Префикс',
                                            'tableName'     => 'Имя таблицы',
                                            'modelPath'     => 'Путь',
                                            'modelClass'    => 'Имя модели',
                                            'baseClass'     => 'Родительский класс',
                                            'buildRelations'=> 'Создавать связи?',
                                            'trash'         => 'Удаляемая в корзину модель?',
                                            'modelClassName'=> 'Название модели'
                                       ));
    }

    public function requiredTemplates() {
        return array(
            'model.php',
        );
    }

    public function init() {
        if (Yii::app()->db === null)
            throw new CHttpException(500, 'An active "db" connection is required to run this generator.');
        $this->tablePrefix = Yii::app()->db->tablePrefix;
        parent::init();
    }
    public function createFolders(){
        if(!is_dir('upload/'.$this->modelClass)) mkdir('upload/'.$this->modelClass);
        foreach ($this->images['path'] as $key=>$path){
            if(!is_dir('upload/'.$this->modelClass.'/'.$path)) mkdir('upload/'.$this->modelClass.'/'.$path);
        }
    }

    public function prepare() {
        if (($pos = strrpos($this->tableName, '.')) !== false) {
            $schema    = substr($this->tableName, 0, $pos);
            $tableName = substr($this->tableName, $pos + 1);
        }
        else
        {
            $schema    = '';
            $tableName = $this->tableName;
        }
        if ($tableName[strlen($tableName) - 1] === '*') {
            $tables = Yii::app()->db->schema->getTables($schema);
            if ($this->tablePrefix != '') {
                foreach ($tables as $i=> $table)
                {
                    if (strpos($table->name, $this->tablePrefix) !== 0)
                        unset($tables[$i]);
                }
            }
        }
        else
            $tables = array($this->getTableSchema($this->tableName));

        $this->files     = array();
        $templatePath    = $this->templatePath;
        $this->relations = $this->generateRelations();

        foreach ($tables as $table)
        {
            $tableName     = $this->removePrefix($table->name);
            $className     = $this->generateClassName($table->name);
            $params        = array(
                'tableName' => $schema === '' ? $tableName : $schema . '.' . $tableName,
                'modelClass'=> $className,
                'columns'   => $table->columns,
                'labels'    => $this->generateLabels($table),
                'rules'     => $this->generateRules($table),
                'relations' => isset($this->relations[$className]) ? $this->relations[$className] : array(),
            );
            $this->files[] = new CCodeFile(
                Yii::getPathOfAlias($this->modelPath) . '/' . $className . '.php',
                $this->render($templatePath . '/model.php', $params)
            );
        }
    }

    public function checkTrashField($attribute) {
        if ($this->trash == 1) {
            $table = Yii::app()->db->getSchema()->getTable($this->tableName);
            $find  = false;
            if ($table) {
                foreach ($table->columns as $colunm) {
                    if ($colunm->name == 'is_removed') {
                        $find = true;
                    }
                }
            }
            if (!$find) {
                $this->addError('trash', 'В таблице не найдено поле "<code>is_removed</code>"');
                $this->trash = 0;
            }
        }
        return true;
    }

    public function checkHasImage() {
        if ($this->hasImage) {
            foreach ((array)$this->images['size'] as $key=> $val) {
                if ($val != '') {
                    $size    = explode('x', $val);
                    $size[0] = (int)$size[0];
                    if (!isset($size[1]))
                        $size[1] = $size[0];
                    $this->images['size'][$key] = implode('x', $size);
                }
            }
        }
        return true;
    }

    public function validateTableName($attribute, $params) {
        $invalidColumns = array();

        if ($this->tableName[strlen($this->tableName) - 1] === '*') {
            if (($pos = strrpos($this->tableName, '.')) !== false)
                $schema = substr($this->tableName, 0, $pos);
            else
                $schema = '';

            $this->modelClass = '';
            $tables           = Yii::app()->db->schema->getTables($schema);
            foreach ($tables as $table)
            {
                if ($this->tablePrefix == '' || strpos($table->name, $this->tablePrefix) === 0) {
                    if (($invalidColumn = $this->checkColumns($table)) !== null)
                        $invalidColumns[] = $invalidColumn;
                }
            }
        }
        else
        {
            if (($table = $this->getTableSchema($this->tableName)) === null)
                $this->addError('tableName', "Таблица '{$this->tableName}' не существует в БД.");
            if ($this->modelClass === '')
                $this->addError('modelClass', 'Заполни имя таблицы.');

            if (!$this->hasErrors($attribute) && ($invalidColumn = $this->checkColumns($table)) !== null)
                $invalidColumns[] = $invalidColumn;
        }

        if ($invalidColumns != array())
            $this->addError('tableName', "Column names that does not follow PHP variable naming convention: " . implode(', ', $invalidColumns) . ".");
    }

    /*
      * Check that all database field names conform to PHP variable naming rules
      * For example mysql allows field name like "2011aa", but PHP does not allow variable like "$model->2011aa"
      * @param CDbTableSchema $table the table schema object
      * @return string the invalid table column name. Null if no error.
      */
    public function checkColumns($table) {
        foreach ($table->columns as $column)
        {
            if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $column->name))
                return $table->name . '.' . $column->name;
        }
    }

    public function validateModelPath($attribute, $params) {
        if (Yii::getPathOfAlias($this->modelPath) === false)
            $this->addError('modelPath', 'Путь к папке моделей должен быть правильным псевдонимом.');
    }

    public function validateBaseClass($attribute, $params) {
        $class = @Yii::import($this->baseClass, true);
        if (!is_string($class) || !$this->classExists($class))
            $this->addError('baseClass', "Класс '{$this->baseClass}' не существует или допущена синтаксическая ошибка.");
        else if ($class !== 'CActiveRecord' && !is_subclass_of($class, 'CActiveRecord'))
            $this->addError('baseClass', "'{$this->model}' должна наследоваться от CActiveRecord.");
    }

    public function getTableSchema($tableName) {
        return Yii::app()->db->getSchema()->getTable($tableName);
    }

    public function generateLabels($table) {
        $dictionary = array(
            'title_ru'      => 'Заголовок',
            'title_en'      => 'Заголовок EN',
            'title_kz'      => 'Заголовок KZ',
            'content_ru'    => 'Описание',
            'content_kz'    => 'Описание KZ',
            'content_en'    => 'Описание EN',
            'text_ru'       => 'Содержание',
            'text_kz'       => 'Содержание KZ',
            'text_en'       => 'Содержание EN',
            'created_at'    => 'Дата создания',
            'updated_at'    => 'Дата обновления',
            'status'        => 'Видимость',
            'weight'        => 'Порядок',
            'date'          => 'Дата',
            'metatitle'     => 'Мета-заголовок',
            'metatitle_kz'  => 'Мета-заголовок',
            'metatitle_en'  => 'Мета-заголовок',
            'keywords'      => 'Ключевые слова',
            'keywords_kz'   => 'Ключевые слова',
            'keywords_en'   => 'Ключевые слова',
            'description'   => 'Мета-описание',
            'description_kz'=> 'Мета-описание',
            'description_en'=> 'Мета-описание',
            'price'         => 'Цена',
            'image'         => 'Изображение',
            'file'          => 'Файл',
            'type'          => 'Тип',
            'parent_id'     => 'Верхний уровень',
        );

        $labels = array();
        foreach ($table->columns as $column)
        {
            $label = ucwords(trim(strtolower(str_replace(array('-', '_'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $column->name)))));
            $label = preg_replace('/\s+/', ' ', $label);
            if (strcasecmp(substr($label, -3), ' id') === 0)
                $label = substr($label, 0, -3);
            if ($label === 'Id')
                $label = 'ID';

            if ($dictionary[$column->name])
                $label = $dictionary[$column->name];
            $labels[$column->name] = $label;
        }
        return $labels;
    }

    public function generateRules($table) {
        $rules     = array();
        $required  = array();
        $integers  = array();
        $numerical = array();
        $length    = array();
        $safe      = array();
        foreach ($table->columns as $column)
        {
            if ($column->autoIncrement)
                continue;
            $r = !$column->allowNull && $column->defaultValue === null;
            if ($r)
                $required[] = $column->name;
            if ($column->type === 'integer')
                $integers[] = $column->name;
            else if ($column->type === 'double')
                $numerical[] = $column->name;
            else if ($column->type === 'string' && $column->size > 0)
                $length[$column->size][] = $column->name;
            else if (!$column->isPrimaryKey && !$r)
                $safe[] = $column->name;
        }
        if ($required !== array())
            $rules[] = "array('" . implode(', ', $required) . "', 'required')";
        if ($integers !== array())
            $rules[] = "array('" . implode(', ', $integers) . "', 'numerical', 'integerOnly'=>true)";
        if ($numerical !== array())
            $rules[] = "array('" . implode(', ', $numerical) . "', 'numerical')";
        if ($length !== array()) {
            foreach ($length as $len=> $cols)
                $rules[] = "array('" . implode(', ', $cols) . "', 'length', 'max'=>$len)";
        }
        if ($safe !== array())
            $rules[] = "array('" . implode(', ', $safe) . "', 'safe')";

        return $rules;
    }

    public function getRelations($className) {
        return isset($this->relations[$className]) ? $this->relations[$className] : array();
    }

    protected function removePrefix($tableName, $addBrackets = true) {
        if ($addBrackets && Yii::app()->db->tablePrefix == '')
            return $tableName;
        $prefix = $this->tablePrefix != '' ? $this->tablePrefix : Yii::app()->db->tablePrefix;
        if ($prefix != '') {
            if ($addBrackets && Yii::app()->db->tablePrefix != '') {
                $prefix = Yii::app()->db->tablePrefix;
                $lb     = '{{';
                $rb     = '}}';
            }
            else
                $lb = $rb = '';
            if (($pos = strrpos($tableName, '.')) !== false) {
                $schema = substr($tableName, 0, $pos);
                $name   = substr($tableName, $pos + 1);
                if (strpos($name, $prefix) === 0)
                    return $schema . '.' . $lb . substr($name, strlen($prefix)) . $rb;
            }
            else if (strpos($tableName, $prefix) === 0)
                return $lb . substr($tableName, strlen($prefix)) . $rb;
        }
        return $tableName;
    }

    protected function generateRelations() {
        if (!$this->buildRelations)
            return array();
        $relations = array();
        foreach (Yii::app()->db->schema->getTables() as $table)
        {
            if ($this->tablePrefix != '' && strpos($table->name, $this->tablePrefix) !== 0)
                continue;
            $tableName = $table->name;

            if ($this->isRelationTable($table)) {
                $pks = $table->primaryKey;
                $fks = $table->foreignKeys;

                $table0     = $fks[$pks[0]][0];
                $table1     = $fks[$pks[1]][0];
                $className0 = $this->generateClassName($table0);
                $className1 = $this->generateClassName($table1);

                $unprefixedTableName = $this->removePrefix($tableName);

                $relationName                          = $this->generateRelationName($table0, $table1, true);
                $relations[$className0][$relationName] = "array(self::MANY_MANY, '$className1', '$unprefixedTableName($pks[0], $pks[1])')";

                $relationName                          = $this->generateRelationName($table1, $table0, true);
                $relations[$className1][$relationName] = "array(self::MANY_MANY, '$className0', '$unprefixedTableName($pks[1], $pks[0])')";
            }
            else
            {
                $className = $this->generateClassName($tableName);
                foreach ($table->foreignKeys as $fkName => $fkEntry)
                {
                    // Put table and key name in variables for easier reading
                    $refTable     = $fkEntry[0]; // Table name that current fk references to
                    $refKey       = $fkEntry[1]; // Key in that table being referenced
                    $refClassName = $this->generateClassName($refTable);

                    // Add relation for this table
                    $relationName                         = $this->generateRelationName($tableName, $fkName, false);
                    $relations[$className][$relationName] = "array(self::BELONGS_TO, '$refClassName', '$fkName')";

                    // Add relation for the referenced table
                    $relationType = $table->primaryKey === $fkName ? 'HAS_ONE' : 'HAS_MANY';
                    $relationName = $this->generateRelationName($refTable, $this->removePrefix($tableName, false), $relationType === 'HAS_MANY');
                    $i            = 1;
                    $rawName      = $relationName;
                    while (isset($relations[$refClassName][$relationName]))
                        $relationName = $rawName . ($i++);
                    $relations[$refClassName][$relationName] = "array(self::$relationType, '$className', '$fkName')";
                }
            }
        }
        return $relations;
    }

    /**
     * Checks if the given table is a "many to many" pivot table.
     * Their PK has 2 fields, and both of those fields are also FK to other separate tables.
     *
     * @param CDbTableSchema table to inspect
     * @return boolean true if table matches description of helpter table.
     */
    protected function isRelationTable($table) {
        $pk = $table->primaryKey;
        return (count($pk) === 2 // we want 2 columns
                && isset($table->foreignKeys[$pk[0]]) // pk column 1 is also a foreign key
                && isset($table->foreignKeys[$pk[1]]) // pk column 2 is also a foriegn key
                && $table->foreignKeys[$pk[0]][0] !== $table->foreignKeys[$pk[1]][0]); // and the foreign keys point different tables
    }

    protected function generateClassName($tableName) {
        if ($this->tableName === $tableName || ($pos = strrpos($this->tableName, '.')) !== false && substr($this->tableName, $pos + 1) === $tableName)
            return $this->modelClass;

        $tableName = $this->removePrefix($tableName, false);
        $className = '';
        foreach (explode('_', $tableName) as $name)
        {
            if ($name !== '')
                $className .= ucfirst($name);
        }
        return $className;
    }

    /**
     * Generate a name for use as a relation name (inside relations() function in a model).
     *
     * @param string  the name of the table to hold the relation
     * @param string  the foreign key name
     * @param boolean whether the relation would contain multiple objects
     * @return string the relation name
     */
    protected function generateRelationName($tableName, $fkName, $multiple) {
        if (strcasecmp(substr($fkName, -2), 'id') === 0 && strcasecmp($fkName, 'id'))
            $relationName = rtrim(substr($fkName, 0, -2), '_');
        else
            $relationName = $fkName;
        $relationName[0] = strtolower($relationName);

        if ($multiple)
            $relationName = $this->pluralize($relationName);

        $names = preg_split('/_+/', $relationName, -1, PREG_SPLIT_NO_EMPTY);
        if (empty($names))
            return $relationName; // unlikely
        for ($name = $names[0], $i = 1; $i < count($names); ++$i)
            $name .= ucfirst($names[$i]);

        $rawName = $name;
        $table   = Yii::app()->db->schema->getTable($tableName);
        $i       = 0;
        while (isset($table->columns[$name]))
            $name = $rawName . ($i++);

        return $name;
    }

    public function guessNameColumn($columns) {

        foreach ($columns as $column)
        {
            if (strstr($column->name, 'title'))
                return $column->name;
        }
        foreach ($columns as $column)
        {
            if (strstr($column->name, 'name'))
                return $column->name;
        }
        foreach ($columns as $column)
        {
            if ($column->isPrimaryKey)
                return $column->name;
        }
        return 'id';
    }
}