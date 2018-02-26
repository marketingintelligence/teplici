<div class="well">            
    <div class="timesafe-trash">

        <?=$widget?$this->render('timesafe.components.views._wTrash',compact('model','options')):$this->renderPartial('timesafe.components.views._wTrash',compact('model','options'))?>
        
    </div>
</div>
    <?php $this->beginWidget('BootModal',array('id'=>'modal-restore')); ?> 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>Корзина</h3>
</div>
<div class="modal-body">
    <p>Вы хотите восстановить или удалить запись?</p>
    <strong></strong>
</div>
<div class="modal-footer">
    <?php echo CHtml::link('<i class="icon-share-alt"></i> Восстановить', '#',array('class'=>'btn btn-success modal-restore', 'data-dismiss'=>'modal')); ?>
    <?php echo CHtml::link('<i class="icon-trash"></i> Удалить навсегда', '#', array('class'=>'btn btn-danger modal-restore-forever', 'data-dismiss'=>'modal')); ?>
    <?php echo CHtml::link('<i class="icon-arrow-left"></i> Отмена', '#', array('class'=>'btn', 'data-dismiss'=>'modal')); ?>
</div>
    <?php $this->endWidget(); ?> 
<script type="text/javascript" charset="utf-8">


</script>