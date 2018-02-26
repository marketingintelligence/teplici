<div class="well">
    <style type="text/css">
    .filterform input, .filterform select{
        width:100%!important;
    }
    </style>
    <h4><i class="icon-search"></i> Поиск</h4>
    <?php $form = $this->beginWidget(
    'CActiveForm', array(
                        'id'          => $options['model'] . '-search-form',
                        'action'      => array($this->controller->action->id),
                        'method'      => 'get',
                        'htmlOptions' => array(
                            'class' => 'form filterform',
                        ),
                   ));?>
    <? foreach ($options['fields'] as $fieldName=>$option):    
    $fieldType  = $option['type'];

    ?>
    <div class="clearfix">
        <span class="label"><?=$model->getAttributeLabel($fieldName);?></span><br>
        <?php
        switch ($fieldType) {
            case 'checkbox':
                echo  $form->dropDownList(
                    $model, $fieldName,
                    array(
                         '' => 'Все',
                         '1'=> 'Активные',
                         '0'=> 'Неактивные'), array('class'=> 'span2'));
                break;
            case 'select':
                echo  $form->dropDownList(
                    $model, $fieldName,
                    (array)$option['values'], array('class'=> 'span2'));
                break;
            case 'date':
                echo  $form->dropDownList(
                    $model, $fieldName,
                    array(
                         ''                                                        => 'Все',
                         '>' . mktime(0, 0, 0, date('n'), date('j'), date('Y'))    => 'Сегодня',
                         '>' . mktime(0, 0, 0, date('n'), date('j') - 3, date('Y'))=> 'За 3 дня',
                         '>' . mktime(0, 0, 0, date('n'), date('j') - 7, date('Y'))=> 'За неделю',
                         '>' . mktime(0, 0, 0, date('n') - 1, date('j'), date('Y'))=> 'За месяц',

                    ), array('class'=> 'span2'));
                break;
            case 'parent':
                echo  $form->hiddenField($model, $fieldName);
                $htmlOptions = array();
                CHtml::resolveNameID($model, $fieldName, $htmlOptions);
                preg_match("/^parent_(\w+)_id$/", $fieldName, $a);
                $modelName  = ucfirst($a[1]);
                $params     = array('model'=> $modelName);   
                if ($option['field']) $params['title'] = $option['field'];
                if ($option['additional']) $params['add'] = $option['additional'];
                $pModel = 'parent' . $modelName;


                $this->widget(
                    'zii.widgets.jui.CJuiAutoComplete',
                    array(
                         'name'       => $modelName . '-field',
                         'value'      => $model->$pModel->title,
                         'source'     => $this->controller->createUrl('json/index', $params),
                         'themeUrl'   => '/css/bootstrap',
                         'theme'      => 'timesafe',
                         'options'    => array(
                             'minLength'=> '3',
                             'select'   => 'js:function(e,ui){
                                $("#' . $htmlOptions['id'] . '").val(ui.item.id)
                            }'
                         ),
                         'htmlOptions'=> array(
                             'style'=> 'height:20px;',
                             'class'=> 'span2'
                         ),
                    ));

                break;
            default:
                echo  $form->textField($model, $fieldName, array('class'=> 'span2'));
                break;
        }
        ?>
    </div>
    <? endforeach; ?>
    <button class="btn small btn-success btn-mini" type="submit"><i class="icon-search"></i> Найти</button>
    <button class="btn small btn-mini <?=$this->active?'fade in':'fade out'?>" id="wFilter-cancel" type="button"><i class="icon-arrow-left"></i> Отмена</button>
    <?php $this->endWidget(); ?>
</div>
