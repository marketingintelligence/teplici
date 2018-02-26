<?php

	class VSelector extends CWidget{
		public $model=null;
		public $attribute=null;
		public function run(){
			
			if($this->model !==null){
				$models = Category::model()->with('childCount')->findAll(array(
					'condition'=>'status and parent_id=0',
					'select'=>'title_ru,id',
					'order'=>'title_ru ASC'
				));		
				$attr = $this->attribute;
				$mValue = $this->model->$attr;
				$category = Category::model()->findByPk($mValue);	
				$ancestors = array();		
				$ancestors = json_decode($category->ancestors);
				$this->render('vSelector',compact('models','mValue','category','ancestors'));
			}
		}
	}
?>