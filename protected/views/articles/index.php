<section class="second-header news">
    <div class="shadow2"></div>
    <hr class="bottom-line">
    <hr class="bottom-line2">
</section>
<section class="section-block no-border m-bg-none">
    <div class="section-title">
        <span><i class="upper">СТАТЬИ</i> и <i class="upper">ПУБЛИКАЦИИ</i> компании</span>
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
                            <p class="n-news-title"><?=$value->name_text?></p>
                            <div class="bottom-border">
                                <?=$value->full_bigtexteditor?>
                            </div>
                            <hr>
                        </div>
                        <div class="n-news-button">
                            <div class="animated-height"></div>
                            <img src="/media/img/news-line.png">
                            <a href="#">Читать дальше</a>
                        </div>
                    </div>
                </div>
                <? } ?>

            </div>
        </div>
        <div class="news-paggination">
    <!--        <div class="prev-next">
                <div class="prev"></div>
                <div class="next"></div>
            </div>
    -->        <div class="n-news-digits">
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
                    <video width="100%" height="100%" controls="true" poster="/upload/Video/full/<?=$img[0]?>">
                        <source src="www.youtube.com/watch?v=3bGNuRtlqAQ" type="video/mp4" />
                    </video>
                </div>
            <?  } ?>
        </div>
    </div>
</section>
<script>
    videos = document.querySelectorAll("video");
    for (var i = 0, l = videos.length; i < l; i++) {
        var video = videos[i];
        var src = video.src || (function () {
            var sources = video.querySelectorAll("source");
            for (var j = 0, sl = sources.length; j < sl; j++) {
                var source = sources[j];
                var type = source.type;
                var isMp4 = type.indexOf("mp4") != -1;
                if (isMp4) return source.src;
            }
            return null;
        })();
        if (src) {
            var isYoutube = src && src.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
            if (isYoutube) {
                var id = isYoutube[1].match(/watch\?v=|[\w\W]+/gi);
                id = (id.length > 1) ? id.splice(1) : id;
                id = id.toString();
                var mp4url = "http://www.youtubeinmp4.com/redirect.php?video=";
                video.src = mp4url + id;
            }
        }
    }
</script>