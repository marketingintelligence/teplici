<?php
/**
 * Created by JetBrains PhpStorm.
 * User: strannik
 * Date: 26.10.11
 * Time: 9:14
 * To change this template use File | Settings | File Templates.
 */

class WFilter extends CWidget {
    public $active = false;
    public function init() {

    }

    public function run() {
        $options = $this->controller->filterOption;
        if ($options['model'] != '') {
            $model = CActiveRecord::model($options['model']);
            $model->unsetAttributes();
            $model->attributes = $this->controller->filter;
            
            foreach ($model->attributes as $a) {                
                if($a!==null){
                    $this->active=true;
                    break;                    
                } 
            }
            Yii::app()->clientScript->registerScript('wFilter',"
$('#".$options['model']."-search-form').submit(function (e) {
var data = $('#".$options['model']."-search-form').serializeArray();
var dataNew = [];
for (i in data) {
    if (data[i].value != '')
        dataNew.push(data[i]);
}
if (dataNew.length == 0) {
    dataNew.push({name:'".$options['model']."[_clear_]', 'value':true});
}else{
    $('#wFilter-cancel').removeClass('out').addClass('in');
}
$.ajax({
    url:'".$this->controller->createUrl($this->controller->action->id)."?ajax=search-form',
    type:'get',
    data:dataNew,
    success:function (m) {
        $('#search-".$options['model']."-form').html(m);
        $('.toggle-on-check').toggleit();
    }
});
e.preventDefault();
});
$('#wFilter-cancel').click(function(e){
   $('#".$options['model']."-search-form input, #".$options['model']."-search-form select').val(''); 
   $('#".$options['model']."-search-form').submit();
   $(this).removeClass('in').addClass('out');
   e.preventDefault(); 
});
            ");
            $this->render('wFilter', compact('model', 'options'));
        }
    }
}

