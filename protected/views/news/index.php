<section class="second-header news">
    <div class="shadow2"></div>
    <hr class="bottom-line">
    <hr class="bottom-line2">
</section>
<section class="section-block m-bg-none">
    <div class="section-title">
        <span><i class="upper"><?=SHelper::getLan("news")?></i><?=SHelper::getLan("company")?></span>
        <hr>
    </div>
    <div class="box2">
        <div class="n-news-container">
            <div class="news-slider" id="news-1">
                <? foreach ($news as $key=>$value) {?>
                    <?$img = json_decode($value->image,true);?>
                        <div class="n-news-item">
                            <div class="n-news-item-img">
                                <div class="n-news-img-border"></div>
                                <div class="overflow">
                                    <?if( $img == null) {?>
                                        <img src="/media/img/logo/ATK.JPG">
                                    <?}else {?>
                                        <img src="/upload/News/full/<?=$img[0]?>">
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
                <? }  ?>
            </div>
        </div>
        <div class="news-paggination">
           <!-- <div class="prev-next">
                <div class="prev"></div>
                <div class="next"></div>
            </div>-->
            <div class="n-news-digits">
                <?php $this->widget('application.components.WPages',array('_pages'=>$pages)); ?>
            </div>
        </div>
    </div>
</section>
