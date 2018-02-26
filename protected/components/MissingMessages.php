<?php
class MissingMessages extends CApplicationComponent
{
	public function load($event)
	{
		if(strstr($event->category,'YiiDebug') || strstr($event->category,'yii-debug') ) return false;
		$source = MessageSource::model()->find('message=:message AND category=:category', array(':message'=>$event->message, ':category'=>$event->category));
		
		if( !$source )
		{
			$source = new MessageSource;
			
			$source->category = $event->category;
			$source->message = $event->message;
			$source->save();		
		}
		
		if( $event->language != Yii::app()->sourceLanguage )
		{
			$translation = Message::model()->find('language=:language AND translation=:translation', array(':language'=>$event->language, ':translation'=>$event->message));	
			
			if( !$translation )
			{				
				// Add it
				$model = Message::model()->find('language=:language AND id=:id', array(':language'=>$event->language, ':id'=>$source->id));
				if(!$model){
					$model = new Message;					
					$model->language = $event->language;
					$model->id = $source->id;
				}
				
				$model->translation = $event->message;
				$model->save();
			}
		}
		
	}
}