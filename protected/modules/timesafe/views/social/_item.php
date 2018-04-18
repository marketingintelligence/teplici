<div class="row">
    <div class="offset">
        <p class="pull-right">
            <a class="btn" href="<?=$this->createUrl('update', array('id' => $data->id))?>"><i class="icon-pencil"></i> Ред.</a>
            <!--<a class="btn btn-danger delete-link-list" href="#modal-delete" data-toggle="modal" data-title="<?/*=CHtml::encode($data->name_text)*/?>" data-id="<?/*=$data->id*/?>"><i class="icon-trash"></i> Уд.</a>-->
        </p>
        <p class="pull-right">
            <?/*=CHtml::checkbox('ContactsCheck[status_int][' . $data->id . ']', $data->status_int, array('class' => 'toggle-on-check'))*/?>
            <!--<span class="label label-info"><i class="icon-eye-open"></i> Видимость</span>-->
        </p>

        <div style="display: inline-block">
            <? $img = json_decode($data->image, true); ?>
            <h3 style = "margin-top:5px;">
                <a target = "_blank" href ="<?=$data->url?>"> <?=$data->name_text?></a>
            </h3>
            <p style = "margin-left:0; font-weight:bold;">Ссылка:<a target="_blank" href="<?=$data->url?>"><?=$data->url?></a> </p>
            <p style = "margin-left:0; font-weight:bold;">Порядковый номер: <?=$data->serial_number?></p>
        </div>
    </div>
</div>