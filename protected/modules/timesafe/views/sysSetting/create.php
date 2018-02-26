<?php
$this->menu = array(
	array('label' => SysSetting::modelTitle(), 'url' => array('index')),
	array('label' => 'Добавить', 'url' => array('create')),
);
$this->breadcrumbs=array(
    SysSetting::modelTitle()=>array('index'),
    'Изменить'
);
?>
<h2 class="title">Добавить</h2>
<div class="inner">
    <?php $this->renderPartial('_form', array(
        'model' => $model,
    )); ?>
</div>
