<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	$this->modelClass::modelTitle()=>array('index'),
	'Добавить',
);\n";
?>

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index'),'linkOptions'=>array('class'=>'m-list')),
	array('label'=>'Управление', 'url'=>array('admin'),'linkOptions'=>array('class'=>'m-admin')),
);
?>

<h1>Добавить</h1>

<?php
echo "<?php \$this->renderPartial('admin.components.views.operations');?>";
echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model,'create'=>true)); ?>"; ?>
