<?="<?\n"?>
$dataProvider = $model->search();
$this->widget('BootMediaGrid', array(
	'id'                 => 'leaf-' . $model->parent_id,
    'dataProvider'       =>$dataProvider,        
    'itemView'           =>'_item',
	'template'          => $parent ? "{items}" : "{summary}\n{sorter}\n{items}\n{pager}",
    'afterAjaxUpdate'    =>'js:function(){ $(\'.toggle-on-check\').toggleit(); }',
    'sortableAttributes' =>array(
        '<?=$this->guessNameColumn($this->tableSchema->columns)?>',
        'created_at',
    ),
));
?>