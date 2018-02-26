<?php
/**
 * This is the template for generating the index view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
$modelClass=$this->modelClass;
?>
<?php
echo "<?php\n";

$route=$modelClass.'/index';
$route[0]=strtolower($route[0]);
echo "\$this->breadcrumbs=array(
$modelClass::modelTitle(),
);\n";
$related=array();
$_REL=CActiveRecord::model($modelClass)->relations();
if(is_array($_REL)) {
    foreach ($_REL as $key => $value) {
        if($value[0]=='CBelongsToRelation') {
            $related[$key]=$value;
        }
    }
}
?>

$this->menu=array(
array('label'=>'Добавить', 'url'=>array('create'),'linkOptions'=>array('class'=>'m-add')),
array('label'=>'Управление', 'url'=>array('admin'),'linkOptions'=>array('class'=>'m-admin')),
);
?>

<h1><?php echo "<?php echo {$modelClass}::modelTitle(); ?>"; ?></h1>

<?php if(sizeof($related)==0): echo "<?php \$this->renderPartial('admin.components.views.operations');?>"; else:
    echo "<table width=\"100%\">
    <tr>
        <td><?php \$this->renderPartial('admin.components.views.operations');?></td>
        <td class=\"related\" style=\"\">
        <?";
    $_RELT=CActiveRecord::model($modelClass)->relationsTitle();

    foreach($related as $k=>$rel):
        $model=CActiveRecord::model($rel[1]);

        if($model->hasAttribute('parent_id')!=null) {
            echo  "
            function find{$k}(\$arr=array(),\$id=0,\$s=' - ') {
                \$ms={$rel[1]}::model()->findAll(array('condition'=> '`parent_id`='.\$id,'order'=>'title','select'=>array('id','title')));
                foreach (\$ms as \$m) {
                    \$arr[\$m->id]=\$s.'>'.\$m->title;
                    if({$rel[1]}::model()->count(array('condition'=> '`parent_id`='.\$m->id,'order'=>'title','select'=>array('id','title')))>0) {
                        \$arr=find{$k}(\$arr,\$m->id,(\$s.' - '));
                    }
                }
                return \$arr;
            }
            \$arr=find{$k}(array('unset'=>'Все'),0);";
        }else {
            echo ";
            \$arr=array('unset'=>'Все');
            \$ms={$rel[1]}::model()->findAll(array('order'=>'title'));
            foreach (\$ms as \$m) {
                \$arr[\$m->id]=\$s.'- >'.\$m->title;
            }
                    ";
        }
        echo "\necho '<div><a href=\"'.\$this->createUrl('{$rel[1]}/index').'\" class=\"m-up\">{$_RELT[$k]}</a>: '.CHtml::DropDownList('{$v[2]}',\$this->module->_p['{$k}'],\$arr,array('onchange'=>\"document.location.href='\".\$this->createUrl('',array('_p[{$k}]'=>'')).\"/'+this.value\")).'</div>';";
        ?>

    <?
    endforeach;
    echo " ?>
        </td></tr></table>";
endif;?>
<?php

$i=1;
$sort='';
$parent=false;
$not=array('KEYWORDS','DESCRIPTION','METATITLE','KEYWORDS_kz','DESCRIPTION_kz','METATITLE_kz','KEYWORDS_en','DESCRIPTION_en','METATITLE_en');
foreach($this->tableSchema->columns as $column) {
    if(stripos($column->dbType,'text')==false && stripos($column->name,'content')==false && !in_array($column->name,$not) && !$column->isPrimaryKey && !$column->isForeignKey) {
        if($i>1) {
            $sort.=', ';
        }
        $sort.="'".$column->name."'";
        $i++;
    }
    if($column->name=='parent_id') {
        $parent=true;
    }
}
if($parent!==true):
    echo "<?php"; ?> $this->widget('zii.widgets.CListView', array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
'afterAjaxUpdate'=>'function (){adminHighLight()}',
'htmlOptions'=>array('id'=>'listed'),
'sortableAttributes'=>array(<?=$sort?>)
)); ?>
<script type="text/javascript">
    function deleteList(id,imag) {
        var qu='';
        if (imag==null) imag=0;
        if (imag) qu='картинку';
        else qu='запись';
        if(confirm('Вы действительно хотите удалить эту '+qu+'?')){
            $.ajax({
                type:'POST',
                data:{id:id,imageOnly:imag},
                url:'<? echo '<?=$this->createUrl(\'delete\')?>' ?>?ajax',
                success:function() {
                    $.fn.yiiListView.update('listed');
                    _message('Удалено',1);
                }
            });
        }
    }
</script>
<?
else:?>
<script type="text/javascript">
    function deleteList(id,imag) {
        var qu='';
        if (imag==null) imag=false;
        if (imag) qu='картинку';
        else qu='запись';
        if(confirm('Вы действительно хотите удалить эту '+qu+'?')){
            $.ajax({
                type:'POST',
                data:{id:id,imageOnly:imag},
                url:'<? echo '<?=$this->createUrl(\'delete\')?>' ?>?ajax',
                success:function() {
                    if (imag)
                        {
                            li=$("td#p_"+id);
                            li.remove();
                        }else
                            {
                    li=$("li#"+id);
                    ul=li.parent('ul');
                    if(li.children('ul').length>0){
                        ul.append(li.children('ul').children('li'));
                        ul.children('li').removeClass('last');
                    }
                    if(ul.children('li').length==0)
                        ul.remove();
                    else
                        li.remove();
                            }
                    _message('Удалено',1);
                }
            });
        }
    }
</script>
    <?echo "<?php\n\$data=array();
function get{$modelClass}(\$id=0){
\$models={$modelClass}::model()->findAll('parent_id='.\$id);
    foreach (\$models as \$model){
        if({$modelClass}::model()->count('parent_id='.\$model->id)>0){
            \$c=true;
        }else{\$c=false;}
        \$t=array(
            'text'=>Yii::app()->controller->renderPartial('_view',array('data'=>\$model),true),
            'id'=>\$model->id,
            'hasChildren'=>\$c,
            'expanded'=>false,
        );
        if(\$c){
            \$t['children']=get{$modelClass}(\$model->id);
        }
        \$data[]=\$t;
    }
    return \$data;
}
\$data=get{$modelClass}();
\$this->widget('CTreeView',array('data'=>\$data));?>";
endif;
echo" <?
\$script='
var path=false;
var id=false;
var t=false;
function changeSt(id){
    t=$(\"#change_\"+id);
    path=t.attr(\"src\");
    id=t.attr(\"id\");
    if(path==\"/images/sysimgs/on.png\"){
        $.post(\"'.\$this->createUrl('{$modelClass}/ajax').'\",{\"action\":\"off\",\"id\":id},function(){
            $(\"#\"+id).attr(\"src\",\"/images/sysimgs/off.png\");
            t.parents(\"div.view\").removeClass(\"list-y\").addClass(\"list-n\");
        });
    }else{
        $.post(\"'.\$this->createUrl('{$modelClass}/ajax').'\",{\"action\":\"on\",\"id\":id},function(){
            $(\"#\"+id).attr(\"src\",\"/images/sysimgs/on.png\");
            t.parents(\"div.view\").removeClass(\"list-n\").addClass(\"list-y\");
        });
    }
};
';
\$cs = Yii::app()->clientScript;
\$cs->registerCoreScript('jquery');
\$cs->registerScript('bottom',\$script, 0);
\$cs->registerScript('bottom_st','\$(\".status-change\").hover(function(){\$(\"#_status\").html(\$(this).attr(\'title\'))},function(){\$(\"#_status\").html(\"\")});', 4);
        
?>" ?>