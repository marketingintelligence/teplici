<!--  header  -->
<!--<div class="modal-form">
    <div class="close"></div>
    <div class="bmiddle">
        <span class="success">Спасибо Ваше сообщение отправлено!</span>
        <ul>
            <li><input type="text" placeholder="Имя" name="name"></li>
            <li><input type="text" placeholder="Телефон" name="phone" class="phone_number"></li>
                <button class="bbtm bb2">
                    <?/*=SHelper::getLan("send")*/?>
                </button>
        </ul>
    </div>
</div>-->
<div class="black-bg"></div>
<a href="/anketa" class="modal-button">
    <div class="modal-button-box">
        <span><?=SHelper::getLan("request")?></span>
    </div>
</a>
<header>
    <div class="box">
        <div class="flex2">
            <div class="item-l flex2">
                <div class="mobile-menu">
                    <a href="/index.php"><?=SHelper::getLan("home")?></a>
                    <a href="/about"><?=SHelper::getLan("about")?></a>
                    <a href="/exhibition"><?=SHelper::getLan("exhibition")?></a>
                    <a href="/association"><?=SHelper::getLan("association")?></a>
                    <a href="/news"><?=SHelper::getLan("newsheader")?></a>
                    <a href="/articles"><?=SHelper::getLan("art_pub")?></a>
                </div>
                <div class="logo">
                    <a href="/"><img src="/media/img/logo.png"></a>
                </div>
                <div class="menu" data-id="1">
                    <div class="active_h"></div>
                    <a href="/about">
                        <?=SHelper::getLan("about")?>
                    </a>
                </div>
                <div class="menu" data-id="2">
                    <div class="active_h"></div>
                    <a href="/association">
                        <?=SHelper::getLan("association")?>
                    </a>
                </div>
                <div class="menu" data-id="3">
                    <div class="active_h"></div>
                    <a href="/news">
                        <?=SHelper::getLan("newsheader")?>
                    </a>
                </div>
                <div class="menu" data-id="4">
                    <div class="active_h"></div>
                    <a href="/exhibition">
                        <?=SHelper::getLan("exhibition")?>
                    </a>
                </div>
                <div class="menu" data-id="5">
                    <div class="active_h"></div>
                    <a href="/articles">
                        <?=SHelper::getLan("art_pub")?>
                    </a>
                </div>
            </div>
            <div class="item-r">
                <div class="mobile-visible share">
                    <img src="/media/img/share.png">
                </div>
                <div class="language">
                    <div class="flip-container transformx" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <?if($lang == "rus" || $lang == null ) {?>
                                <a href="#" class="front" data-lang="1">
                                    <div class="flip-border"></div>
                                    РУС
                                </a>
                                <a href="#" class="back" data-lang="2">
                                    <div class="flip-border"></div>
                                    ENG
                                </a>
                            <? }else {?>
                                <a href="#" class="front" data-lang="2">
                                    <div class="flip-border"></div>
                                    ENG
                                </a>
                                <a href="#" class="back" data-lang="1">
                                    <div class="flip-border"></div>
                                    РУС
                                </a>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <ul class="item-li">
                    <li>
                        <ul class="li">
                            <? foreach ($social as $key => $value) {?>
                                <li>
                                    <a  target="_blank" href="<?=$value->url?>" class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="<?=$value->short_description?>"></i>
                                    </a>
                                </li>
                            <? } ?>
                        </ul>
                    </li>
                    <li>
                        <div class="align-top mobile-visible">
                            <img src="/media/img/tel.png">
                        </div>
                        <a href="tel: <?=$contacts[1]->{$lang."full_bigtexteditor"}?>"><?=$contacts[1]->{$lang."full_bigtexteditor"}?></a>
                    </li>
                    <li>
                        <div class="align-top mobile-visible">
                            <img src="/media/img/mail.png" class="i-marg">
                        </div>
                        <a href="mailto:<?=$contacts[2]->{$lang."full_bigtexteditor"}?>"><?=$contacts[2]->{$lang."full_bigtexteditor"}?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!--  header  -->

<script>
    $(".back").live("click",function (e) {
        e.preventDefault();
        var lang = $(this).data('lang');
        window.location.reload();
        $.ajax({
            url: "/Site/language",
            type: "post",
            data: {'lang':lang},
        })
    });
</script>
