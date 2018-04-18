<!--news-->
<section class="news mobile-none">
    <div class="section-title">
        <span><i class="upper"><?=SHelper::getLan("news")?></i> <?=SHelper::getLan("company")?></span>
        <hr>
    </div>
    <div class="news-box">
        <div class="news-box-margin">
            <?foreach ($news as $key => $value) { ?>
                <?$img = json_decode($value->image,true);?>
                    <div class="news-item n<?=$key+1?>">
                        <div class="news-header">
                            <div class="news-img">
                                <div class="overflow">
                                    <?if($img == null){?>
                                        <img src="/media/img/logo/ATK.JPG">
                                    <? }else { ?>
                                        <img src="/upload/News/full/<?=$img[0]?>">
                                    <? } ?>
                                </div>
                            </div>
                            <div class="news-date">
                                <p><?=$value->getNicedate()?></p>
                            </div>
                        </div>
                        <div class="news-body">
                            <p class="news-title"><?=$value->{$lang."name_text"}?></p>
                            <?
                            $text = $value->{$lang."full_bigtexteditor"};
                            $max_lengh = 220;
                            $numbers = mb_strlen($text,"UTF-8")/$max_lengh;
                            $text = str_replace("img src"," ", $text);
                            if(mb_strlen($text, "UTF-8") > $max_lengh) {
                                $text_cut = mb_substr($text, 0, $max_lengh, "UTF-8");
                                $text_explode = explode(" ", $text_cut);
                                unset($text_explode[count($text_explode) - 1]);
                                $text_implode = implode(" ", $text_explode); ?>
                                <span><?=$text_implode."...";?></span>
                            <?} else { ?> <span> <?=$text;?> </span>
                            <? } ?>
                            <a href="/news/<?=$value->url_text?>"><?=SHelper::getLan("read")?></a>
                        </div>
                    </div>
            <? } ?>
        </div>
    </div>
</section>


<section class="mobile-news mobile-visible ">
    <div class="slider-box">
        <div class="box-owl">
            <div class="owl-left m-left">
                <img src="/media/img/part/r-m.png">
            </div>
            <div class="owl-center m-news">
                <?foreach ($news as $key => $value) {?>
                <?$img = json_decode($value->image,true); ?>
                    <div class="news-item">
                        <div class="news-header">
                            <div class="news-img">
                                <div class="overflow">
                                    <img src="/upload/News/full/<?=$img[0]?>">
                                </div>
                            </div>
                            <div class="news-date">
                                <p><?=$value->getNicedate()?></p>
                            </div>
                        </div>
                        <div class="news-body">
                            <p class="news-title"><?=$value->{$lang."name_text"}?></p>
                            <?
                            $text = $value->{$lang."full_bigtexteditor"};
                            $max_lengh = 220;
                            $numbers = mb_strlen($text,"UTF-8")/$max_lengh;
                            $text = str_replace("img src"," ", $text);
                            if(mb_strlen($text, "UTF-8") > $max_lengh) {
                                $text_cut = mb_substr($text, 0, $max_lengh, "UTF-8");
                                $text_explode = explode(" ", $text_cut);
                                unset($text_explode[count($text_explode) - 1]);
                                $text_implode = implode(" ", $text_explode); ?>
                                <span><?=$text_implode."...";?></span>
                            <?} else { ?> <span> <?=$text;?> </span>
                            <? } ?>
                            <a href="/news/<?=$value->url_text?>"><?=SHelper::getLan("read")?></a>
                        </div>
                    </div>
                <? } ?>

            </div>
            <div class="owl-right m-right">
                <img src="/media/img/part/r-m.png">
            </div>

        </div>
    </div>
</section>
<!--slider-->
<section class="slider" id="partners_ids">
    <div class="section-title">
        <span><?=SHelper::getLan("our")?><i class="upper white"> <?=SHelper::getLan("partners")?></i></span>
        <hr>
    </div>
    <div class="slider-box">
        <div class="box-owl">
            <div class="owl-left o-left">
                <img src="/media/img/part/l.png">
            </div>
            <div class="owl-center p-slider">
                <?foreach ($partners as $key => $value ) { ?>
                    <? $img = json_decode($value->image,true);?>
                        <div class="owl-img">
                            <img src="/upload/Partners/full/<?=$img[0]?>">
                        </div>
                <? } ?>
            </div>
            <div class="owl-right o-right">
                <img src="/media/img/part/l.png">
            </div>
        </div>
    </div>
</section>
