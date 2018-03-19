<!-- Sidebar -->
<section class="sidebar">
    <div class="shadow2"></div>
    <div class="flex">
        <div class="m-wid">
            <div>
                <div class="title">
                    <h2>
                        10-я Юбилейная Международная выставка
                    </h2>
                    <h1>
                        <b>«ТЕПЛИЦЫ. ОВОЩЕВОДСТВО. ОРОШЕНИЕ»<br>
                            <span>«ЦВЕТЫ АЛМАТЫ 2018»</span></b>
                    </h1>
                </div>
            </div>
            <div class="white_blocks">
                <div class="flex m-column">
                    <div class="wb_item1">
                        <div class="date">
                            <div class="date_text">
                                19-21 апреля 2018 г.
                            </div>
                        </div>
                    </div>
                    <div class="wb_item2">
                        <div class="rel m-wid2">
                            <div class="white_block">
                                <div class="border_block"></div>
                                <div class="flex2">
                                    <div class="s_item1">
                                        <ul>
                                            <li class="first_li flex3">
                                                Дата и время
                                            </li>
                                            <li>19.04.2018 Четверг   10:00 – 18:00</li>
                                            <li>20.04.2018 Пятница  10:00 – 18:00</li>
                                            <li>21.04.2018 Суббота  10:00 – 16:00</li>
                                        </ul>
                                    </div>
                                    <div class="s_item2">
                                        <img src="/media/img/cal.png">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div  class="rel m-wid2 m-border">
                            <div class="white_block">
                                <div class="border_block"></div>
                                <div class="flex2">
                                    <div class="s_item1">
                                        <ul>
                                            <li class="first_li flex3">
                                                Адрес
                                            </li>
                                            <li>МВЦ «Атакент» п. № 9</li>
                                            <li>г. Алматы, ул. Тимирязева, 42.</li>
                                            <li>+7 (727) 303-68-28</li>
                                            <li>Greenhouses.kz@mail.ru</li>
                                        </ul>
                                    </div>
                                    <div class="s_item2">
                                        <img src="/media/img/map.png" class="current">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>
</section>
<section class="second_block">
    <div class="flex">
        <div class="item1">
            <div class="sb_item">
                <div class="flex border_top">
                    <div class="nav1">
                        <div class="active_nav transformx">
                            <div class="circle3 transform"></div>
                        </div>
                    </div>
                    <div class="nav2">
                        <div class="nav">
                            <div class="ul_put">
                                <ul>
                                    <a href="#" class="href" data-id="1">
                                        <li class="active_li mobile-no">
                                            Выставки
                                            <div class="triangle"></div>
                                            <div class="border_li"></div>
                                        </li>
                                    </a>
                                    <a href="#" class="href" data-id="2">
                                        <li>
                                            Условия участия
                                            <div class="triangle"></div>
                                            <div class="border_li"></div>
                                        </li>
                                    </a>
                                    <?$file = json_decode($exupload[0]->file,true);?>
                                    <a href="#" class="href" data-id="3" data-route="<?=$file[0]?>" >
                                        <li>
                                            План выставки
                                            <div class="triangle"></div>
                                            <div class="border_li"></div>
                                        </li>
                                    </a>
                                    <a href="#" class="href" data-id="4">
                                        <li>
                                            Посетителям
                                            <div class="triangle"></div>
                                            <div class="border_li"></div>
                                        </li>
                                    </a>
                                    <a href="#" class="href" data-id="5">
                                        <li>
                                            Программа выставки
                                            <div class="triangle"></div>
                                            <div class="border_li"></div>
                                        </li>
                                    </a>
                                    <a href="#" class="href" data-id="6">
                                        <li>
                                            Список участников
                                            <div class="triangle"></div>
                                            <div class="border_li"></div>
                                        </li>
                                    </a>
                                    <a href="#" class="href" data-id="2015">
                                        <li>
                                            Пресс релизы
                                            <div class="triangle"></div>
                                            <div class="border_li"></div>
                                        </li>
                                        <div class="dropdown">
                                            <ul>
                                                <?foreach ($exupload as $key=>$value) {?>
                                                <?$file = json_decode($value->file,true);?>
                                                    <a href="#" data-id="<?=(2009+$key)?>" data-routes="<?=$file[0]?>"><li><?=$value->name_text?></li></a>
                                                <? } ?>
                                            </ul>
                                        </div>
                                    </a>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="item2">
            <div class="content active" id="1">
                <div class="box-shadow">
                    <div class="back-vystvka mobile-visible">
                        <a href="#">Назад</a>
                        <p>Выставки</p>
                        <hr>
                    </div>
                    <div class="top_text">
                        <ul>
                            <li>Официальная церемония открытия выставки</li>
                            <li>состоится 19 апреля в 10:00.</li>
                        </ul>
                    </div>
                    <div class="middle_text">
                        <div>Тематики выставки «ТЕПЛИЦЫ. ОВОЩЕВОДСТВО. ОРОШЕНИЕ»:</div>
                        <div>теплицы и тепличные технологии, строительство теплиц, овощехранилище, овощная культура, выращивание томатов, энергосберегающие технологии, светильники для досвечивания теплиц, субстраты, ирригация, микроклимат, мобильные системы стеллажей, рассадные и салатные комплексы, система капельного орошения и терморегуляция, система обогрева, котельные установки и емкости для воды, система затемнения, агротекстиль, система зашторивания теплиц, укрывной материал для почвы, парники и оранжереи, Вертикальное фермерство, оборудование для сортировки и упаковки,  приусадебное  хозяйство и садоводство, семена, рассада, посадочный материал, инструменты и инвентарь, ландшафт и ландшафтный дизайн, семеноводство и растениеводство, средства защиты растений, минеральные удобрении, ядохимикаты и шмелиные ульи, линии по выращиванию салатных и зеленных культур.</div>
                    </div>
                </div>
                <div class="btm_text">
                    В рамках выставки планируется ряд широкомасштабных мероприятий, в том числе семинар-совещание «Защищённый грунт Казахстана-2018» с участием Министерства сельского хозяйства Республики Казахстан, сельхоз. формирований, финансирующих организаций, представителей действующих тепличных комбинатов. В рамках семинара будут обсуждаться перспективные планы и развитие тепличной отрасли АПК, технологии LED освещении и т.д.
                    <ul>
                        <li>Семинар начнёт свою работу <span>19 апреля в 11:00</span></li>
                        <li>в здании выставочного павильона <span>№ 9 МВЦ «Атакент».</span></li>
                    </ul>
                </div>
            </div>
            <div class="content" id="2">
                <div class="back-vystvka mobile-visible">
                    <a href="#">Назад</a>
                    <p>Условия участия</p>
                    <hr>
                </div>
                <div class="top_text two">
                    <ul>
                        <li>Приглашаем принять участие на выставку <span>"Теплицы. Овощеводство. Орошение. Цветы Алматы 2018", </span></li>
                        <li>которая состоится с 19 по 21 апреля 2018 года в ВЦ "Атакен".  </li>
                    </ul>
                </div>
                <ul class="spisok">
                    <span>Для участия необходимо:</span>
                    <li>1. Выбрать стенд на общем плане. <a href="#"> Скачать</a></li>
                    <li>2. Заполнить заявку. <a href="#">Скачать</a></li>
                    <li>3. Выбрать дополнительное оборудование (при необходимости). <a href="#"> Скачать</a></li>
                    <li>4. Написать ФИО участников от Вашей компании для бейджа. </li>
                    <li>5. Предоставить информацию о компании в официальный каталог выставки. <a href="#"> Скачать</a></li>
                    <li>6. После выставления счета, произвести оплату до 05 апреля 2018 года.</li>
                </ul>
                <div class="box-shadow">
                    <div class="middle_text">
                        <div>Тематики выставки «ТЕПЛИЦЫ. ОВОЩЕВОДСТВО. ОРОШЕНИЕ»:</div>
                        <div>теплицы и тепличные технологии, строительство теплиц, овощехранилище, овощная культура, выращивание томатов, энергосберегающие технологии, светильники для досвечивания теплиц, субстраты, ирригация, микроклимат, мобильные системы стеллажей, рассадные и салатные комплексы, система капельного орошения и терморегуляция, система обогрева, котельные установки и емкости для воды, система затемнения, агротекстиль, система зашторивания теплиц, укрывной материал для почвы, парники и оранжереи, Вертикальное фермерство, оборудование для сортировки и упаковки,  приусадебное  хозяйство и садоводство, семена, рассада, посадочный материал, инструменты и инвентарь, ландшафт и ландшафтный дизайн, семеноводство и растениеводство, средства защиты растений, минеральные удобрении, ядохимикаты и шмелиные ульи, линии по выращиванию салатных и зеленных культур.</div>
                    </div>
                </div>
                <div class="btm_text">
                    В рамках выставки планируется ряд широкомасштабных мероприятий, в том числе семинар-совещание «Защищённый грунт Казахстана-2018» с участием Министерства сельского хозяйства Республики Казахстан, сельхоз. формирований, финансирующих организаций, представителей действующих тепличных комбинатов. В рамках семинара будут обсуждаться перспективные планы и развитие тепличной отрасли АПК, технологии LED освещении и т.д.
                    <ul>
                        <li>Семинар начнёт свою работу <span>19 апреля в 11:00</span></li>
                        <li>в здании выставочного павильона <span>№ 9 МВЦ «Атакент».</span></li>
                    </ul>
                </div>
            </div>
            <div class="content" id="3">
                <div class="back-vystvka mobile-visible">
                    <a href="#">Назад</a>
                    <p>План выставки</p>
                    <hr>
                </div>
                <?foreach ($explan as $key=>$value){?>
                    <?$file = json_decode($value->file,true);?>
                        <div class="ex-plan">
                            <embed src="/upload/Explan/<?=$file[0]?>" width="100%" height="100%" />
                        </div>
                <? } ?>
            </div>
            <div class="content" id="4">
                <div class="back-vystvka mobile-visible">
                    <a href="#">Назад</a>
                    <p>Посетителям</p>
                    <hr>
                </div>
                <div class="top_text two three">
                    <ul>
                        <li>Форма регистрации <span>посетителя</span></li>
                    </ul>
                </div>
                <div class="reg-form">
                    <div class="reg-thanks">
                        <p>Спасибо, ваше сообщение отправлено!</p>
                    </div>
                    <form>
                        <input id="name" required="" type="text" placeholder="Имя *" class="inline">
                        <input id="email" required="" type="email" placeholder="E-mail *" class="margin inline">
                        <input id="company" type="text" placeholder="Компания">
                        <input id="contact" type="text" placeholder="Контакты" class="margin">
                        <div class="right-float">
                            <button type="submit">Зарегистрироваться</button>
                        </div>
                    </form>
                </div>
                <div class="box-shadow">
                    <div class="middle_text">
                        <div>Тематики выставки «ТЕПЛИЦЫ. ОВОЩЕВОДСТВО. ОРОШЕНИЕ»:</div>
                        <div>теплицы и тепличные технологии, строительство теплиц, овощехранилище, овощная культура, выращивание томатов, энергосберегающие технологии, светильники для досвечивания теплиц, субстраты, ирригация, микроклимат, мобильные системы стеллажей, рассадные и салатные комплексы, система капельного орошения и терморегуляция, система обогрева, котельные установки и емкости для воды, система затемнения, агротекстиль, система зашторивания теплиц, укрывной материал для почвы, парники и оранжереи, Вертикальное фермерство, оборудование для сортировки и упаковки,  приусадебное  хозяйство и садоводство, семена, рассада, посадочный материал, инструменты и инвентарь, ландшафт и ландшафтный дизайн, семеноводство и растениеводство, средства защиты растений, минеральные удобрении, ядохимикаты и шмелиные ульи, линии по выращиванию салатных и зеленных культур.</div>
                    </div>
                </div>
                <div class="btm_text">
                    В рамках выставки планируется ряд широкомасштабных мероприятий, в том числе семинар-совещание «Защищённый грунт Казахстана-2018» с участием Министерства сельского хозяйства Республики Казахстан, сельхоз. формирований, финансирующих организаций, представителей действующих тепличных комбинатов. В рамках семинара будут обсуждаться перспективные планы и развитие тепличной отрасли АПК, технологии LED освещении и т.д.
                    <ul>
                        <li>Семинар начнёт свою работу <span>19 апреля в 11:00</span></li>
                        <li>в здании выставочного павильона <span>№ 9 МВЦ «Атакент».</span></li>
                    </ul>
                </div>
            </div>
            <div class="content" id="5">
                <div class="back-vystvka mobile-visible">
                    <a href="#">Назад</a>
                    <p>Программа выставки</p>
                    <hr>
                </div>
                <div class="box-shadow">
                    <div class="top_text two">
                        <ul>
                            <li>Тематики выставки <?=$exprogram[0]->name_text?></li>
                            <li><span><?=$exprogram[0]->title?></li>
                        </ul>
                    </div>
                    <?=$exprogram[0]->full_bigtexteditor?>
                    <!--<table>
                        <tr>
                            <td colspan="2" class="bg">19 апреля, четверг</td>
                        </tr>
                        <tr>
                            <td width="15%" class="m-td"><p>10:00 – 18:00</p></td>
                            <td><p>Время работы выставки. Первый день.</p></td>
                        </tr>
                        <tr>
                            <td><p>10:00 - 10:30</p></td>
                            <td>
                                <p>Официальная церемония открытия выставки</p>
                                <p>Приветственные речи почетных гостей: представители от МСХ РК, Управления сельского хозяйства и ветеринарии г. Алматы, АО "КазАгроГарант",АО "Аграрная кредитная корпорация" АО «КазАгроФинанс», АО "Фонд Финансовой Поддержки Сельского Хозяйства", Синьцзянский международный выставочный центр, а также Президент ОЮЛ «Ассоциация Теплиц Казахстана».</p>
                                <p>Место проведения: вход в павильон 9, КЦДС «Атакент».</p>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2"><p>10:30 - 11:00</p></td>
                            <td>
                                <p>Обход стендов выставки в составе вышеупомянутых лиц, а также в сопровождении СМИ (радио и телевидения, и пр.)</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Семинар – совещание  "Защищенный грунт Казахстана-2018" Место проведения: конференц-зал, 9-ый павильон.</p>
                            </td>
                        </tr>
                        <tr>
                            <td><p>11:00 - 11:10</p></td>
                            <td>
                                <p>Вступительное слово на открытии семинара: Президент ОЮЛ "Ассоциация теплиц Казахстана"-Кошман Канат Кошманович.</p>
                            </td>
                        </tr>
                    </table>-->
                </div>
            </div>
            <div class="content" id="6">
                <div class="back-vystvka mobile-visible">
                    <a href="#">Назад</a>
                    <p>Список участников</p>
                    <hr>
                </div>
                <div class="box-shadow">
                    <table class="uchastnik">
                        <?foreach ($partlist as $key=>$value){ ?>
                            <?php
                            $criteria = new CDbCriteria();
                            $criteria -> condition = " status_int = 1 AND id ='$value->country_id'";
                            $countries = Countries::model()->find($criteria);
                            $img = json_decode($countries->image,true);

                            $check = Countries::model()->findBySql('SELECT id FROM countries WHERE name_text="Не выбрано"');
                            ?>
                          <?php
                            if( !empty($value->partnercountry_id AND $value->partnercountry_id != $check->id )) {
                                $partcriteria = new CDbCriteria();
                                $partcriteria->condition = " status_int = 1 AND id ='$value->partnercountry_id'";
                                $partcountries = Countries::model()->find($partcriteria);
                                $partimg = json_decode($partcountries->image, true);?>
                                <tr>
                                    <td width="56%"><?=$value->name_text?></td>
                                    <td width="4%" class="td-none"><img src="/upload/Countries/full/<?=$img[0]?>"></td>
                                    <td width="4%" class="td-none"><img src="/upload/Countries/full/<?=$partimg[0]?>"></td>
                                    <td width="34%" class="td-border"><?=$countries->name_text?>/<?=$partcountries->name_text?></td>
                                </tr>
                            <? }else  {?>
                                <tr>
                                    <td width="56%"><?=$value->name_text?></td>
                                    <td width="4%" class="td-none"><img src="/upload/Countries/full/<?=$img[0]?>"></td>
                                    <td width="4%" class="td-none"></td>
                                    <td width="34%" class="td-border"><?=$countries->name_text?></td>
                                </tr>
                                <? } ?>
                        <? } ?>
                    </table>
                </div>
            </div>

            <?php foreach ($exupload as $key=>$value) {?>
                <div class="content" id="<?=($key+2009)?>">
                    <div class="back-vystvka mobile-visible">
                        <a href="#">Назад</a>
                    </div>
                    <div class="reliz">
                        <?$file = json_decode($value->file,true);?>
                        <!--<object data="/upload/Exupload/<?/*=$file[0]*/?>" type="application/pdf" style="width: 100%; height: 100%;">-->
                            <!--<iframe src="/upload/Exupload/<?/*=$file[0]*/?>" style="width: 100%; height: 600px;"  frameborder="0">Ваш браузер не поддерживает фреймы</iframe>-->
                        <embed src="/upload/Exupload/<?=$file[0]?>" width="100%" height="600px" />
                        <!--</object>-->
                    </div>
                </div>
            <?  }  ?>

        </div>
    </div>
</section>
<!--Second block -->
