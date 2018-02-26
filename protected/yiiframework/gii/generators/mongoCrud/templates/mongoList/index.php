<?php echo "<?php "; ?>
$this->breadcrumbs=array(
	<?php echo $this->modelClass; ?>::modelTitle(),
);
<?php echo "?>"; ?>
<script type="text/javascript">
    function deleteList(id) {
        if(confirm('Вы действительно хотите удалить эту запись?')){
            $.ajax({
                type:'POST',
                data:{id:id},
                url:'<?php echo "<?=\$this->createUrl('delete')?>"?>?ajax',
                success:function() {
                    $("#data_"+id).remove();
                    _message('Удалено',1);
                }
            });
        }
    }
</script>
<?php echo "<?php"; ?>

$script='
var path=false;
var id=false;
var t=false;
function changeSt(id){
    t=$("#change_"+id);
    path=t.attr("src");
    id=t.attr("id");
    if(path=="/images/sysimgs/on.png"){
        $.post("'.$this->createUrl('ajax').'",{"action":"off","id":id},function(){
            $("#"+id).attr("src","/images/sysimgs/off.png");
            t.parents("div.view").removeClass("list-y").addClass("list-n");
        });
    }else{
        $.post("'.$this->createUrl('ajax').'",{"action":"on","id":id},function(){
            $("#"+id).attr("src","/images/sysimgs/on.png");
            t.parents("div.view").removeClass("list-n").addClass("list-y");
        });
    }
};
';
$cs = Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
$cs->registerScript('bottom',$script, 0);
$cs->registerScript('bottom_st','$(".status-change").hover(function(){$("#_status").html($(this).attr(\'title\'))},function(){$("#_status").html("")});', 4);
$this->renderPartial('_option');
foreach ($models as $model)$this->renderPartial('_view',array('data'=>$model));
$this->widget('application.components.WPages',array('_pages'=>$pages));
?>
<div class="clear">&nbsp;</div>
