<?php
/**
 * Created by JetBrains PhpStorm.
 * User: strannik
 * Date: 29.07.11
 * Time: 15:03
 * To change this template use File | Settings | File Templates.
 */

class SBreabcrumbs extends CWidget
{


    public $tagName = 'ul';
    public $htmlOptions = array('class' => 'i-crumbs');
    public $encodeLabel = true;
    public $homeLink=null;
    public $links = array();
    public $separator = ' <span>//</span> ';

    public function run()
    {
//        if (empty($this->links))
//            return;
        $links = array();
        if ($this->homeLink === null)
            echo '' .CHtml::link(Yii::t('zii', 'Home'), Yii::app()->homeUrl). '';
        else if ($this->homeLink !== false)
            echo '' .$this->homeLink. '';
        foreach ($this->links as $label => $url) {
            echo $this->separator;
            if (is_string($label) || is_array($url))
                echo'' . CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url) . '';
            else
                echo '' . ($this->encodeLabel ? CHtml::encode($url) : $url) . '';
            
        }        


    }
}
