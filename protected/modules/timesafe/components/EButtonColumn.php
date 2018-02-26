<?php
Yii::import('zii.widgets.grid.CButtonColumn');

class EButtonColumn extends CButtonColumn
{
    public $template='{update} {delete}';
	public function init()
	{
        $this->updateButtonUrl='Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey)).\'?\'.get_class($data).\'_page=\'.$_GET[get_class($data).\'_page\']';
		$url = Yii::app()->request->baseUrl . '/images/';
		$this->viewButtonImageUrl = $url . 'view.png';
		$this->updateButtonImageUrl = $url . 'update.png';
		$this->deleteButtonImageUrl = $url . 'delete.png';
		parent::init();
	}
}
