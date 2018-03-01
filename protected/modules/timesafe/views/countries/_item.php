<div class="row">
    <div class="offset">
        <p class="pull-right">
            <a class="btn" href="<?=$this->createUrl('update', array('id' => $data->id))?>"><i class="icon-pencil"></i> Ред.</a>
            <a class="btn btn-danger delete-link-list" href="#modal-delete" data-toggle="modal" data-title="<?=CHtml::encode($data->name_text)?>" data-id="<?=$data->id?>"><i class="icon-trash"></i> Уд.</a>
        </p>
        <p class="pull-right">
            <?=CHtml::checkbox('CountriesCheck[status_int][' . $data->id . ']', $data->status_int, array('class' => 'toggle-on-check'))?>
            <span class="label label-info"><i class="icon-eye-open"></i> Видимость</span>
        </p>
        <div style = "display:inline-block; margin-right:10px;">
            <? $img = json_decode($data->image, true); ?>
            <img width = "30px" height="20px" src = "/upload/Countries/full/<?=$img[0]?>">
        </div>
        <div >
            <? $img = json_decode($data->image, true); ?>
            <h3 style = "margin-top:5px;">
                <a target = "_blank""><?=$data->name_text?></a>
            </h3>
                <a target = "_blank""><?=$data->engname_text?></a>
        </div>
    </div>
</div>