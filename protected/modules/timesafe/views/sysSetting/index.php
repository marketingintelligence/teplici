<?php
$url = CJavaScript::quote($this->createUrl('create'), true);
Yii::app()->clientScript
	->registerCoreScript('jquery')
	->registerScript('sys-setting-grid-init', "
$('#sys-setting-grid-actions button.action-create').live('click', function(){
	document.location.href = '{$url}';
	return false;
});
	");
$this->breadcrumbs=array(
	SysSetting::modelTitle(),
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index')),
	array('label' => 'Добавить', 'url' => array('create')),
);
?>
<div class="fl">
    <h2 class="title"><?=SysSetting::modelTitle()?></h2>
</div>
    <div class="fr type-select" style="padding:15px 10px">
        <button type="button" class="button <?=($this->type==='text')?' selected':''?>" id="text">
            <span class="type-text">Значения</span>
        </button>
        <button type="button" class="button <?=($this->type==='html')?' selected':''?>" id="html">
            <span class="type-html">Тексты</span>
        </button>

        <button type="button" class="button <?=($this->type==='option')?' selected':''?>" id="option">
            <span class="type-option">Опции</span>
        </button>
        <button type="button" class="button <?=($this->type===null)?' selected':''?>" id="all">
            <span class="type-all">Все</span>
        </button>
    </div>
    <div class="clear">&nbsp;</div>
<?php $this->renderPartial('_grid', array(
    'model' => $model,
)); ?>
<script type="text/javascript">
    $('.type-select button').click(function(){
        document.location.href='/timesafe/SysSetting/index/type/'+this.id;
    });
</script>
