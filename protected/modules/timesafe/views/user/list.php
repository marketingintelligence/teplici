<div class="module-title">
    <?=User::modelTitle()?>&nbsp;<!--<a href="<?/*=$this->createUrl('create')*/?>" class="btn success">Добавить</a>-->
</div>

<div id="search-User-form">
	<?php $this->renderPartial('_list',compact('model'))?>
</div>

<?php $this->beginWidget('BootModal',array(
    'id'=>'modal-delete',
    'options'=>array(
        'title'=>'Удаление',
        'backdropClose'=>true, 
        'escapeClose'=>true,
        'open'=>false,
        'closeTime'=>350,
        'openTime'=>500,
        'buttons'=>array(
            array(
                'label'=>'Удалить',
                'class'=>'btn danger',
                'click'=>"js:function() {                   	
               		$.get('".$this->createUrl('remove')."',{id:$('#modal-delete').data('id')},function(){
               			$('#modal-delete').bootModal('close');	
               			$.fn.yiiListView.update($('#search-User-form .list-view').attr('id'));
                        _refreshTrash();
               		});
                }",
            ),
            array(
                'label'=>'Удалить навсегда',
                'class'=>'btn danger',
                'click'=>"js:function() {
                    $.post('".$this->createUrl('delete')."?ajax=1',{id:$('#modal-delete').data('id')},function(){
               			$('#modal-delete').bootModal('close');	
               			$.fn.yiiListView.update($('#search-User-form .list-view').attr('id'));
               		});
                }",
            ),
            array(
                'label'=>'Отмена',
                'class'=>'btn',
                'click'=>"js:function() {
                    $('#modal-delete').bootModal('close');                    
                    return false;
                }",
            ),
        ),      
    ),
)); ?> 
<p>Вы действительно хотите удалить запись?</p>
<strong></strong> 
<?php $this->endWidget(); ?> 