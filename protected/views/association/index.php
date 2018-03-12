<section class="second-header about">
    <div class="shadow2"></div>
    <div class="header-container mobile-none">
        <div class="header-container-item">
            <p class="light">Мы трудимся ради процветания</p>
            <hr>
            <h1>сельского хозяйства Казахстана!</h1>
        </div>
    </div>

    <div class="header-container mobile-visible">
        <div class="header-container-item">
            <h2>АССОЦИАЦИЯ ТЕПЛИЦ </h2>
            <h1>КАЗАХСТАНА</h1>
        </div>
        <div class="header-container-item-2">
            <ul>
                <li><h3>Мы трудимся радипроцветания</h3></li>
                <li><h2>сельского хозяйства Казахстана!</h2></li>
            </ul>
        </div>
    </div>
    <hr class="bottom-line">
    <hr class="bottom-line2">
</section>
<!--<section class="second-header about assoc">
    <div class="shadow2"></div>
    <div class="header-container mobile-none">
        <div class="header-container-item">
            <p class="light">Мы трудимся радипроцветания сельского хозяйства Казахстана!</p>
            <hr>
            <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, </span>
        </div>
    </div>
    <div class="header-container mobile-visible">
        <div class="header-container-item">
            <h2>АССОЦИАЦИЯ ТЕПЛИЦ </h2>
            <h1>КАЗАХСТАНА</h1>
        </div>
        <div class="header-container-item-2">
            <ul>
                <li><h3>Мы трудимся радипроцветания</h3></li>
                <li><h2>сельского хозяйства Казахстана!</h2></li>
            </ul>
        </div>
    </div>
    <hr class="bottom-line">
    <hr class="bottom-line2">
</section>-->

<section class="assoc-block">
    <div class="box2">
        <div class="about-box">
            <div class="assoc-item">
                <div class="section-title">
                    <span>Тепличные<i class="upper"> комбинаты</i></span>
                    <hr>
                </div>
                <div class="shodow-body comb" id="combinat-1">
                    <?=$combinates[0]->full_bigtexteditor?>
                </div>
                <div class="paggination p-left">
                    <? for($i=1; $i<=$comb_count; $i++){ ?>
                        <? if ( $i == 1 ) {?>
                        <a data-id="<?=$i?>" href="#" class="active"><?=$i?></a>
                    <? }else { ?>
                            <a data-id="<?=$i?>" href="#" > <?=$i?></a>
                        <? } ?>
                    <?} ?>
                </div>
            </div>
            <div class="assoc-item">
                <div class="section-title">
                    <span><i class="upper">Поставщики </i> тепличной технологии</span>
                    <hr>
                </div>
                <div class="shodow-body post" id="postavshik-1">
                    <?php foreach ( $supplier as $key => $value ) { ?>
                        <?$img = json_decode($value->image,true);?>
                            <div class="assoc-item2">
                                <div class="item2-flex">
                                    <div class="item2-img">
                                        <img src="/upload/Supplier/full/<?=$img[0]?>">
                                    </div>
                                    <div class="item2-text">
                                        <p><?=$value->name_text?></p>
                                    </div>
                                </div>
                                <div class="item2-body">
                                    <span><?=$value->short_bigtext?></span>
                                </div>
                            </div>
                    <? } ?>
                </div>
                <div class="paggination p-right">
                    <? for($i=0; $i<$s_pages; $i++){ ?>
                        <? if ( $i == 0 ) {?>
                            <a data-numbers="<?=($i*5)?>" href="#" class="active"><?=$i+1?></a>
                        <? }else { ?>
                            <a data-numbers="<?=($i*5)?>" href="#" > <?=$i+1?></a>
                        <? } ?>
                    <?} ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about2">
    <div class="shadow-top"><hr></div>
    <div class="about2-box">
        <span>Участвуйте в нашей ежегодной </span>
        <p>международной выставке! </p>
        <a href="exhibition"><div class="pad">Подробнее</div> </a>
        <img src="/media/img/about-6.png" class="about-img">
    </div>
    <div class="shadow-bottom"><hr></div>
</section>

<script>
    $("body").on("click",".p-right a",function(e){
        e.preventDefault();
        var numbers = $(this).data('numbers');
        $('.p-right a').removeClass('active');
        $(this).addClass('active');
        $.ajax({
            url: "/Association/getsuppliers",
            type: "post",
            data: {'numbers':numbers},
            success:function(data){
                e.preventDefault();
                $('.post').removeClass('active animated slideInLeft').addClass('animated slideOutLeft').fadeOut().promise().done(function () {
                    $('.post').html(data).removeClass('animated slideOutLeft').addClass('active animated slideInLeft').fadeIn();
                });
                console.log(data);
            }
        })
    });

    $("body").on("click",".p-left a",function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('.p-left a').removeClass('active');
        $(this).addClass('active');
        $.ajax({
            url: "/Association/getcombines",
            type: "post",
            data: {'id':id},
            success:function(data){
                e.preventDefault();
                $('.comb').removeClass('active animated slideInLeft').addClass('animated slideOutLeft').fadeOut().promise().done(function () {
                    $('.comb').html(data).removeClass('animated slideOutLeft').addClass('active animated slideInLeft').fadeIn();
                });
                /*$('.comb').html(data);
                console.log(data);*/
            }
        })
    });
</script>
