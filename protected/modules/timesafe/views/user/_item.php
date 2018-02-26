<div class="row">
    <div class="offset1">
        <p class="pull-right">
            <a class="btn" href="<?=$this->createUrl('update', array('id' => $data->id))?>">Редактировать</a>
            <a class="btn danger delete-link-list" href="<?=$this->createUrl('remove', array('id'  => $data->id,'ajax' => true))?>" data-title="<?=CHtml::encode($data->title)?>" data-id="<?=$data->id?>">Удалить</a>
        </p>
        <p class="pull-right">
            <?=CHtml::checkbox('UserCheck[status][' . $data->id . ']', $data->status, array('class' => 'toggle-on-check'))?>
        </p>
        
        <h4><?=$data->title?> <em><?=$data->email?></em></h4>
        Регистрация: <span class="label"><?=date('d.m.Y H:i', $data->created_at)?></span>
        Был: <span class="label"><?=date('d.m.Y H:i', $data->lastvisit_at)?></span>
    </div>
</div>