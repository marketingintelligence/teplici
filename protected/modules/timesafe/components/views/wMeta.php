
	<fieldset title="МЕТА-информация">
		<legend>МЕТА-информация</legend>
	    <div id="metainfo" <?=$_POST['_meta']?'style="display:block"':''?>>	    
		    <div class="control-group ">
		        <label class="control-label" for="_meta_title">Заголовок RU</label>
		        <div class="controls">
		        	<?=CHtml::TextField('_meta[title]',$meta->title,array('class'=>'text_field'))?>        
		    	</div>
			</div>
			 <div class="control-group ">
				<label class="control-label" for="_meta_title">Заголовок KZ</label>
		        <div class="controls">
		        	<?=CHtml::TextField('_meta[title_kaz]',$meta->title_kaz,array('class'=>'text_field'))?>        
		    	</div>
		    </div>	
		    <div class="control-group ">
		        <label class="control-label" for="_meta_title">Ключевые слова RU</label>
		        <div class="controls">
		        	<?=CHtml::TextField('_meta[keywords]',$meta->keywords,array('class'=>'text_field'))?>
	        	</div>
			</div>
			<div class="control-group ">
				<label class="control-label" for="_meta_title">Ключевые слова KZ</label>
		        <div class="controls">
		        	<?=CHtml::TextField('_meta[keywords_kaz]',$meta->keywords_kaz,array('class'=>'text_field'))?>
	        	</div>
		    </div>	
		    <div class="control-group ">
		        <label class="control-label" for="_meta_title">Описание RU</label>
		        <div class="controls">
		        	<?=CHtml::TextField('_meta[description]',$meta->description,array('class'=>'text_field'))?>
		    	</div>
			</div>
			<div class="control-group ">
				<label class="control-label" for="_meta_title">Описание KZ</label>
		        <div class="controls">
		        	<?=CHtml::TextField('_meta[description_kaz]',$meta->description_kaz,array('class'=>'text_field'))?>
		    	</div>
		    </div>	
	    </div>
	</fieldset>

       