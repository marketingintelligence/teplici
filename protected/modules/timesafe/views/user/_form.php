<?php $form = $this->beginWidget('BootActiveForm', array(
    'id' => 'user-form',    
//    'stacked' => false,     
      'type' => 'horizontal',     
    'enableAjaxValidation' => true,    
    	'focus' => array($model, 'email'),
    
    'htmlOptions' => array(
        'class' => 'form',
        'enctype'=>'multipart/form-data'
    ),
));
echo CHtml::hiddenField('User_page',$_GET['User_page']);
?>
    <div class="actions">
        <button class="btn success" type="submit">
            <?=$model->isNewRecord ? 'Добавить' : 'Сохранить'; ?>
        </button>
        <span class="text_button_padding">или</span>        
    	<?=CHtml::link('назад', array('list','User_page'=>$_GET['User_page'])); ?>    </div>
        <?php echo $form->textFieldRow($model, 'firstname', array('size' => 60, 'maxlength' => 100, 'class'=>'span12')); ?>
        <?php echo $form->textFieldRow($model, 'lastname', array('size' => 60, 'maxlength' => 100, 'class'=>'span12')); ?>
    	<?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 100, 'class'=>'span12')); ?>
		<?php echo $form->passwordFieldRow($model, 'password', array('size' => 32, 'maxlength' => 32, 'class'=>'span12')); ?>
		<?php echo $form->checkBoxRow($model, 'status');; ?>
	    
        <div class="actions">
        <button class="btn success" type="submit">
            <?=$model->isNewRecord ? 'Добавить' : 'Сохранить'; ?>
        </button>
        <span class="text_button_padding">или</span>
        <?=CHtml::link('назад', array('list','User_page'=>$_GET['User_page'])); ?>
	</div>
<? $this->endWidget(); ?>
