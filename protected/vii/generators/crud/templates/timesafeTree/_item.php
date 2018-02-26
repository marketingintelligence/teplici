<?
$title=$this->guessNameColumn($this->tableSchema->columns);
$status = $data = $content = '' ;
$image = false;
foreach($this->tableSchema->columns as $column): if (!$column->autoIncrement):
    if(stripos($column->name, 'image') !== false){
        $image = $column->name;
    }
    if (($column->type === 'boolean' || $column->dbType=='tinyint(1)' || stripos($column->name, 'status') !== false) && $column->name!='is_removed'){
        $status.= "<p class=\"pull-right\">
            <?=CHtml::checkbox('{$this->modelClass}Check[{$column->name}][' . \$data->id . ']', \$data->{$column->name}, array('class' => 'toggle-on-check'))?>
        </p>\n";
    }else if (stripos($column->name, '_at') !== false || stripos($column->name, 'date') !== false){
        $date .="<span class=\"label\"><?=date('d.m.Y H:i', \$data->{$column->name})?></span><br>\n";
    }else if (stripos($column->name, 'content') !== false){
        $content .= "<?=nl2br(\$data->{$column->name})?>\n";
    }

endif; endforeach;
// $this->modelClass ;
$relations = array();
$tempModel = CActiveRecord::model($this->modelClass);
$labels = $tempModel->attributeLabels();
$modelRelations = $tempModel->relations();

foreach ($modelRelations as $relationName=>$relationArray){
    if('CHasManyRelation'=== $relationArray[0]){
        $relations[$relationName] = $relationArray;
        
    }
}
?><div class="row tree-item" id="item-<?='<?='?>$data->id?>" data-parent="<?='<?='?>$data->parent_id?>">
    

    <?='<?'?> if ($data->childCount > 0): ?>
    <a class="tree-button btn success pull-left fb" data-id="<?='<?='?>$data->id?>" href="#">&rarr;</a>
    <?='<?'?> else: ?>
    <? foreach ($relations as $name => $relation):?>    
    <a class="tree-button btn pull-left<?='<?='?>$data-><?=$name?>Count > 0 ? '' : ' disabled'?> fb" href="<?='<?='?>$this->createUrl('<?=$relation[1]?>/list', array('<?=$relation[1]?>[<?=$relation[2]?>]'=> $data->id))?>" target="_blank">&rarr;</a>
    <? break; endforeach;?>
    <?='<?'?> endif; ?>
    <div class="offset1">
    <? if($image!==false):?>
        <a href="/upload/<?=$this->modelClass?>/full/<?='<?='?>$data-><?=$image?>?>">
            <?='<?='?>$data->getPreview('sm', true)?>
        </a>
        <div class="offset3">
    <? else:?>
        <div>
    <? endif; ?>
            <p class="pull-right">
                <? foreach ($relations as $name => $relation):?>
                <?='<?'?> if ($data-><?=$name?>Count > 0): ?>
                <a class="btn primary" href="<?='<?='?>$this->createUrl('<?=$relation[1]?>/list', array('<?=$relation[1]?>[<?=$relation[2]?>]'=> $data->id))?>"><?=$labels[$name]?$labels[$name]:$relation[1]?></a>
                <?='<?'?> endif; ?>
                <? endforeach;?>

                <a class="btn" href="<?='<?='?>$this->createUrl('update', array('id'=> $data->id))?>"><i class="icon-pencil"></i></a>
                <a class="btn btn-danger delete-link-list" href="<?='<?='?>$this->createUrl(
                    'remove', array(
                                   'id'  => $data->id,
                                   'ajax'=> true))?>" data-title="<?='<?='?>CHtml::encode($data->title)?>" data-id="<?='<?='?>$data->id?>"><i class="icon-trash"></i></a>
            </p>
            <?=$status?>        
            <?=$date?>
            <h4><?='<?='?>$data-><?=$title?>?></h4><br>
            <?=$content?>

            <div class="childs" id="child-<?='<?='?>$data->id?>" style="clear:both">

            </div>
        </div>
    </div>
</div>