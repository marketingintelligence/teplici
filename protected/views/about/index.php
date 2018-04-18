<section class="second-header about">
    <div class="shadow2"></div>
    <div class="header-container mobile-none">
        <div class="header-container-item">
            <p class="light"><?=SHelper::getLan("head_title")?></p>
            <hr>
            <h1><?=SHelper::getLan("head_title2")?></h1>
        </div>
    </div>

    <div class="header-container mobile-visible">
        <div class="header-container-item">
            <h2><?=SHelper::getLan("greenhouse_ass")?> </h2>
            <h1><?=SHelper::getLan("kaz")?></h1>
        </div>
        <div class="header-container-item-2">
            <ul>
                <li><h3><?=SHelper::getLan("head_title")?></h3></li>
                <li><h2><?=SHelper::getLan("head_title2")?></h2></li>
            </ul>
        </div>
    </div>
    <hr class="bottom-line">
    <hr class="bottom-line2">
</section>


<section class="section-block m-bg-none">
    <div class="section-title">
        <span><i class="upper"><?=SHelper::getLan("about_comp")?></i><?=SHelper::getLan("comp_about")?></span>
        <hr>
    </div>
    <?=$pages[0]->{$lang."full_bigtexteditor"}?>
</section>
<section class="about2">
    <div class="shadow-top"><hr></div>
    <div class="about2-box">
        <span><?=SHelper::getLan("participate")?> </span>
        <p><?=SHelper::getLan("participate2")?></p>
        <a href="exhibition"><div class="pad"><?=SHelper::getLan("more")?></div> </a>
        <img src="/media/img/about-6.png" class="about-img">
    </div>
    <div class="shadow-bottom"><hr></div>
</section>
