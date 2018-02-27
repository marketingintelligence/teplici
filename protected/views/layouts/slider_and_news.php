<!--news-->
<section class="news mobile-none">
    <div class="section-title">
        <span><i class="upper">Новости</i> компании</span>
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
                                    <img src="/upload/News/full/<?=$img[0]?>">
                                </div>
                            </div>
                            <div class="news-date">
                                <p><?=$value->getNicedate()?></p>
                            </div>
                        </div>
                        <div class="news-body">
                            <p class="news-title"><?=$value->name_text?></p>
                            <span><?=$value->short_bigtext?></span>
                            <a href="/news/<?=$value->url_text?>">Читать дальше</a>
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
                            <p class="news-title"><?=$value->name_text?></p>
                            <span><?=$value->short_bigtext?></span>
                            <a href="/news/<?=$value->url_text?>">Читать дальше</a>
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
        <span>Наши<i class="upper white"> Партнеры</i></span>
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
