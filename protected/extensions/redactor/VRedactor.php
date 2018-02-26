<?php
class VRedactor extends CInputWidget {


    public $focus = false; 
    public $resize = true; 
    public $toolbar = 'main'; 
    public $imageUpload = ''; 
    public $handler = false; 
    public $autoformat = true; 
    public $autoclear = true; 
    public $removeClasses = true; 
    public $removeStyles = false; 
    public $imageGetJson = false; 
    public $fileUpload = ''; 
    public $fileDownload = ''; 
    public $fileDelete = ''; 


    public function run() {
        parent::run();
        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir . DIRECTORY_SEPARATOR . 'public');
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($assets . '/css/redactor.css');        
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets . '/redactor.min.js');
        $this->imageUpload=CHtml::normalizeUrl(array('/timesafe/redactor/upload'));
        $this->handler=CHtml::normalizeUrl(array('/timesafe/redactor/typo'));
        $this->fileUpload=CHtml::normalizeUrl(array('/timesafe/redactor/upload','type'=>file));
        $this->fileDownload=CHtml::normalizeUrl(array('/timesafe/redactor/download'));
        $this->fileDelete=CHtml::normalizeUrl(array('/timesafe/redactor/delete'));
        $this->imageGetJson=CHtml::normalizeUrl(array('/timesafe/redactor/list'));
        $this->autoformat = ($this->autoformat == true) ? 'true' : 'false';
        $this->autoclear = ($this->autoclear == true) ? 'true' : 'false';
        $this->removeClasses = ($this->removeClasses == true) ? 'true' : 'false';
        $this->removeStyles = ($this->removeStyles == true) ? 'true' : 'false';
        $this->focus = ($this->focus == true) ? 'true' : 'false';
        $this->resize = ($this->resize == true) ? 'true' : 'false';
        
        list($name, $id) = $this->resolveNameID();

        $js = "
$('#{$id}').redactor({
    focus:   " . $this->focus . ",
    resize:  " . $this->resize . ",
    toolbar: '" . $this->toolbar . "',
    imageUpload: '" . $this->imageUpload . "',
    handler: '" . $this->handler . "',
    autoformat: " . $this->autoformat . ",
    autoclear: " . $this->autoclear . ",
    removeClasses: " . $this->removeClasses . ",
    removeStyles: " . $this->removeStyles . ",
    fileUpload:  '" . $this->fileUpload . "',
    fileDownload: '" . $this->fileDownload . "',
    fileDelete: '" . $this->fileDelete . "',
    imageGetJson: '" . $this->imageGetJson . "'
});";
        $cs->registerScript('Yii.' . get_class($this) . '#'.$this->attribute, $js, CClientScript::POS_READY);
    }
}

?>
