<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object


?>
<div class="view">

<?php
echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";
echo "\t<?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}), array('view', 'id'=>\$data->{$this->tableSchema->primaryKey})); ?>\n\t<br />\n\n";
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if($column->isPrimaryKey)
		continue;
	if(++$count==7)
		echo "\t<?php /*\n";
	echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";
	echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
}
if($count>=7)
	echo "\t
        </div>
*/
?><?php
/**
 * This is the template for generating the partial view for rendering a single model.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 *
 <div class="actions">
        <?php echo '<a href="<?=$this->createUrl(\'view\',array(\'id\'=>$data->'.$ID.'))?>" title="Просмотр" class="view"><img alt="Просмотр" src="/images/sysimgs/16/gview.png"></a>'."\n";?>
        <?php echo '<a href="<?=$this->createUrl(\'update\',array(\'id\'=>$data->'.$ID.'))?>" title="Изменить" class="update"><img alt="Изменить" src="/images/sysimgs/16/gupdate.png"></a>'."\n";?>
        <?php echo '<a href="javascript:deleteList(<?=$data->'.$ID.'?>)" title="Удалить" class="delete"><img alt="Удалить" src="/images/sysimgs/16/gdelete.png"></a>'."\n";?>
    </div>
 */
?><?php
/*echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$ID}')); ?>:</b>\n";
echo "\t<?php echo CHtml::link(CHtml::encode(\$data->{$ID}), array('view', 'id'=>\$data->{$ID})); ?>\n\t<br />\n\n";*/
$count=0;
$title=$this->guessNameColumn($this->tableSchema->columns);
$image=false;
$date=false;
$text=false;
$sts=false;
$status=false;
$relation=false;
$ID=$this->tableSchema->primaryKey;
$_REL=CActiveRecord::model($this->modelClass)->relations();
if(is_array($_REL)){
    foreach ($_REL as $key => $value) {
         if($value[0]=='CHasManyRelation') {
            $relation=true;
         }
    }

}
foreach($this->tableSchema->columns as $column)
{

    if($column->type=='boolean' || stripos($column->dbType,'tinyint(1)')!==false || stripos($column->name,'status')!==false){
        $sts.="\t\t<td class=\"options\"><?php if (\$data->{$column->name}){ echo('<img title=\"'.\$data->getAttributeLabel('{$column->name}').'\" class=\"status-change\" id=\"change_{$column->name}_'.\$data->{$ID}.'\" src=\"/images/sysimgs/on.png\" ondblclick=\"changeSt(\'{$column->name}_'.\$data->{$ID}.'\')\"/>');}else{ echo('<img title=\"'.\$data->getAttributeLabel('{$column->name}').'\" class=\"status-change\" id=\"change_{$column->name}_'.\$data->{$ID}.'\" src=\"/images/sysimgs/off.png\" ondblclick=\"changeSt(\'{$column->name}_'.\$data->{$ID}.'\')\"/>');}?></td>\n";
        if($column->name=='status')
                $status=true;
    }
    if((stripos($column->name,'_at')!==false || stripos($column->name,'date')!==false) && $date==false){
        $date=$column->name;
    }
    if(stripos($column->name,'image')!==false && $image==false){
        $image=$column->name;
    }
    if(stripos($column->name,'content')!==false || stripos($column->name,'url')!==false){
        $content=$column->name;
    }

}
#echo "\t*/ >\n";

 echo '
<div class="view'.($status?'<?=$data->status?\' list-y\':\' list-n\'?>':'').'">
    <table class="list">
        <tr>';
        if($image!=false){
            echo '
            <? if(is_file(\'upload/'.$this->modelClass.'/sm/\'.$data->'.$image.')):?>
            <td class="list-foto" id="p_<?=$data->id?>">
            <div style="position: absolute;"><a title="Удалить картинку" href="javascript:deleteList(<?=$data->id?>,1)"><img alt="Удалить картинку" src="/images/sysimgs/delete.png"/></a></div>
            <div class="picture"><a href="/upload/'.$this->modelClass.'/<?=$data->image?>" title="<?=$data->title?>" rel="pictures"><img alt="<?=$data->'.$title.'?>" src="/upload/'.$this->modelClass.'/sm/<?=$data->'.$image.'?>"></a></div></td>
            <? endif; ?>            ';}
                echo '
            <td>';
                if($date!=false){echo '
                <div class="list-date"><?=date(\'d-m-Y\',$data->'.$date.')?></div>
                ';}
                echo '<div class="text-14"><a href="<?=$this->createUrl(\'view\',array(\'id\'=>$data->'.$ID.'))?>"><?=$data->'.$title.'?></a></div>
                <div class="lh-18">'.($content!=false?'<?=$data->'.$content.'?>':'').'</div>
            </td>
'.($sts!=false?$sts:'').'
            <td class="options">
                <a href="<?=$this->createUrl(\'view\',array(\'id\'=>$data->id))?>" title="Просмотр" class="view"><img alt="Просмотр" src="/images/sysimgs/show.png"/></a>
                <a href="<?=$this->createUrl(\'update\',array(\'id\'=>$data->id))?>" title="Изменить" class="update"><img alt="Изменить" src="/images/sysimgs/edit.png"/></a>
                <a href="javascript:deleteList(<?=$data->id?>)" title="Удалить" class="delete"><img alt="Удалить" src="/images/sysimgs/delete.png"/></a>
            </td>
            '.($relation!=false?"<td class=\"options\"><?=\$this->module->showInc('{$this->modelClass}',\$data)?></td>":'').'
        </tr>
    </table>
</div>
    ';

?>
