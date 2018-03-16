<?php
    $form = $this->beginWidget('BootActiveForm', array(
        'id' => 'Explan-form',
        'type'=>'horizontal',
        'enableAjaxValidation' => true,
            'focus' => array($model, 'name_text'),

        'htmlOptions' => array(
            'class' => 'form form-horizontal',
            'enctype'=>'multipart/form-data'
        ),
    ));
    echo CHtml::hiddenField('Explan_page',$_GET['Explan_page']);
?>
<style>
    .span {
      width: 100%;
      height: 30px;
    }
    .span-number{
        width: 60px !important;
    };
</style>
<?php

for ( $i=1; $i<=100; $i++) $number[$i]=$i; ?>
    <div class="form-actions">
        <button class="btn btn-success" type="submit">
            <?=$model->isNewRecord ? 'Добавить' : 'Сохранить'; ?>
        </button>
        <span class="text_button_padding">или</span>        
    	<?=CHtml::link('назад', array('list','Explan_page'=>$_GET['Explan_page'])); ?>    </div>
    	<?php echo $form->textFieldRow($model, 'name_text', array('size' => 60, 'maxlength' => 255, 'class'=>'span')); ?>
        <?php echo $form->dropDownListRow($model, 'serial_number', $number, array('class'=>'span-number')); ?>
        <?php echo $form->singlefileFieldRow($model, 'image',array('class'=>'input-file'));; ?>
        <?php echo $form->singlefileFieldRow($model, 'file',array('class'=>'input-file'));; ?>
        <?php echo $form->singlefileFieldRow($model, 'engfile',array('class'=>'input-file'));; ?>

        <?php echo $form->checkBoxRow($model, 'status_int');; ?>
    <div class="form-actions">
        <button class="btn btn-success" type="submit">
            <?=$model->isNewRecord ? 'Добавить' : 'Сохранить'; ?>
        </button>
        <span class="text_button_padding">или</span>
        <?=CHtml::link('назад', array('list','Explan_page'=>$_GET['Explan_page'])); ?>
	</div>

<script>
    $('#Explan_name_text').change(function() {
        $('#Explan_url_text').val(cyr2lat($('#Explan_name_text').val()));
    });
    function cyr2lat(str) {

        var cyr2latChars = new Array(
            ['а', 'a'], ['б', 'b'], ['в', 'v'], ['г', 'g'],
            ['д', 'd'],  ['е', 'e'], ['ё', 'yo'], ['ж', 'zh'], ['з', 'z'],
            ['и', 'i'], ['й', 'y'], ['к', 'k'], ['л', 'l'],
            ['м', 'm'],  ['н', 'n'], ['о', 'o'], ['п', 'p'],  ['р', 'r'],
            ['с', 's'], ['т', 't'], ['у', 'u'], ['ф', 'f'],
            ['х', 'h'],  ['ц', 'c'], ['ч', 'ch'],['ш', 'sh'], ['щ', 'shch'],
            ['ъ', ''],  ['ы', 'y'], ['ь', ''],  ['э', 'e'], ['ю', 'yu'], ['я', 'ya'],

            ['А', 'a'], ['Б', 'b'],  ['В', 'v'], ['Г', 'g'],
            ['Д', 'd'], ['Е', 'e'], ['Ё', 'yo'],  ['Ж', 'zh'], ['З', 'z'],
            ['И', 'i'], ['Й', 'y'],  ['К', 'k'], ['Л', 'l'],
            ['М', 'm'], ['Н', 'n'], ['О', 'o'],  ['П', 'p'],  ['Р', 'r'],
            ['С', 's'], ['Т', 't'],  ['У', 'u'], ['Ф', 'f'],
            ['Х', 'h'], ['Ц', 'c'], ['Ч', 'ch'], ['Ш', 'sh'], ['Щ', 'shch'],
            ['Ъ', ''],  ['Ы', 'y'],
            ['Ь', ''],
            ['Э', 'e'],
            ['Ю', 'yu'],
            ['Я', 'ya'],

            ['a', 'a'], ['b', 'b'], ['c', 'c'], ['d', 'd'], ['e', 'e'],
            ['f', 'f'], ['g', 'g'], ['h', 'h'], ['i', 'i'], ['j', 'j'],
            ['k', 'k'], ['l', 'l'], ['m', 'm'], ['n', 'n'], ['o', 'o'],
            ['p', 'p'], ['q', 'q'], ['r', 'r'], ['s', 's'], ['t', 't'],
            ['u', 'u'], ['v', 'v'], ['w', 'w'], ['x', 'x'], ['y', 'y'],
            ['z', 'z'],

            ['A', 'A'], ['B', 'B'], ['C', 'C'], ['D', 'D'],['E', 'E'],
            ['F', 'F'],['G', 'G'],['H', 'H'],['I', 'I'],['J', 'J'],['K', 'K'],
            ['L', 'L'], ['M', 'M'], ['N', 'N'], ['O', 'O'],['P', 'P'],
            ['Q', 'Q'],['R', 'R'],['S', 'S'],['T', 'T'],['U', 'U'],['V', 'V'],
            ['W', 'W'], ['X', 'X'], ['Y', 'Y'], ['Z', 'Z'],

            [' ', '-'],['0', '0'],['1', '1'],['2', '2'],['3', '3'],
            ['4', '4'],['5', '5'],['6', '6'],['7', '7'],['8', '8'],['9', '9'],
            ['-', '-']
        );

        var Categorytr = new String();

        for (var i = 0; i < str.length; i++) {

            ch = str.charAt(i);
            var newCh = '';

            for (var j = 0; j < cyr2latChars.length; j++) {
                if (ch == cyr2latChars[j][0]) {
                    newCh = cyr2latChars[j][1];

                }
            }
            // Если найдено совпадение, то добавляется соответствие, если нет - пустая строка
            Categorytr += newCh;

        }
        // Удаляем повторяющие знаки - Именно на них заменяются пробелы.
        // Так же удаляем символы перевода строки, но это наверное уже лишнее
        return Categorytr.replace(/[-]{2,}/gim, '-').replace(/\n/gim, '');
    }
</script>
<? $this->endWidget(); ?>

