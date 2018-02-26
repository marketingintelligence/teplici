<?
class WTrash extends CWidget{
	
	public function run(){
		$options = $this->controller->filterOption;
    	if($options['model']!=''){    	
    		$model = CActiveRecord::model($options['model']);	    		
    		if($model->hasAttribute('is_removed')){

    			Yii::app()->clientScript->registerScript('timesafe-trash',"
$('.timesafe-trash a').live('click',function(e){
	var t = $(this);
	var type = t.attr('data-type');
	if(type==='restore') {
		$('#modal-restore .btn-danger').hide();
		$('#modal-restore .btn-success').show();
	}else{
		$('#modal-restore .btn-success').hide();
		$('#modal-restore .btn-danger').show();
	}
    $('#modal-restore').data('id',t.attr('data-id'));
    $('#modal-restore strong').html('\"'+t.attr('data-title')+'\"');		
	e.preventDefault();
});
$('.modal-restore-forever').live('click',function(e){
  var id = $('#modal-restore').data('id');
  $.post('".$this->controller->createUrl('delete')."?ajax=1&id='+id,function(){
    _refreshTrash();  
    $.fn.yiiListView.update('leaf-0');   
  });
});
$('.modal-restore').live('click',function(e){
  var id = $('#modal-restore').data('id');
  $.get('".$this->controller->createUrl('restore')."',{id:id},function(){
    _refreshTrash();     
    $.fn.yiiListView.update($('.content .list-view').attr('id'));
    //$.fn.yiiListView.update('leaf-0');   
  });
});

    			")->registerScript('refreshTrash',"  
function _refreshTrash(){                                                     
	$('.timesafe-trash').load('".$this->controller->createUrl('trash/recycle',array('model'=>$options['model']))."');     
}


",0);
          $widget =true;
				$this->render('wTrash',compact('model','options','widget'));
    		}
		}
	}

}
?>