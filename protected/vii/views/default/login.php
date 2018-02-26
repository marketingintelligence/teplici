<div class="form login">
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<h3>Генераторы Vii</h3>
	<div class="clearfix">
		<label for="">Пароль</label>
		<div class="input">
			<?php echo $form->passwordField($model,'password',array('style'=>'float:left;')); ?>
			<?php echo $form->error($model,'password',array('style'=>'float:left; color:#B94A48;padding:7px 0 0 10px')); ?>
		</div>
	</div>
	<div class="actions">
		<button class="btn success" type="submit">Войти</button>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
