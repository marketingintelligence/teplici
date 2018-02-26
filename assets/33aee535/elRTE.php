<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class elRTE extends CInputWidget {

    private $lang = 'ru';
    private $allowedLanguages=array(
            'ru','ua','de','en',
    );
    private $toolbar = 'maxi';
    private $allowedToolbars=array(
            'tiny','compact','normal','complite','maxi','eldorado',
    );
    private $height = 400;
    private $options = array();
    private $styleWithCss = false;
    private $cssClass;
    private $absoluteURLs = false;
    private $allowSource = true;
    private $fmAllow=true;

    public $register=true;
    public $start=true;


    public function  __construct($owner=null) {
        parent::__construct($owner);
        $this->setLang(Yii::app()->language);
    }

    public function getFmAllow() {
        return $this->fmAllow;
    }

    public function setFmAllow($fmAllow) {
        if ( isset($fmAllow) )
            $this->fmAllow = (bool)$fmAllow;
    }

    public function getAllowSource() {
        return $this->allowSource;
    }

    public function setAllowSource($allowSource) {
        if ( isset($allowSource) )
            $this->allowSource = (bool)$allowSource;
    }

    public function getAbsoluteURLs() {
        return $this->absoluteURLs;
    }

    public function setAbsoluteURLs($absoluteURLs) {
        if ( isset($absoluteURLs) )
            $this->absoluteURLs = (bool)$absoluteURLs;
    }

    public function getCssClass() {
        return $this->cssClass;
    }

    public function setCssClass($cssClass) {
        if (isset($cssClass))
            $this->cssClass = $cssClass;
    }

    public function getStyleWithCss() {
        return $this->styleWithCss;
    }

    public function setStyleWithCss($styleWithCss) {
        $this->styleWithCss = (bool)$styleWithCss;
    }

    public function getToolbar() {
        return $this->toolbar;
    }

    public function setToolbar($toolbar) {
        if( in_array($toolbar , $this->allowedToolbars) )
            $this->toolbar = $toolbar;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($value) {
        if (!preg_match("/[\d]+/", $value))
            throw new CException(Yii::t(__CLASS__, 'height must be a string of digits'));
        $this->height = $value;
    }

    public function getLang() {
        return $this->lang;
    }

    public function setLang($lang) {
        if( in_array($lang , $this->allowedLanguages) )
            $this->lang = $lang;
    }

    public function setOptions($value) {
        if (!is_array($value))
            throw new CException(Yii::t(__CLASS__, 'options must be an array'));

        $this->options=$value;
    }

    public function getOptions() {
        return $this->options;
    }

    protected function makeOptions() {
        $options['lang'] = $this->lang;
        $options['height'] = $this->height;
        $options['toolbar'] = $this->toolbar;
        $options['styleWithCss'] = $this->styleWithCss;
        if ( isset($this->cssClass) )
            $options['cssClass'] = $this->cssClass;
        if ( isset($this->absoluteURLs) )
            $options['absoluteURLs'] = $this->absoluteURLs;
        if ( isset($this->allowSource) )
            $options['allowSource'] = $this->allowSource;
        if ( isset($this->fmAllow) )
            $options['fmAllow'] = $this->fmAllow;

        if (is_array($this->options)) {
            $options = array_merge($options, $this->options);
        }
        $options['fmOpen']='null';
        /*while (list($key,$opt) = each ($options)) {
            $option_js .= $key.':'.$opt.',';
        }*/
        return CJavaScript::encode($options);
    }

    /**
     * Run the widget, including the js files.
     */
    private function registerClientScripts() {

    }
    public function run() {
        if($this->register===true) {
            $cs=Yii::app()->clientScript;
            $dir = dirname(__FILE__).DIRECTORY_SEPARATOR;
            $baseUrl = Yii::app()->getAssetManager()->publish($dir);

            $clientScript = Yii::app()->getClientScript();
            $clientScript->registerCssFile('/css/bootstrap/timesafe/jquery-ui.css');
            $clientScript->registerCssFile($baseUrl.'/css/elrte.min.css');
            $clientScript->registerCssFile($baseUrl.'/css/elfinder.css');

            $clientScript->registerCoreScript('jquery');
            $clientScript->registerCoreScript('jquery.ui');

            $clientScript->registerScriptFile($baseUrl.'/js/elrte.min.js');
            $clientScript->registerScriptFile($baseUrl."/js/i18n/elrte.ru.js");
            $clientScript->registerScriptFile($baseUrl.'/js/elfinder.min.js');
            $clientScript->registerScriptFile($baseUrl."/js/i18n/elfinder.ru.js");
            //$clientScript->registerScriptFile($baseUrl."/js/i18n/elfinder.ru.js");


        }
        if($this->start===true) {
            list($name, $id) = $this->resolveNameID();
            $options = $this->makeOptions();
            $options=str_replace("'null'", "function(callback) {
                                    $('<div />').elfinder({
                                            url : '{$baseUrl}/connectors/php/connector.php',
                                            lang : 'ru',
                                            dialog : { width : 900, modal : true },
                                            editorCallback : callback
                                    })
                            }", $options);
            $js = "var opts = ".$options.";";
            $js .= "jQuery('#$id').elrte(opts);";
            if($this->register===true) {
                $js .= "jQuery('#$id').elrte(opts);";
                $cs->registerScript('Yii.elRTE'.$id,$js);
            }else {
                $js .= "jQuery('#$id').elrte();";
                echo '<script type="text/javascript">'.$js.'</script>';
            }
        }
    }
}


?>

