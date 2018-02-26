<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div style="clear:both;"></div>
<div class="langBox">
    <table width="100%">
        <tr>
            <td><label class="lang-ru">Русский</label><br></td>
            <td><label class="lang-en">English</label><br></td>
            <td><label class="lang-kz">Казахский</label><br></td>
        </tr>
        <?
        $i=1;
        if(is_array($models)):
        foreach ($models as $model) {

            echo '<tr>
                    <td width="40%">
                        <span class="pad" id="tr_'.$model->id.'">';
            echo $i.': '.$model->message;
            echo '</span></td>

            <td width="30%">';
            $test=$model->messages(array('condition'=>'language=\'en\''));
            echo '<span class="editable pad" id="tr_'.$model->id.'" lang="en">';
            echo $test[0]->translation;
            echo '</span>';
            echo '</td><td width="30%">';
            $test=$model->messages(array('condition'=>'language=\'kz\''));
            echo '<span class="editable pad" id="tr_'.$model->id.'" lang='kz'>';
            echo $test[0]->translation;
            echo '</span>';
            echo '</td>';
            $i++;
            echo '</tr>';
        }
        endif;
        //=$user->posts(array('condition'=>'status=1'));
        echo '</div>';

        ?></table>
</div>
<div style="clear:both;"></div>