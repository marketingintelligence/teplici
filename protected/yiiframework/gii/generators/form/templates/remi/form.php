<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'" . $this->class2id($this->modelClass) . '-' . basename($this->viewName) . "-form',
	'enableAjaxValidation'=>true,
)); ?>\n"; ?>

<div class="pb-5"><span class="t-red">*</span> - поля, обязательные для заполнения</div>
<br />


<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php foreach ($this->getModelAttributes() as $attribute): ?>    
    <?php echo '<table class="form"><tr>
            <td class="text"><?php echo $form->labelEx($model,\'' . $attribute . '\'); ?>:</td>
            <td class="eu">
                    <?php echo $form->textField($model,\'' . $attribute . '\',array(\'style\'=>\'width:450px;\')); ?>
                    <div class="eu-comment"></div>
                    <?php echo $form->error($model,\'' . $attribute . '\'); ?>
            </td>
    </tr></table>
'; ?>

<?php endforeach; ?>
<button type="submit" class="standart">Отправить</button>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
