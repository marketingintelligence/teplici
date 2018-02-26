<p class="pull-right language-select">
    <? foreach ($this->langs as $lang): ?>
    <a href="#<?=$lang?>" class="btn <?=$_COOKIE['-timesafe-language']=='-'.$lang?' btn-primary':''?><?=isset($this->langErrors[$lang])?' btn-danger':''?>" id="-<?=$lang?>" <?=isset($this->langErrors[$lang])?(' rel="tooltip" data-original-title="'.$this->langErrors[$lang].' '.Yii::t('app','Ошибка|Ошибки|Ошибок|Ошибки',$this->langErrors[$lang]).' "'):''?>>
    		
        <span class="lang-<?=$lang?>"><?=$this->langTitle[$lang]?></span>
    </a>
    <? endforeach;?>
    <a href="#all" class="btn <?=($_COOKIE['-timesafe-language']=='all' || !$_COOKIE['-timesafe-language'])?' btn-primary':''?>" id="all">
        <span class="lang-all">Все</span>
    </a>    
</p>