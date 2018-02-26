<ul id="menu">
    <?php foreach ($items as $key => $item): ?>
    <li<?=$key===0?' class="first"':''?>>
        <? if(count($item['child'])>0):?>
        <a class="drop" href="<?=$item['url']?>"><?=$item['label']?><!--[if gte IE 7]><!--></a><!--<![endif]-->
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul>
            <?php foreach ($item['child'] as $k => $child): ?>
                <?php $style = ($item['url'] == "/pahe/show/name/new") ? 'background:#c29b7a; color:#fff; text-decoration:none;' : ''; ?>
                 <li><a style="<?php echo $style; ?>" href="<?=$child['url']?>"><?=$child['label']?></a></li>   
            <?php endforeach ?>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
        <? else: ?>
        <a href="<?=$item['url']?>"><?=$item['label']?></a>
        <? endif; ?>
    </li>
        
    <?php endforeach ?>
</ul>
