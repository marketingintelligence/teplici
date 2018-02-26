<?php
/**
 * This is the template for generating the update view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<?php
$ID=$this->tableSchema->primaryKey;
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
echo "\$this->breadcrumbs=array(
	$this->modelClass::modelTitle()=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$ID}),
	'Изменить',
);\n";
?>

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index'),'linkOptions'=>array('class'=>'m-list')),
	array('label'=>'Добавить', 'url'=>array('create'),'linkOptions'=>array('class'=>'m-add')),
	array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model-><?php echo $ID; ?>),'linkOptions'=>array('class'=>'m-show')),
	array('label'=>'Управление', 'url'=>array('admin'),'linkOptions'=>array('class'=>'m-admin')),
);
?>

<h1>Изменить "<?php echo "<?php echo \$model->{$nameColumn}; ?>"; ?>"</h1>
<?php echo "<?php \$this->renderPartial('admin.components.views.operations');?>"; ?>
<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
