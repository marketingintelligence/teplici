<div class="control-group template clearfix">
	<?php echo $this->labelEx($model,'template',array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $this->dropDownList($model,'template',$templates,array('class'=>'span12')); ?>
		<div class="tooltip">
			Шаблон для генерации кода. 
		</div>
		<?php echo $this->error($model,'template'); ?>
	</div>
</div>

<div class="form-actions">
	<button class="btn" type="submit" name="preview"><i class="icon-search"></i> Предпросмотр</button>	

	<?php if($model->status===CCodeModel::STATUS_PREVIEW && !$model->hasErrors()): ?>
		<button class="btn btn-success" type="submit" name="generate"><i class="icon-flag"></i> Поехали!</button>			
	<?php endif; ?>
</div>

<?php if(!$model->hasErrors()): ?>
	<div class="feedback">
	<?php if($model->status===CCodeModel::STATUS_SUCCESS): ?>
		<div class="alert block-message alert-success">
			<?php echo $model->successMessage(); ?>
		</div>
	<?php elseif($model->status===CCodeModel::STATUS_ERROR): ?>
		<div class="alert block-message alert-error">
			<?php echo $model->errorMessage(); ?>
		</div>
	<?php endif; ?>

	<?php if(isset($_POST['generate'])): ?>
		
		<pre><?php echo $model->renderResults(); ?></pre>
		
	<?php elseif(isset($_POST['preview'])): ?>
		<?php echo CHtml::hiddenField("answers"); ?>
		<br>
		<table class="preview table table-bordered">
			<tr>
				<th class="file">Code File</th>
				<th class="confirm">
					
					<?php
						$count=0;
						foreach($model->files as $file)
						{
							if($file->operation!==CCodeFile::OP_SKIP)
								$count++;
						}
						if($count>1)
							echo '<input type="checkbox" name="checkAll" id="check-all" />';
					?>
					<label for="check-all">Все</label>
				</th>
			</tr>
			<?php foreach($model->files as $i=>$file): ?>
			<tr class="<?php echo $file->operation; ?>">
				<td class="file">
					<?php echo CHtml::link(CHtml::encode($file->relativePath), array('code','id'=>$i), array('class'=>'view-code','rel'=>$file->path)); ?>
					<?php if($file->operation===CCodeFile::OP_OVERWRITE): ?>
						(<?php echo CHtml::link('разница', array('diff','id'=>$i), array('class'=>'view-code','rel'=>$file->path)); ?>)
					<?php endif; ?>
				</td>
				<td class="confirm">
					<?php
					if($file->operation===CCodeFile::OP_SKIP)
						echo 'без изменений';
					else
					{
						$key=md5($file->path);
						
							echo CHtml::checkBox("answers[$key]", $model->confirmed($file)).' ';
							echo CHtml::label(CCodeFile::$OP_VALUE[$file->operation], "answers_{$key}");
					}
					?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
<?php endif; ?>
