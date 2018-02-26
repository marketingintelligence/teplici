

<?php if( $model->scenario==='update' ): ?>

	<h3><?php echo Rights::getAuthItemTypeName($model->type); ?></h3>

<?php endif; ?>
	
<?php $form=$this->beginWidget('CActiveForm'); ?>

	<div class="clearfix">
		<?php echo $form->labelEx($model, 'name'); ?>
		<div class="input">
			<?php echo $form->textField($model, 'name', array('maxlength'=>255, 'class'=>'text-field')); ?>
			<?php echo $form->error($model, 'name'); ?>
			<p class="hint"><?php echo Rights::t('core', 'Do not change the name unless you know what you are doing.'); ?></p>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model, 'description'); ?>
		<div class="input">
			<?php echo $form->textField($model, 'description', array('maxlength'=>255, 'class'=>'text-field')); ?>
			<?php echo $form->error($model, 'description'); ?>
			<p class="hint"><?php echo Rights::t('core', 'A descriptive name for this item.'); ?></p>
		</div>	
	</div>

	<?php if( Rights::module()->enableBizRule===true ): ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model, 'bizRule'); ?>
			<div class="input">
				<?php echo $form->textField($model, 'bizRule', array('maxlength'=>255, 'class'=>'text-field')); ?>
				<?php echo $form->error($model, 'bizRule'); ?>
				<p class="hint"><?php echo Rights::t('core', 'Code that will be executed when performing access checking.'); ?></p>
			</div>	
		</div>

	<?php endif; ?>

	<?php if( Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData ): ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model, 'data'); ?>
			<div class="input">
				<?php echo $form->textField($model, 'data', array('maxlength'=>255, 'class'=>'text-field')); ?>
				<?php echo $form->error($model, 'data'); ?>
				<p class="hint"><?php echo Rights::t('core', 'Additional data available when executing the business rule.'); ?></p>
			</div>
		</div>

	<?php endif; ?>
	<div class="actions">
		<button class="btn primary" type="submit"><?=Rights::t('core', 'Save')?></button>						
        &nbsp;
        <?php echo CHtml::link(Rights::t('core', 'Cancel'), Yii::app()->user->rightsReturnUrl,array('class'=>'btn')); ?>
    </div>

<?php $this->endWidget(); ?>

</div>