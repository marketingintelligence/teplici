<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'sys-setting-form',
    'enableClientValidation' => true,
    'focus' => array($model, 'parent_Module_id'),
    'htmlOptions' => array(
        'class' => 'form',
        'enctype' => 'multipart/form-data'
    ),
));
echo CHtml::hiddenField('SysSetting_page', $_GET['SysSetting_page']);
?>


<div class="group navform wat-cf">
    <button class="button" type="submit">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/save.png', $model->isNewRecord ? 'Добавить' : 'Сохранить'); ?> <?php echo $model->isNewRecord ? 'Добавить' : 'Сохранить'; ?>
    </button>
    <span class="text_button_padding">или</span>
    <?php echo CHtml::link('назад', array('index', 'SysSetting_page' => $_GET['SysSetting_page']), array('class' => 'text_button_padding link_button')); ?>

</div>

<!--<div class="group">
		<?php if ($model->hasErrors('parent_Module_id')): ?>
			<div class="fieldWithErrors">
		<?php endif; ?>
		<?php echo $form->labelEx($model, 'parent_Module_id', array('class' => 'label')); ?>
		<?php if ($model->hasErrors('parent_Module_id')): ?>
				<span class="error"><?php echo $model->getError('parent_Module_id'); ?></span>
			</div>
		<?php endif; ?>
		<?php echo $form->textField($model, 'parent_Module_id', array('class' => 'text_field')); ?>
    </div>-->

<div class="group">
    <?php if ($model->hasErrors('type')): ?>
			<div class="fieldWithErrors">
		<?php endif; ?>
    <?php echo $form->labelEx($model, 'type', array('class' => 'label')); ?>
    <?php if ($model->hasErrors('type')): ?>
    <span class="error"><?php echo $model->getError('type'); ?></span>
			</div>
		<?php endif; ?>
    <?php
    echo $form->dropDownList($model, 'type', array(
        'text' => 'Значение',
        'html' => 'Текст',
        'option' => 'Опция',
    ), array(
        'class' => 'chzn-select'
    ));
    ?>
    <div class="hint">Значение - у указаного текста будет убрано всё HTML оформление (plain/text).
        Текст - будет сохранено как есть (text/html)
        Опция - будет преобразовано в 0 или 1;
    </div>
</div>

<div class="group">
    <?php if ($model->hasErrors('title')): ?>
			<div class="fieldWithErrors">
		<?php endif; ?>
    <?php echo $form->labelEx($model, 'title', array('class' => 'label')); ?>
    <?php if ($model->hasErrors('title')): ?>
    <span class="error"><?php echo $model->getError('title'); ?></span>
			</div>
		<?php endif; ?>
    <?php echo $form->textField($model, 'title', array('size' => 255, 'maxlength' => 255, 'class' => 'text_field')); ?>

</div>

<div class="group">
    <?php if ($model->hasErrors('name')): ?>
			<div class="fieldWithErrors">
		<?php endif; ?>
    <?php echo $form->labelEx($model, 'name', array('class' => 'label')); ?>
    <?php if ($model->hasErrors('name')): ?>
    <span class="error"><?php echo $model->getError('name'); ?></span>
			</div>
		<?php endif; ?>
    <?php echo $form->textField($model, 'name', array('size' => 255, 'maxlength' => 255, 'class' => 'text_field')); ?>

</div>

<div class="group">
    <?php if ($model->hasErrors('value')): ?>
			<div class="fieldWithErrors">
		<?php endif; ?>
    <?php echo $form->labelEx($model, 'value', array('class' => 'label')); ?>
    <?php if ($model->hasErrors('value')): ?>
    <span class="error"><?php echo $model->getError('value'); ?></span>
			</div>
		<?php endif; ?>
    <?php echo $model->type =='option'?$form->checkBox($model,'value'):$form->textArea($model, 'value', array('rows' => 6, 'cols' => 50, 'class' => 'text_area')); ?>
    <?php if($model->type =='html' ) $this->widget('application.extensions.elrte.elRTE', array('model' => $model, 'attribute' => 'value')); ?>    
</div>
<div class="group">
    <?php if ($model->hasErrors('value_kaz')): ?>
			<div class="fieldWithErrors">
		<?php endif; ?>
    <?php echo $form->labelEx($model, 'value_kaz', array('class' => 'label')); ?>
    <?php if ($model->hasErrors('value_kaz')): ?>
    <span class="error"><?php echo $model->getError('value'); ?></span>
			</div>
		<?php endif; ?>
    <?php echo $model->type =='option'?$form->checkBox($model,'value'):$form->textArea($model, 'value_kaz', array('rows' => 6, 'cols' => 50, 'class' => 'text_area')); ?>
    <?php if($model->type =='html' ) $this->widget('application.extensions.elrte.elRTE', array('model' => $model, 'attribute' => 'value_kaz')); ?>    
</div>

<div class="group">
    <?php if ($model->hasErrors('value_eng')): ?>
			<div class="fieldWithErrors">
		<?php endif; ?>
    <?php echo $form->labelEx($model, 'value_eng', array('class' => 'label')); ?>
    <?php if ($model->hasErrors('value_eng')): ?>
    <span class="error"><?php echo $model->getError('value'); ?></span>
			</div>
		<?php endif; ?>
    <?php echo $model->type =='option'?$form->checkBox($model,'value'):$form->textArea($model, 'value_eng', array('rows' => 6, 'cols' => 50, 'class' => 'text_area')); ?>
    <?php if($model->type =='html' ) $this->widget('application.extensions.elrte.elRTE', array('model' => $model, 'attribute' => 'value_kaz')); ?>    
</div>

<div class="group navform wat-cf">
    <button class="button" type="submit">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/save.png', $model->isNewRecord ? 'Добавить' : 'Сохранить'); ?> <?php echo $model->isNewRecord ? 'Добавить' : 'Сохранить'; ?>
    </button>
    <span class="text_button_padding">или</span>
    <?php echo CHtml::link('назад', array('index', 'SysSetting_page' => $_GET['SysSetting_page']), array('class' => 'text_button_padding link_button')); ?>
</div>
<?php $this->endWidget(); ?>
