<?php
$this->breadcrumbs=array(
    Contacts::modelTitle()=> array('list'),
    'Редактирование "'.$model->name_text.'"'
);
$this->renderPartial('_formmap', array(
    'model' => $model, 'page'=>$page
));
?>