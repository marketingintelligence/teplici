<?php
$this->menu = array(
	array('label' => 'Sys Settings', 'url' => array('index')),
	array('label' => 'Create sys setting', 'url' => array('create')),
	array('label' => 'Update sys setting', 'url' => array('update', 'id' => $model->id)),
	array('label' => 'Delete sys setting', 'url' => '#', 'linkOptions' => array(
		'submit' => array('delete', 'id' => $model->id),
		'confirm' => 'Do you really want to delete this sys setting?',
	)),
);

$this->breadcrumbs=array(
    SysSetting::modelTitle()=>array('index'),
    'Просмотр'
);
?>
<h2 class="title">Sys Setting's details</h2>
<div class="inner">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
					'id',
					'parent_Module_id',
					'type',
					'title',
					'name',
					'value',
					'value_kaz',
        ),
        'itemTemplate' => "<tr class=\"{class}\"><td style=\"width: 120px\"><b>{label}</b></td><td>{value}</td></tr>\n",
        'htmlOptions' => array(
            'class' => 'table',
        ),
    )); ?>
</div>