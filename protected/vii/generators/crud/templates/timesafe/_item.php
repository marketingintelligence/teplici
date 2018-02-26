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
            <span class=\"label label-info\"><i class=\"icon-eye-open\"></i> Видимость</span>
        </p>\n";
    }else if (stripos($column->name, '_at') !== false || stripos($column->name, 'date') !== false){
        $date .="<span class=\"label\"><?=date('d.m.Y H:i', \$data->{$column->name})?></span><br>\n";
    }else if (stripos($column->name, 'content') !== false){
        $content .= "<?=nl2br(\$data->{$column->name})?>\n";
    }

endif; endforeach;
?><div class="row">
    <? if($image!==false):?>
    <div class="span2">
    <a href="/upload/<?=$this->modelClass?>/full/<?='<?='?>$data-><?=$image?>?>">
        <?='<?='?>$data->getPreview('<?=$image?>', 'sm', true)?>
    </a>
    </div>
    <div class="offset2">
<? else:?>
    <div>
<? endif; ?>
        <p class="pull-right">
            <a class="btn" href="<?='<?='?>$this->createUrl('update', array('id' => $data->id))?>"><i class="icon-pencil"></i> Ред.</a>
            <a class="btn btn-danger delete-link-list" href="#modal-delete" data-toggle="modal" data-title="<?='<?='?>CHtml::encode($data->title)?>" data-id="<?='<?='?>$data->id?>"><i class="icon-trash"></i> Уд.</a>
        </p>
        <?=$status?>        
        <?=$date?>
        <strong><?='<?='?>$data-><?=$title?>?></strong><br>
        <?=$content?>
    </div>
</div>