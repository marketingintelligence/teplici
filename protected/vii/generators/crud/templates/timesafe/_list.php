<?="<?\n"?>
$dataProvider = $model->search();
$this->widget('BootMediaGrid', array(
    'dataProvider'=>$dataProvider,    
    'itemView'=>'_item',
    'afterAjaxUpdate'=>'js:function(){ $(\'.toggle-on-check\').toggleit(); }',
    'sortableAttributes'=>array(
        '<?=$this->guessNameColumn($this->tableSchema->columns)?>',
        'created_at',
    ),
));
?>