<div class="row">
    <a href="/upload/User/full/<?=$data->image?>">
        <?=$data->getPreview('sm', true)?>
    </a>
    <div class="offset3">
        <p class="pull-right">
            <a class="btn success" data-type="restore" href="<?=$this->createUrl('user/restore', array('id' => $data->id))?>">Восстановить</a>
            <a  class="btn danger" data-type="delete"  href="<?=$this->createUrl('user/delete', array('id'  => $data->id,'ajax' => true))?>" data-title="<?=CHtml::encode($data->title)?>" data-id="<?=$data->id?>">Удалить</a>
        </p>        
        <span class="label"><?=date('d.m.Y H:i', $data->created_at)?></span><br>
<span class="label"><?=date('d.m.Y H:i', $data->lastvisit_at)?></span><br>
        <strong><?=$data->id?></strong><br>
            </div>
</div>