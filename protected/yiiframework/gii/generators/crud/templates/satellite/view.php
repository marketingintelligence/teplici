<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	$this->modelClass::modelTitle()=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index'),'linkOptions'=>array('class'=>'m-list')),
	array('label'=>'Добавить', 'url'=>array('create'),'linkOptions'=>array('class'=>'m-add')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'linkOptions'=>array('class'=>'m-edit')),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Вы действительно хотите удалить эту запись?','class'=>'m-delete')),
	array('label'=>'Управление', 'url'=>array('admin'),'linkOptions'=>array('class'=>'m-admin')),
);
?>

<h1><?php echo " <?php echo \$model->{$nameColumn}; ?>"; ?></h1>

<?php
echo "<?php \$this->renderPartial('admin.components.views.operations');?>";
echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
