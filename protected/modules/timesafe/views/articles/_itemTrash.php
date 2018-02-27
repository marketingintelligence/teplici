<div class="row">
    <a href="/upload/Articles/full/<?=$data->image?>">
        <?=$data->getPreview('sm', true)?>
    </a>
    <div class="offset3">
        <p class="pull-right">
            <a class="btn success" data-type="restore" href="<?=$this->createUrl('Articles/restore', array('id' => $data->id))?>"><i class="icon-share-alt"></i> Вернуть</a>
            <a  class="btn danger" data-type="delete"  href="<?=$this->createUrl('Articles/delete', array('id'  => $data->id,'ajax' => true))?>" data-title="<?=CHtml::encode($data->name_text)?>" data-id="<?=$data->id?>"><i class="icon-trash"></i> Уд.</a>
        </p>
        <span class="label"><?=date('d.m.Y H:i', $data->created_at)?></span><br>
        <strong><?=$data->name_text?></strong><br>
            </div>
</div>