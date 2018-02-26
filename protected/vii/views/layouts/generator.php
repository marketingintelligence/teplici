<?php 
foreach($this->module->controllerMap as $name=>$config): 		
		$this->menu[]=array(
			'label'=>ucwords('<i class="icon-cog"></i> Создать <strong>"'.ucfirst(CHtml::encode($name)).'"</strong>'),
			'url'=>array('/vii/'.$name)
		);
	endforeach;

$this->beginContent('timesafe.views.layouts.bootstrap'); ?>
		<?php if(!Yii::app()->user->isGuest): ?>
			<p class="pull-right"><?php echo CHtml::link('<i class="icon-signout"></i> Выйти из генерации',array('/vii/default/logout'),array('class'=>'btn btn-mini btn-error')); ?></p>
		<?php endif; ?>
		<?php echo $content; ?>
<?php $this->endContent(); 

$cs=Yii::app()->clientScript;
$cs->coreScriptPosition=CClientScript::POS_HEAD;
$cs->scriptMap=array();
$baseUrl=$this->module->assetsUrl;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile($baseUrl.'/js/jquery.tooltip-1.2.6.min.js');
$cs->registerScriptFile($baseUrl.'/js/fancybox/jquery.fancybox-1.3.1.pack.js');
$cs->registerScriptFile($baseUrl.'/js/main.js');
$cs->registerCssFile($baseUrl.'/js/fancybox/jquery.fancybox-1.3.1.css');
$cs->registerCssFile($baseUrl.'/css/main.css');



?>