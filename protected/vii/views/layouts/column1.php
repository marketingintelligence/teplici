<?php 

$this->beginContent('timesafe.views.layouts.bootstrap'); ?>
<div class="container">
	<div id="content">
		<?php if(!Yii::app()->user->isGuest): ?>
			<p class="pull-right"><?php echo CHtml::link('<i class="icon-signout"></i> Выйти из генерации',array('/vii/default/logout'),array('class'=>'btn btn-mini btn-error')); ?></p>
		<?php endif; ?>
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); 

$cs=Yii::app()->clientScript;
$cs->coreScriptPosition=CClientScript::POS_HEAD;
$cs->scriptMap=array();
$baseUrl=$this->module->assetsUrl;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile($baseUrl.'/js/jquery.tooltip-1.2.6.min.js');
$cs->registerScriptFile($baseUrl.'/js/fancybox/jquery.fancybox-1.3.1.pack.js');
$cs->registerCssFile($baseUrl.'/js/fancybox/jquery.fancybox-1.3.1.css');
$cs->registerCssFile($baseUrl.'/js/main.js');


?>