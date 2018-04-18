<div class="row">
    <div class="offset">
        <p class="pull-right">
            <a class="btn" href="<?=$this->createUrl('update', array('id' => $data->id))?>"><i class="icon-pencil"></i> Ред.</a>
            <!--<a class="btn btn-danger delete-link-list" href="#modal-delete" data-toggle="modal" data-title="<?/*=CHtml::encode($data->name_text)*/?>" data-id="<?/*=$data->id*/?>"><i class="icon-trash"></i> Уд.</a>-->
        </p>


        <div style="display: inline-block">

            <h3 style = "margin-top:5px;">
                <a target = "_blank"><?=$data->name_text?></a>
            </h3>
            <a target="_blank"> <p style = "margin-left:0; font-weight:bold;"><?=$data->engname_text?></p></a>
        </div>
    </div>
</div>