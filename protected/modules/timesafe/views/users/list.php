<div class="module-title">
    <?=Users::modelTitle()?>
</div>

<div id="search-Users-form">
	<?php $this->renderPartial('_list',compact('model'))?>
</div>
<?php $this->beginWidget('BootModal', array('id'     => 'modal-delete',)); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3><i class="icon-trash"></i> Удаление</h3>
</div>
<div class="modal-body">
    <p>Вы действительно хотите удалить запись?</p>
    <strong></strong>
</div>
<div class="modal-footer">
    <?php echo CHtml::link('<i class="icon-trash"></i> Удалить', '#', array('class'=>'btn btn-danger modal-delete-forever', 'data-dismiss'=>'modal')); ?>
    <?php echo CHtml::link('<i class="icon-arrow-left"></i> Отмена', '#', array('class'=>'btn', 'data-dismiss'=>'modal')); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">    
    $(function () {
        $('.modal-delete').click(function(e){
          var id = $('#modal-delete').data('id');
          $.get('<?=$this->createUrl('remove')?>',{id:id},function(){
            $.fn.yiiListView.update($('#search-Users-form .list-view').attr('id'));
            _refreshTrash();
          });
        });
        $('.modal-delete-forever').click(function(e){
          var id = $('#modal-delete').data('id');
          $.post('<?=$this->createUrl('delete')?>?ajax=1&id='+id,function(){
            $.fn.yiiListView.update($('#search-Users-form .list-view').attr('id'));
          });
        });
    });
</script>   
