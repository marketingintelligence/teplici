<?
class JsonController extends RController{
	public function actionIndex($term,$model,$title='title_ru',$add=''){
		if(!Yii::app()->request->isAjaxRequest) throw new CHttpException(401,'401');		
		if($model && $term){
			$criteria = new CDbCriteria;
			$criteria->limit=15;

			$criteria->compare($title,$term,true);
			if($add!='')
				$criteria->compare($add,$term,true,'OR');			
				$models = CActiveRecord::model($model)->findAll($criteria);
			$data=array();
			foreach ($models as $model){
				$data[]=array(
					'id'=>$model->id,
					'title'=>$model->title,
					'label'=>$model->title,
				);
			}
			echo json_encode($data);

		}
	}
	public function actionList($model,$title='title_ru'){
		if(!Yii::app()->request->isAjaxRequest) throw new CHttpException(401,'401');		
		if($model){
			$criteria = new CDbCriteria;
			// $criteria->limit=50;
			$criteria->order=$title;


			$models = CActiveRecord::model($model)->findAll($criteria);
			$data=array();
			foreach ($models as $model){
				$data[$model->id]=array(
					'id'=>$model->id,
					'title'=>$model->$title,					
				);
			}
			echo json_encode(array('data'=>$data,'title'=>$model->modelTitle()));

		}
	}
}