
<div class="view<? echo '<?=$'?>data['status']?' list-y':' list-n'?>">
    <table class="list">
        <tr>
            <?php echo '<? if($'?>data['image']){
                echo '<td class="list-foto"><div class="picture">' . CHtml::link(CHtml::image('/img/show/id/' . $data['image']), '/img/show/type/full/id/' . $data['image'].'.png', array('target' => '_blank','rel'=>'pictures')) . '</div></td>';

            }         <?php echo "?>\n"; ?>
            <td><div class="text-14"><a href="<? echo '<?=$'?>this->createUrl('view',array('id'=>$data['_id']))?>"><? echo '<?=$'?>data['title']?></a></div>
                <div class="lh-18"><? echo '<?=$'?>data['url']?></div>
            </td>

            <td class="options">
                <div class="opt">
                    <?php echo '<?php if ($data[\'status\']){ echo(\''?><img class="status-change" id="change_status_'.$data['_id'].'" src="/images/sysimgs/on.png" ondblclick="changeSt(\'status_'.$data['_id'].'\')"/>');}else{ echo('<img class="status-change" id="change_status_'.$data['_id'].'" src="/images/sysimgs/off.png" ondblclick="changeSt(\'status_'.$data['_id'].'\')"/>');}?>
                        
                    <a href="<? echo '<?=$'?>this->createUrl('create',array('id'=>$data['_id']))?>" title="Добавить" class="add"><img alt="Добавить" src="/images/sysimgs/16/add.png"/></a>
                    <a href="<? echo '<?=$'?>this->createUrl('update',array('id'=>$data['_id']))?>" title="Изменить" class="update"><img alt="Изменить" src="/images/sysimgs/16/pencil.png"/></a>
                    <a href="javascript:deleteList('<? echo '<?=$'?>data['_id']?>')" title="Удалить" class="delete"><img alt="Удалить" src="/images/sysimgs/16/delete.png"/></a>
                </div>
            </td>

        </tr>
    </table>
</div>
