<!--  footer  -->
<footer>
    <div class="shadow2"></div>
    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Af27467eb5c235d962865c364fa46c9d0019f5d8eaa257d3a8ac962a518e3be3b&amp;source=constructor" width="100%" height="100%" frameborder="0"></iframe>
    <div class="form flex">
        <div class="item">
            <div class="footer mobile-visible margg">
                <div class="flex">
                    <div class="f-text">
                        <p>Оставьте сообщение</p>
                        <span>И мы свяжемся с Вами!</span>
                    </div>
                    <div class="f-button">
                        <button class="bbtm">Оставить сообщение</button>
                    </div>
                </div>
                <div class="hr"></div>
            </div>
            <ul class="item1_ul">
                <li class="f_li">
                    <a href="/"><img src="/media/img/m_logo.png"></a>
                </li>
                <li>
                    <div class="align-top">
                        <img src="/media/img/map2.png">
                    </div>
                    <div class="align-top border">
                        г.Алматы<br>
                        ул.Жандосова,51<br>
                        здание КазНИИ, офис 606
                    </div>
                </li>
                <div class="m-foot">
                    <li>
                        <div class="align-top">
                            <img src="/media/img/tel.png">
                        </div>
                        <a href="tel: +7 (727) 303 68 28" class="align-top border">
                            +7 (727) 303 68 28
                        </a>
                    </li>
                    <li>
                        <div class="align-top">
                            <img src="/media/img/mail.png" class="i-marg">
                        </div>
                        <a href="mailto: greenhouses.kz@mail.ru" class="align-top border">
                            greenhouses.kz@mail.ru
                        </a>
                        <ul class="li li2" id="social">
                            <?foreach ($social as $key=>$value) { ?>
                                <li>
                                    <a href="<?=$value->url?>" class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="<?=$value->short_description?>"></i>
                                    </a>
                                </li>
                            <? } ?>
                        </ul>
                    </li>
                </div>
            </ul>
        </div>
        <div class="item mobile-slide">
            <div class="border2">
                <div class="btop">
                    <span class="message">Оставьте сообщение</span>
                    <span class="success">Спасибо Ваше сообщение отправлено!</span>
                </div>
                <div class="bmiddle">
                    <ul>
                        <form action="" id="footer-form" method="POST">
                            <li><input  class="name" type="text" required placeholder="Имя" name="name"></li>
                            <li><input class="email" required type="email" placeholder="E-mail" name="email"></li>
                            <li><textarea class="messages" name="textarea"  cols="30" rows="5"  placeholder="Сообщение"></textarea></li>
                            <button class="bbtm bb3">
                                ОТПРАВИТЬ
                            </button>
                        </form>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="footer">
        <div class="hr"></div>
    </div>
    <ul class="li mobile-visible important" >
        <? foreach ( $social as $key=>$value ) { ?>
            <li>
                <a href="<?=$value->url?>" class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="<?=$value->short_description?>"></i>
                </a>
            </li>
        <? } ?>
    </ul>
</footer>
<!--  footer  -->
