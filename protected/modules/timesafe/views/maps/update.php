<?php
$this->breadcrumbs=array(
    Maps::modelTitle()=> array('list'),
    'Редактирование "'.$model->name_text.'"'
);
$this->renderPartial('_form', array(
    'model' => $model, 'page'=>$page
));
?>