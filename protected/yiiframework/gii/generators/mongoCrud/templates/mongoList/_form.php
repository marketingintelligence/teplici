<?php echo "<?php \$this->breadcrumbs=array(
	$this->modelClass::modelTitle()=>array('index'),
	\$update?'Изменить':'Добавить',
);
?>\n"; ?>
<table width="100%">
    <tr>
        <td class="al">&nbsp;
        </td>
        <td class="ar">
            <div class="navigation" id="treecontrol">
                <?php echo "<?php foreach(\$this->languages as \$lang): ?>"?>
                <a href="javascript:;" onclick="_lang('<?="<?"?>=$lang?>')" id="_alang-<?="<?"?>=$lang?>"><?="<?"?>=strtoupper($lang)?></a>
                <?php echo "<?php endforeach;?>"?>
                <a href="javascript:;" onclick="_lang()" id="_alang-all">Все</a>
            </div>
        </td>
    </tr>
</table>
<script type="text/javascript">
    $(document).ready(function(){
        <?php echo "<?=\$_COOKIE['_language']!='all'?'_lang(\''.\$_COOKIE['_language'].'\');':'_lang();'?>"?>
    })
    function _lang(l){
        $(".navigation a.active").removeClass('active');
        if(l==undefined){
            $("#_alang-all").addClass('active');
            $(".lang > div").show();
            l='all';
        }else{
            $(".lang > div").hide();
            $("#_alang-"+l).addClass('active');
            $(".lang > div."+l).show();
        }
        $.cookie('_language', l, options);

    }
</script>
<div class="form">
<?php echo "
<?php \$form = \$this->beginWidget('CActiveForm', array(
    'id' => '".$this->class2id($this->modelClass)."-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
\n"; ?>
    <p class="note"><span class="required">*</span> Обязательные поля</p>
    <?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>



<?php
foreach($this->columns as $name=>$field)
{
	if($column=='_id')
		continue;
    if($field['lang']==true){?>
    <div class="row lang">
    <?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$name)."; ?>\n"; ?>
    <?php echo "<?php foreach(\$this->languages as \$lang): ?>\n"; ?>
        <div class="<?="<?"?>=$lang?>">
            <?php echo $this->generateActiveField($this->modelClass,$name,$field,true); ?>
        </div>
    <?php echo "<?php endforeach; ?>\n"; ?>
    <?php echo "<?php echo \$form->error(\$model,'{$name}'); ?>\n"; ?>
    </div>

    <?}else{
?>
	<div class="row">
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$name)."; ?>\n"; ?>
		<?php echo $this->generateActiveField($this->modelClass,$name,$field); ?>
		<?php echo "<?php echo \$form->error(\$model,'{$name}'); ?>\n"; ?>
	</div>

    <?php
} }
    ?>

    <div class="action">
        <button class="btn" type="submit" name="_save"><span><span class="save">Сохранить</span></span></button>
        <button class="btn" type="submit" name="_saveAdd"><span><span class="saveas">Сохранить и <?php echo "<?=\$update?'продолжить редактирование':'добавить новую запись'?>"; ?></span></span></button>
        <button class="btn" type="button" onclick="document.location.href='<?php echo "<?=\$this->createUrl('index')?>"; ?>'"><span><span class="cancel">Отмена</span></span></button>
    </div>


<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->