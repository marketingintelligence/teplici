<!--  footer  -->
<footer>
    <div class="shadow2"></div>
    <?=$contacts[3]->engname_text?>
    <div class="form flex">
        <div class="item">
            <div class="footer mobile-visible margg">
                <div class="flex">
                    <div class="f-text">
                        <p><?=SHelper::getLan("leave_message")?></p>
                        <span><?=SHelper::getLan("contact_with")?></span>
                    </div>
                    <div class="f-button">
                        <button class="bbtm"><?=SHelper::getLan("leave_message_btn")?></button>
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
                        <?=$contacts[0]->{$lang."full_bigtexteditor"}?>
                    </div>
                </li>
                <div class="m-foot">
                    <li>
                        <div class="align-top">
                            <img src="/media/img/tel.png">
                        </div>
                        <a href="tel:<?=$contacts[1]->{$lang."full_bigtexteditor"}?>" class="align-top border">
                            <?=$contacts[1]->{$lang."full_bigtexteditor"}?>
                        </a>
                    </li>
                    <li>
                        <div class="align-top">
                            <img src="/media/img/mail.png" class="i-marg">
                        </div>
                        <a href="mailto: <?=$contacts[2]->{$lang."full_bigtexteditor"}?>" class="align-top border">
                            <?=$contacts[2]->{$lang."full_bigtexteditor"}?>
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
                    <span class="message"><?=SHelper::getLan("leave_message")?></span>
                    <span class="success"><?=SHelper::getLan("success_message")?></span>
                </div>
                <div class="bmiddle">
                    <ul>
                        <form action="" id="footer-form" method="POST">
                            <li><input class="name" type="text" required="" placeholder="<?=SHelper::getLan("name")?>" name="name"></li>
                            <li><input class="email" required="" type="email" placeholder="E-mail" name="email"></li>
                            <?php if($lang == null) {?>
                                <li><textarea class="messages" name="textarea" cols="30" rows="5" placeholder="Сообщение"></textarea></li>
                            <? }else {?>
                                <li><textarea class="messages" name="textarea" cols="30" rows="5" placeholder="Message"></textarea></li>
                            <?} ?>
                            <button class="bbtm bb3">
                                <?=SHelper::getLan("send")?>
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
