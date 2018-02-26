<?php
/**
 * Created by JetBrains PhpStorm.
 * User: strannik
 * Date: 26.10.11
 * Time: 9:14
 * To change this template use File | Settings | File Templates.
 */
 
class WLang extends CWidget{
    public $errors=array();
    public $langs=array();
    public $langTitle=array(
        'ru'=>'Русский',
        'en'=>'English',
        'kz'=>'Қазақша',
    );
    public $langErrors=array();
    public function init(){
        $this->langs = $this->controller->langs;
        foreach ($this->errors as $key=>$val){
            $l = explode('_',$key);
            $l = $l[count($l)-1];
            if(in_array($l,$this->langs)){
                $this->langErrors[$l]+=1;
            }
        }
    }
    public function run(){
        $cs=Yii::app()->clientScript;
        $cs->registerCoreScript('cookie')->registerScript('-timesafe-lang',"
        $('.language-select a').bind('click', function(e) {
            var t = $(this);
            var id = this.id;
            $('.language-select .btn-primary').removeClass('btn-primary');
            t.addClass('btn-primary');
            if (id === 'all')
                $('.-lang').fadeIn('fast');
            else {
                $('.-lang:visible:not(.'+id+')').fadeOut('fast');
                console.log(id);
                $('.' + id).fadeIn('fast');
            }
            $.cookie('-timesafe-language',id);
            e.preventDefault();
        });
");
        if($_COOKIE['-timesafe-language'] && $_COOKIE['-timesafe-language']!='all'){
             $cs->registerScript('-lang-show','
                $(\'.-lang:visible:not(.'.$_COOKIE['-timesafe-language'].')\').fadeOut(\'fast\');
             ');
        }
        $this->render('wLang');
    }

}
