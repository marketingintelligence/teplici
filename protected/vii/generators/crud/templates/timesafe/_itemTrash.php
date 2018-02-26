<?
$title=$this->guessNameColumn($this->tableSchema->columns);
$status = $data = $content = '' ;
foreach($this->tableSchema->columns as $column): if (!$column->autoIncrement):
    if (stripos($column->name, '_at') !== false || stripos($column->name, 'date') !== false){
        $date .="<span class=\"label\"><?=date('d.m.Y H:i', \$data->{$column->name})?></span><br>\n";
    }else if (stripos($column->name, 'content') !== false){
        $content .= "<?=nl2br(\$data->{$column->name})?>\n";
    }
endif; endforeach;
?><div class="row">
    <a href="/upload/<?=$this->modelClass?>/full/<?='<?='?>$data->image?>">
        <?='<?='?>$data->getPreview('sm', true)?>
    </a>
    <div class="offset3">
        <p class="pull-right">
            <a class="btn success" data-type="restore" href="<?='<?='?>$this->createUrl('<?=strtolower($this->modelClass)?>/restore', array('id' => $data->id))?>"><i class="icon-share-alt"></i> Вернуть</a>
            <a  class="btn danger" data-type="delete"  href="<?='<?='?>$this->createUrl('<?=strtolower($this->modelClass)?>/delete', array('id'  => $data->id,'ajax' => true))?>" data-title="<?='<?='?>CHtml::encode($data->title)?>" data-id="<?='<?='?>$data->id?>"><i class="icon-trash"></i> Уд.</a>
        </p>        
        <?=$date?>
        <strong><?='<?='?>$data-><?=$title?>?></strong><br>
        <?=$content?>
    </div>
</div>