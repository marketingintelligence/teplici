<div class="module-title">
    <?='<?='?><?=$this->modelClass?>::modelTitle()?>&nbsp;<a href="<?='<?='?>$this->createUrl('create')?>" class="btn btn-success"><i class="icon-plus"></i> Добавить</a>
</div>

<div id="search-<?=$this->modelClass?>-form">
	<?='<?php'?> $this->renderPartial('_list',compact('model'))?>
</div>

<?='<?php'?> $this->beginWidget('BootModal',array(
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
               			$.fn.yiiListView.update($('#search-<?=$this->modelClass?>-form .list-view').attr('id'));
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
               			$.fn.yiiListView.update($('#search-<?=$this->modelClass?>-form .list-view').attr('id'));
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
<?='<?php'?> $this->endWidget(); ?> 
<script type="text/javascript">
    $.ajaxSetup({
        async:false
    });
    $(function () {

        function loadTree(id) {
            var child = $('#child-' + id);
            if (!child.hasClass('loaded')) {
                child.hide().load('<?='<?='?>$this->createUrl('find')?>?id=' + id, function () {
                    child.addClass('loaded').slideDown();
                    child.find(".toggle-on-check").toggleit();
                });
                $(this).html('&larr;');
            }
            else {
                if (!child.hasClass('hidden')) {
                    child.slideUp().addClass('hidden');
                    $(this).html('&rarr;');
                } else {
                    child.slideDown().removeClass('hidden');
                    $(this).html('&larr;');
                }
            }
        }

        $('.tree-button.success').live('click', function (e) {
            var id = $(this).attr('data-id');
            loadTree(id);
            e.preventDefault();
        });
        $('a.disabled').live('click', function (e) {
            e.preventDefault();
        });

        var ancestors = <?='<?='?>$editModel ? $editModel->ancestors : '[]'?>;
        for (i in ancestors) {
            loadTree(ancestors[i]);
        }
        $('#item-<?='<?='?>$editModel->id?>').addClass('hovered');
    });


</script>   
