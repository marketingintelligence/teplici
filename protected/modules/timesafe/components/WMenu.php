<?php

class WMenu extends BootNav {
    public function init() {
        Yii::app()->clientScript
                  ->registerScriptFile('/js/admin/bootstrap-dropdown.js');
        //                ->registerScript('timesafeMenu', "
        //    		$('.topbar').dropdown();
        //    		if(!$.cookie('siteSize')){
        //    			$('#site-size').load('/timesafe/default/siteSize',function(){
        //    				$.cookie('siteSize',$('#site-size').html(),{expires:1});
        //    			});
        //    		}else{
        //    			$('#site-size').html($.cookie('siteSize'));
        //    		}");
    }


    public function run() {

        $models = SysModule::model()->findAll('status and parent_id=0');
        $id = ucfirst($this->controller->id);
        $this->render('wMenu', compact('models', 'id'));
    }
}