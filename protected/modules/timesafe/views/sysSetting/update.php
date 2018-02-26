<?php
$this->menu = array(
	array('label' => 'Список', 'url' => array('index')),
	array('label' => 'Добавить', 'url' => array('create')),
	array('label' => 'Изменить', 'url' => array('update', 'id' => $model->id)),
	array('label' => 'Удалить', 'url' => '#', 'linkOptions' => array(
		'submit' => array('delete', 'id' => $model->id),
		'confirm' => 'Вы хотите удалить SysSetting::modelTitle()?',
	)),
);
$this->breadcrumbs=array(
    SysSetting::modelTitle()=>array('index'),
    'Изменить'
);
?>
<h2 class="title">Изменить sys setting</h2>
<div class="inner">
    <?php $this->renderPartial('_form', array(
        'model' => $model, 'page'=>$page
    )); ?>
</div>
