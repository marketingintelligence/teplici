<?php
/**
 * Шаблон для генерации модели
 * - $this: объект ModelCode
 * - $tableName: имя таблицы
 * - $modelClass: имя класса
 * - $columns: список полей
 * - $labels: список значений полей
 * - $rules: список валидаций
 * - $relations: связи
 */
?>
<?php echo "<?php\n"; ?>
/**
 * Модель для таблицы "<?php echo $tableName; ?>".
 *
 * Поля:
<?php
$image=false;
$lang=false;
$order=false;
$langField=array();
$images = array();
$parent_id= false;
$title = $this->guessNameColumn($columns);
foreach($columns as $column):
    if(stripos($column->name,'image')!==false || stripos($column->name,'file')) {
        $image=true;
        $images[]=$column->name;
    }
    if($column->name=='language') $lang=true;
    if($column->name=='parent_id') $parent_id=true;
    if($column->name=='created_at') $order='created_at DESC';
    if($column->name=='weight') $order='weight';
    if(strpos($column->name,'_ru')!==false)
        $langField[]=$column->name;
    ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
 *
 * Связи:
<?php foreach($relations as $name=>$relation): ?>
 * @property <?php
	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch($relationType){
            case 'HAS_ONE':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'BELONGS_TO':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'HAS_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            case 'MANY_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            default:
                echo 'mixed $'.$name."\n";
        }
	}
    ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends <?php echo $this->baseClass."\n"; ?>
{
	/**
	 * @return <?php echo $modelClass; ?> the static model class
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
		return '<?=$this->modelClassName?>';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '<?php echo $tableName; ?>';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
<? if($parent_id):?>
            'parent'=> array(self::BELONGS_TO, __CLASS__, 'parent_id', 'select' => '<?=$title?>, ancestors, parent_id, id'),            
            'childCount'   => array(self::STAT, __CLASS__, 'parent_id')
<? endif; ?>
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
<?php foreach($labels as $name=>$label): ?>
			<?php echo "'$name' => '{$this->labels[$name]}',\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 *
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
<?php
$not=array('KEYWORDS','DESCRIPTION','METATITLE','KEYWORDS_kz','DESCRIPTION_kz','METATITLE_kz','KEYWORDS_en','DESCRIPTION_en','METATITLE_en');
foreach($columns as $name=>$column)
{

if(stripos($column->name,'text')===false && stripos($column->name,'image')===false && stripos($column->name,'weight')===false && stripos($column->name,'file')===false && stripos($column->name,'content')===false && stripos($column->name,'date')===false && stripos($column->name,'_at')===false && !in_array($column->name,$not)){
    if($column->type==='string' )
    {
        echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n";
    }
    elseif($column->name=='is_removed')
    {
        echo "\t\t\$criteria->compare('$name',0);\n";
    }
    else
    {
        echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
    }
}
}
?>
        <? if($parent_id):?>$criteria->with = 'childCount';
        $pagination     = false;
        if ($_GET['ajax'] == 'search-form')
            $pagination = array('pageSize'=> 30);
<? else:?>$pagination = array('pageSize'=> 30);
<?endif; ?>
        return new CActiveDataProvider($this,array(
            'criteria'   => $criteria,
            'pagination' => $pagination
        ));
	}
    
<? if($parent_id):?>
    public function getParents() {
        return json_decode((string)$this->ancestors);
    }
<? endif; ?>
    public function beforeValidate() {
<?php
foreach($columns as $name=>$column)
{
	if(stripos($column->name,'_at')!==false || stripos($column->name,'date')!==false)
	{
        echo "\tif (\$this->$name==0) {\n\t\t\$this->$name=date('d-m-Y');\t\n\t}\n";
        echo "\tif (strstr(\$this->$name,'-')) {\n\t\t\$date=explode('-',\$this->$name);\n\t\t\$this->$name=mktime(0,0,0,\$date[1],\$date[0],\$date[2]);\n\t}\n";
	}
}
?>
<? if($parent_id):?>
        $p    = array();
        $oldA = $this->ancestors;


        if ($this->parent_id > 0) {
            $p   = $this->parent->parents;
            $p[] = (string)$this->parent_id;
        }
        $this->ancestors = json_encode((array)$p);


        if ($oldA != $this->ancestors && !$this->isNewRecord) {
            $pages = <?=$modelClass?>::model()->findAll(
                array(
                     'condition'  => "ancestors LIKE '%" . $this->id . "%'",
                     'select'     => 'ancestors, id'
                )
            );

            foreach ($pages as $page) {
                $replace = $this->ancestors == '[]'?(trim($oldA, ']') . ','):trim($oldA, ']');
                $newA    = str_replace($replace, trim($this->ancestors, ']'), $page->ancestors);
                <?=$modelClass?>::model()->updateByPk($page->id, array('ancestors' => $newA));
            }

        }
<? endif;?>
        return true;
    }
<? foreach($langField as $f): $ff = explode('_',$f); ?>
    public function get<?=ucfirst($ff[sizeof($ff)-2])?>() {
        $lang=Yii::app()->language;
        $f='<?=$ff[0]?>_'.$lang;
        return $this->$f;
    }
<? endforeach; ?>
    <? if($lang===true):?>
    //<?php echo $className; ?>::model()->lang('en')->lang('ru')->findAll();
    public function lang($lang='') {
        if(!$lang){$lang=Yii::app()->language;}
        $this->getDbCriteria()->mergeWith(array(
            'language'=>"`language`='".$lang."'",
        ));
        return $this;
    }
    public function defaultScope() {
        return array(
            'condition'=>"`language`='".Yii::app()->language."'",
        );
    }
    <?endif;?>
    <? if($order!=false):?>
    public function defaultScope() {
        return array(
            'order' => '<?=$order?>',
        );
    }
    <?endif;?>
    <? if($image!=false  && $this->hasImage!='0'):?>
    /**
    * Функция для получения пути к изображению
    * @type  - путь к изображению
    * @preview - превью если нет изображения
    * @allowEmpty - принудительный вывод
    */
    public function getPreview($field = 'image', $type = 'sm', $preview = false, $allowEmpty = false) {
        $filename = 'upload/' . __CLASS__ . '/' . $type . '/' . $this->$field;
        if (is_file($filename) || $allowEmpty) {
            $htmlSize = array('title' => CHtml::encode($this->title));
            if (!$allowEmpty) {
                $htmlSize['width']  = $size[0];
                $htmlSize['height'] = $size[1];
                $size               = getimagesize($filename);
            }
            return CHtml::image('/' . $filename, CHtml::encode($this->title), $htmlSize);
        } elseif ($preview) {
            $filename = 'upload/' . __CLASS__ . '/preview.png';
            if(is_file($filename)){
                $size     = getimagesize($filename);
                return CHtml::image(
                    '/'.$filename, '', array(
                                'width'  => $size[0],
                                'height' => $size[1]));
                            }
        }
        return null;
    }

    public function beforeDelete(){
        $option  = $this->options();
        foreach ($option['images'] as $type=>$size){  
            <? foreach ($images as $img):?>          
            if(is_file('upload/'.__CLASS__.'/'.$type.'/'.$this-><?=$img?>)){
                unlink('upload/'.__CLASS__.'/'.$type.'/'.$this-><?=$img?>);
            }
        <? endforeach;?>}
        return true;
    }    
    <?endif;?>

    /**
	 * @return array of model options
	 */     
	public function options()
	{
        return array(<? if($image==true && $this->hasImage!='0'): echo "
            'images' => array(";
                
                foreach ($this->images['path'] as $key=>$type){
                    $size = explode('x',$this->images['size'][$key]);
                    echo "
                '{$type}' => array(
                    'width' => {$size[0]},
                    'height' => {$size[1]},
                    'type' => '{$this->images['type'][$key]}'
                ),
            ";
                }
            echo ")
        ";endif;
        ?>);
	}

<? if($this->trash):?>    function behaviors() {
        return array(
            'trash' => array(
                'class'          => 'ext.yiiext.behaviors.model.trashBin.ETrashBinBehavior',
                'trashFlagField' => 'is_removed'
            ),
        );
    }
<? endif;?>
    
}