<section class="second-header news">
    <div class="shadow2"></div>
    <hr class="bottom-line">
    <hr class="bottom-line2">
</section>
<section class="section-block no-border m-bg-none">
    <div class="section-title">
        <span><i class="upper"><?=SHelper::getLan("states")?></i> <?=SHelper::getLan("and")?> <i class="upper"><?=SHelper::getLan("publications")?></i> <?=SHelper::getLan("comp")?></span>
        <hr>
    </div>
    <div class="box2">
        <div class="n-news-container">
            <div class="news-slider" id="news-1">

                <?foreach ($articles as $key=>$value){ ?>
                <? $img = json_decode($value->image,true); ?>
                <div class="n-news-item">
                    <div class="n-news-item-img">
                        <div class="n-news-img-border"></div>
                        <div class="overflow">
                            <?if ($img == null){ ?>
                                <img src="/media/img/logo/ATK.JPG">
                            <? }else {?>
                                <img src="/upload/Articles/full/<?=$img[0]?>">
                            <? } ?>
                        </div>
                    </div>
                    <div class="n-news-body">
                        <div class="n-news-text">
                            <p class="n-news-date"><?=$value->getNiceDate()?></p>
                            <p class="n-news-title"><?=$value->{$lang."name_text"}?></p>
                            <div class="bottom-border">
                                <?=$value->{$lang."full_bigtexteditor"}?>
                            </div>
                            <hr>
                        </div>
                        <div class="n-news-button">
                            <div class="animated-height"></div>
                            <img src="/media/img/news-line.png">
                            <a href="#"><?=SHelper::getLan("read")?></a>
                        </div>
                    </div>
                </div>
                <? } ?>

            </div>
        </div>
        <div class="news-paggination">
            <div class="n-news-digits">
                <?php $this->widget('application.components.WPages',array('_pages'=>$pages)); ?>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="video" id="video-ids">
    <div class="video-box">
        <div class="video-box-container">
            <? foreach ($video as $key=>$value) { ?>
                <? $img = json_decode($value->image,true);?>
                <div class="video-item">
                    <?=$value->short_bigtext?>
                    <!--<iframe width="345px" height="100%" src="https://www.youtube.com/embed/mpwr6-Tgohg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->
                </div>
            <?  } ?>
        </div>
    </div>
</section>