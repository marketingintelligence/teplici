<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/media/css/owl.css"/>
    <link rel="stylesheet" type="text/css" href="/media/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/media/css/responsive.css"/>
    <link rel="stylesheet" type="text/css" href="/media/css/animate.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="/media/img/ico.png">

    <title><?=$this->pageTitle?></title>
</head>
<body>
<section id="home">
    <?  $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = "serial_number";

        $social = Social::model()->findAll($criteria);
        $contacts = Contacts::model()->findAll($criteria);

        if(Yii::app()->user->hasState('lang')){
        $lang=Yii::app()->user->getState('lang');}
        ?>
    <?$this->renderPartial('/layouts/header',array("social"=>$social,"contacts"=>$contacts,"lang"=>$lang));?>
</section>

    <?=$content?>
    <? if ( (Yii::app()->controller->id == "site" || Yii::app()->controller->id == "about" || Yii::app()->controller->id == "association") && Yii::app()->controller->pageTitle != "Вход в Административную часть" ) { ?>
        <?
        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = "created_at DESC";
        $criteria -> limit = 3;

        $cr = new CDbCriteria();
        $cr -> condition = " status_int = 1";
        $cr -> order = "serial_number";

        $partners = Partners::model()->findAll($cr);
        $news = News::model()->findAll($criteria);
        ?>
        <?$this->renderPartial('/layouts/slider_and_news',array("news"=>$news, "partners" => $partners,"lang" => $lang));?>
    <? } ?>
<section id="footer">
    <?$this->renderPartial('/layouts/footer', array("social"=>$social,"contacts"=>$contacts,"lang" =>$lang));?>
</section>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--    <script type="text/javascript" src="/media/js/jquery.min.js"></script>
-->
<script type="text/javascript" src="/media/js/code.js"></script>
<script type="text/javascript" src="/media/js/mask.js"></script>
<script type="text/javascript" src="/media/js/owl-slider.js"></script>

<script>
    jQuery(function($){
        $(".phone_number").inputmask("+7 (999) 999 99 99");
    });
</script>

</html>