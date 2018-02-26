<?php
$this->breadcrumbs=array(
    User::modelTitle()=> array('list'),
    'Редактирование "<strong>'.$model->title.'</strong>"'
);
$this->renderPartial('_form', array(
    'model' => $model, 'page'=>$page
)); ?>