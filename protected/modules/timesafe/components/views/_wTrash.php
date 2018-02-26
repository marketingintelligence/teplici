
        <? $records = $model->getRemoved()->findAll(array('limit'=>5));    
        if(count($records)>0):
         ?>
         <h4><i class="icon-trash"></i> Корзина (<?=$model->trashCount();?>)</h4>
         <br>
        
    <?    
        
    	foreach ($records as $record){
    			
    		echo CHtml::tag('small',array(),$record->title).'<br>'.
    		CHtml::link('<i class="icon-share-alt"></i> Вернуть', '#modal-restore',array('class'=>'btn btn-mini btn-success','data-title'=>CHtml::encode($record->title),'data-id'=>$record->id,'data-type'=>'restore','data-toggle'=>'modal')).'&nbsp;'.
    		CHtml::link('<i class="icon-trash"></i> Уд.','#modal-restore',array('class'=>'btn btn-mini btn-danger','data-title'=>CHtml::encode($record->title),'data-id'=>$record->id,'data-type'=>'delete','data-toggle'=>'modal')).'<hr>';
    	}
    ?>
    <a href="<?=Yii::app()->createUrl('timesafe/trash/index',array('model'=>$options['model']))?>">Все записи <i class="icon-arrow-right"></i></a>
    
    <? else: ?>
    <span class="label">Удалённых записей нет.</span>
    <? endif; ?>