<div class="foot-colls line-footer-dash-vert">
    <?php $i=0; foreach ($items as $key => $item): ?>        
        <div class="foot-link-1"><a href="<?=$item['url']?>"><?=$item['label']?></a></div>
        <? if(count($item['child'])>0): $i=0;?>        
            <?php foreach ($item['child'] as $k => $child): ?>
                <div class="foot-link-2"><a href="<?=$child['url']?>"><?=$child['label']?></a></div>
            <?php $i++; endforeach ?>        
        <? endif; ?>
    <?php  $i++; if($i>5) echo '</div><div class="foot-colls line-footer-dash-vert">'; endforeach ?>

</div>
<div class="clear">&nbsp;</div>