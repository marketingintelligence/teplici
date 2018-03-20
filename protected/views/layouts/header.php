<!--  header  -->
<div class="modal-form">
    <div class="close"></div>
    <div class="bmiddle">
        <span class="success">Спасибо Ваше сообщение отправлено!</span>
        <ul>
            <li><input type="text" placeholder="Имя" name="name"></li>
            <li><input type="text" placeholder="Телефон" name="phone" class="phone_number"></li>
                <button class="bbtm bb2">
                    ОТПРАВИТЬ
                </button>
        </ul>
    </div>
</div>
<div class="black-bg"></div>
<a href="/anketa" class="modal-button">
    <div class="modal-button-box">
        <span>Нужна теплица?</span>
    </div>
</a>
<header>
    <div class="box">
        <div class="flex2">
            <div class="item-l flex2">
                <div class="mobile-menu">
                    <a href="/index.php">Главная</a>
                    <a href="/about">О нас</a>
                    <a href="/exhibition">Выставка</a>
                    <a href="/association">Ассоциация</a>
                    <a href="/news">Новости</a>
                    <a href="/articles">Статьи  и  публикации</a>
                </div>
                <div class="logo">
                    <a href="/"><img src="/media/img/logo.png"></a>
                </div>
                <div class="menu" data-id="1">
                    <div class="active_h"></div>
                    <a href="/about">
                        О нас
                    </a>
                </div>
                <div class="menu" data-id="2">
                    <div class="active_h"></div>
                    <a href="/association">
                        Ассоциация
                    </a>
                </div>
                <div class="menu" data-id="3">
                    <div class="active_h"></div>
                    <a href="/news">
                        Новости
                    </a>
                </div>
                <div class="menu" data-id="4">
                    <div class="active_h"></div>
                    <a href="/exhibition">
                        Выставка
                    </a>
                </div>
                <div class="menu" data-id="5">
                    <div class="active_h"></div>
                    <a href="/articles">
                        Статьи  и  публикации
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
                            <a href="#" class="front">
                                <div class="flip-border"></div>
                                РУС
                            </a>
                            <a href="#" class="back">
                                <div class="flip-border"></div>
                                ENG
                            </a>
                        </div>
                    </div>
                </div>
                <ul class="item-li">
                    <li>
                        <ul class="li">
                            <? foreach ($social as $key => $value) {?>
                                <li>
                                    <a href="<?=$value->url_text?>" class="fa-stack fa-lg">
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
                        <a href="tel: <?=$contacts[1]->full_bigtexteditor?>"><?=$contacts[1]->full_bigtexteditor?></a>
                    </li>
                    <li>
                        <div class="align-top mobile-visible">
                            <img src="/media/img/mail.png" class="i-marg">
                        </div>
                        <a href="<?=$contacts[2]->full_bigtexteditor?>"><?=$contacts[2]->full_bigtexteditor?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!--  header  -->