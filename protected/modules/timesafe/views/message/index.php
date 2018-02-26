<?php
$this->breadcrumbs=array(
News::modelTitle(),
);

$this->menu=array(
array('label'=>'Добавить', 'url'=>array('create'),'linkOptions'=>array('class'=>'m-add')),
array('label'=>'Управление', 'url'=>array('admin'),'linkOptions'=>array('class'=>'m-admin')),
);
?>
<div class="inner">
<h1>Системные фразы</h1>
<br/>
<br/>
<br/>
<style>
    div.langBox{
    }
    div.langBox span{        
        display:block;
        color:#333333;
        font-size:14px;
        cursor:pointer;
    }
    div.langBox span.pad{
        padding:7px 0 1px 7px;
    }
    div.langBox label{
        padding:3px 5px 2px 30px;
        font-size:12px;
        font-weight:bold;
    }
    div.langBox input   {
        padding:3px 0 3px 5px;
        height:23px;
        background:#FFFFFF url(/images/fieldbg.gif) repeat-x scroll center top;
        border-color:#7C7C7C #C3C3C3 #DDDDDD;
        border-style:solid;
        border-width:1px;
        min-width:100%;
        width:100%;
        color:#333333;
        font-size:14px;
    }
    tr.odd{

    }
</style>
<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/admin/jquery.editable.js');
$sc="$('span.editable').editable({
onEdit:function(){ $(this).removeClass('pad');},
onSubmit:function(content){
    var th=$(this);
    th.addClass('pad');
    if(content.current!=content.previous){
        th.addClass('mloading');
        var id=th.attr('id');
        var lang=th.attr('lang');
        $.ajax({
            url:'".$this->createUrl('message/save')."',
            data:{action:'save',id:id,lang:lang,value:content.current},
            success:function(m){ th.removeClass('mloading'); }
        })
    }
}}) ";

$cs=Yii::app()->clientScript;
$cs->registerScript('edit',$sc);
   // ON TAB 1: THIS IS STATIC CONTENT THAT IS TO BE DISPLAYED
   // ON TAB 2: DISPLAY THE USER LIST WHICH IS THE SAME AS THE OUTPUT OF
   // index.php?r=user/list

   // GET THE DATA FOR USE BY THE TAB PAGE VIEW WHEN GENERATING THE OUTPUT
   //$userList=User::model()->findAll(); // ??? should this be moved into the site controller???
//   $connection=Yii::app()->db;
//$command=$connection->createCommand('SELECT DISTINCT(`category`) FROM `sys_SourceMessage`');
//$command->bindParam($name1,$value1);
//$command->bindParam($name2,$value2);
//$c=$command->query();
//foreach ($c as $v){
//    echo '<pre>'.print_r($v,1).'</pre>';
//}
$criteria = new CDbCriteria;
$criteria->select=array('name','title');
$cats=MessageCategory::model()->findAll($criteria);
foreach ($cats as $model) {
    $m=MessageSource::model()->findAllByAttributes(array('category'=>$model->name));
    if($m===null) $m=array();
    $content=$this->renderPartial('words',array('models'=>$m),true);
    $Tabs[$model->name]=array('title'=>$model->title,'content'=>$content);
}
$this->widget('CTabView', array('tabs'=>$Tabs));

?>
</div>