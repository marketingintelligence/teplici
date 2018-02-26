<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>
	
	<div class="clearfix">
		<label for="">&nbsp;</label>
		<div class="input">
			<?php echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
			<?php echo $form->error($model, 'itemname'); ?>
		</div>
	</div>
	
	<div class="actions">
		<button class="btn primary" type="submit"><?=Rights::t('core', 'Assign')?></button>
	</div>

<?php $this->endWidget(); ?>

</div>