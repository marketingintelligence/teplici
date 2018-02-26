<?php

class Notifier {

    public $email=null;
    public $transport=null;

    function __construct() {
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('application.vendor.swift.swift_required', true);
        spl_autoload_register(array('YiiBase', 'autoload'));
        $m = SysSetting::model()->findByAttributes(array('name'=>'adminEmail'));
        if (trim(strip_tags($m->value))!='') {$this->email = trim(strip_tags($m->value));}
        else {$this->email = Yii::app()->params['adminEmail'];}
        if (strstr($this->email, ',')!==false) {$this->email = explode(',', $this->email);}
        $this->template = '';
        $this->template = str_replace("[HOST]", 'http://'.$_SERVER["HTTP_HOST"], $this->template);
        $this->template = str_replace("\n", "", $this->template);
        $this->template = str_replace("\r", "", $this->template);
        $this->template = str_replace("\t", "", $this->template);
        // $this->transport = Swift_SmtpTransport::newInstance('195.210.46.24', 25)->setUsername('support@alinex.kz')->setPassword('alina123');
        // $this->transport = Swift_SmtpTransport::newInstance('localhost', 25)->setUsername('support@alinex.kz')->setPassword('alina123');
        $this->transport = Swift_MailTransport::newInstance();
        //$this->transport = Swift_SmtpTransport::newInstance('localhost', 25);
    }

    function faq( $model ) {
        $eemail = SysSetting::getValue('faqMail');
        if ( strstr( $eemail, ',' )!==false ) {
            $eemail=explode( ',', $eemail );
        }
        $message = Swift_Message::newInstance()
        ->setSubject('Сообщение с Заданным вопросом с сайта "'.Yii::app()->name.'"')
        ->setFrom($this->email)
        ->setTo($eemail);
        $ftype = Ftype::model()->findByPk($model->parent_Ftype_id)->title;
        $message->setBody( "
<b>Имя:</b> {$model->name} <br>
<b>E-mail:</b> {$model->email} <br>
<b>Тема вопроса:</b> {$ftype} <br>
<b>Текст вопроса:</b> {$model->question} <br>
", 'text/html' );
        $mailer = Swift_Mailer::newInstance( $this->transport );
        return $mailer->send( $message );
    }

    function contact( $model ) {
        $eemail = SysSetting::getValue('adminMail');
        if ( strstr( $eemail, ',' )!==false ) {
            $eemail=explode( ',', $eemail );
        }
        $message = Swift_Message::newInstance()
        ->setSubject('Сообщение с формы обратной связи с сайта "'.Yii::app()->name.'"')
        ->setFrom($this->email)
        ->setTo($eemail);
        $message->setBody( "
<b>Тема:</b> {$model->subject} <br>
<b>Имя:</b> {$model->name} <br>
<b>E-mail:</b> {$model->email} <br>
<b>Сообщение:</b> {$model->body} <br>
", 'text/html');
        $mailer = Swift_Mailer::newInstance( $this->transport );
        return $mailer->send( $message );
    }

    function feedback( $model ) {
        $eemail = SysSetting::getValue('feedbackMail');
        if ( strstr( $eemail, ',' )!==false ) {
            $eemail=explode( ',', $eemail );
        }
        $message = Swift_Message::newInstance()
        ->setSubject('Сообщение с формы заявки от компании с сайта "'.Yii::app()->name.'"')
        ->setFrom($this->email)
        ->setTo($eemail);
        $message->setBody( "
<b>Компания:</b> {$model->company} <br>
<b>Страна:</b> {$model->country} <br>
<b>Город:</b> {$model->city} <br>
<b>Телефон:</b> {$model->phone} <br>
<b>E-mail:</b> {$model->email} <br>
<b>Контактное лицо:</b> {$model->name} <br>
<b>Дополнительная Информация:</b> {$model->body} <br>
", 'text/html');
        $mailer = Swift_Mailer::newInstance( $this->transport );
        return $mailer->send( $message );
    }

    function club( $model ) {
        $ctype = Ctype::model()->findByPk($model->parent_Ctype_id)->title;
        $eemail = SysSetting::getValue('clubMail');
        if ( strstr( $eemail, ',' )!==false ) {
            $eemail=explode( ',', $eemail );
        }
        $message = Swift_Message::newInstance()
        ->setSubject('Новая анкета с сайта "'.Yii::app()->name.'"')
        ->setFrom($this->email)
        ->setTo($eemail);
        $message->setBody( "
<b>Название компании/бригады или ФИО:</b> {$model->title} <br>
<b>Телефоны:</b> {$model->phones} <br>
<b>E-mail:</b> {$model->email} <br>
<b>Спецификация:</b> {$ctype} <br>
<b>Описание:</b> {$model->text} <br>
", 'text/html' );
        $mailer = Swift_Mailer::newInstance( $this->transport );
        return $mailer->send( $message );
    }

    function subscriber( $model ) {
        $link = "http://".$_SERVER["HTTP_HOST"]."/site/subscribe/code/".md5($model->id)."/email/".md5($model->email).".html";
        $link = "<a href='".$link."' target='_blank'>".$link."</a>";
        $message = Swift_Message::newInstance()
        ->setSubject('Подписка на рассылку на сайте "'.Yii::app()->name.'"')
        ->setFrom($this->email)
        ->setTo($model->email);
        $message->setBody( "
Здравствуйте, {$model->email} <br>
Кто-то, возможно, Вы подписались на рассылку на сайте ".Yii::app()->name."<br>
Если Вы хотите подтвердить подписку, пожалуйста, пройдите по ссылке:<br>
<br>".$link."<br><br>
Если Вы этого не делали, просто удалите это письмо.<br><br>
---<br>С уважением,<br>Администрация сайта ".Yii::app()->name.".
", 'text/html' );
        $mailer = Swift_Mailer::newInstance( $this->transport );
        return $mailer->send( $message );
    }

    function subscribe($model,$stocks,$news,$subscribers) {
        $text = '<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Рассылка с сайта Alinex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<style type="text/css">
    body { line-height: 18px; font-family: arial; font-size: 13px; color: #000000; background: #fff; margin: 0; padding: 0; }
    td { border: 0 none; border-collapse: collapse; vertical-align: top; }
    img {outline: none; border: none;}
    a {outline: none; border: none; color: #005231; text-decoration: underline;}
    a:hover {color: #005231; text-decoration: none;}
    a.black, a.black:hover {color: #000000;}
    a.white, a.white:hover {color: #ffffff;}
    a.inverse {text-decoration: none;}
    a.inverse:hover {text-decoration: underline;}
</style>
<div id="cover" style="width: 100%;">
    <table cellpadding="0" cellspacing="0" style="width: 700px; height:133px;margin-left: auto;margin-right: auto;">
        <tr>
            <td style="width: 30px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="30" height="133" alt=""/></td>
            <td style="width: 156px; vertical-align: middle;"><a href="'.$_SERVER["HTTP_HOST"].'"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/logo.png" width="156" height="74" alt=""/></a></td>
            <td style="width: 30px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="30" height="1" alt=""/></td>
            <td style="width: 164px; vertical-align: middle;"><a href="'.$_SERVER["HTTP_HOST"].'"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/slogan.png" width="164" height="64" alt=""/></a></td>
            <td style="width: 115px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="115" height="1" alt=""/></td>
            <td style="vertical-align: middle;">
                <table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 26px;"><a href="#"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/phone-icon.png" width="26" height="18" alt=""/></a></td>
                        <td style="width: 10px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="10" height="1" alt=""/></td>
                        <td style="font-family: \'Arial Narrow\', Arial; font-size: 18px; font-weight: bold; color: #f78d2a;">
                            Горячая линия: <br/>
                            <span style="white-space: nowrap;">'.SysSetting::model()->getValue("hotLine").'</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 30px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="30" height="1" alt=""/></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" style="width: 700px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 30px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="30" height="133" alt=""/></td>
            <td style="border: 2px solid #f78d2a; background: #ffffff;">
                <div style="height: 35px;">&nbsp;</div>';
        if ($model->content) {
            $text .= '<table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                        <td>'.str_replace("\n", "<br>", $model->content).'</td>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                    </tr>
                </table>
                <div style="height: 30px;">&nbsp;</div>';
        }
        if ($stocks != NULL) {
            $text .= '<table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td>
                            <table style="background: #f78d2a; height: 40px;">
                                <tr>
                                    <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                                    <td style="text-align: center; vertical-align: middle; font-family: \'Arial Narrow\', Arial; font-size: 24px; font-weight: bold; color: #ffffff; text-transform: uppercase;">Акция!</td>
                                    <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                                </tr>
                            </table>
                        </td>
                        <td style="vertical-align: middle; font-size: 11px; text-align: right;">&#8594; <a href="http://'.$_SERVER["HTTP_HOST"].'/stock/index.html" class="black">Все акции</a></td>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                    </tr>
                </table>
                <div style="height: 30px;">&nbsp;</div>';
            foreach ($stocks as $stockModel) {
                $img = json_decode($stockModel->image,true);
                $text .= '<div style="text-align: center"><a href="http://'.$_SERVER["HTTP_HOST"].'/stock/show/id/'.$stockModel->id.'.html"><img src="http://'.$_SERVER["HTTP_HOST"].'/upload/Stock/full/'.$img[0].'" width="599" alt=""/></a></div>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                        <td>
                            <div style="font-family: \'Arial Narrow\', Arial; font-size: 16px; font-weight: bold;">
                                <a href="http://'.$_SERVER["HTTP_HOST"].'/stock/show/id/'.$stockModel->id.'.html">'.$stockModel->title.'</a>
                            </div>
                            <div style="color: #f78d2a;">'.$stockModel->vremiaakcyi.'</div>
                        </td>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                    </tr>
                </table>
                <div style="height: 40px;">&nbsp;</div>';
            }
        }
        if ($news != NULL) {
            $text .= '<table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td>
                            <table style="background: #f78d2a; height: 40px;">
                                <tr>
                                    <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/00_pixel.gif" width="20" height="1" alt=""/></td>
                                    <td style="text-align: center; vertical-align: middle; font-family: \'Arial Narrow\', Arial; font-size: 24px; font-weight: bold; color: #ffffff; text-transform: uppercase;">Новости</td>
                                    <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/00_pixel.gif" width="20" height="1" alt=""/></td>
                                </tr>
                            </table>
                        </td>
                        <td style="vertical-align: middle; font-size: 11px; text-align: right;">&#8594; <a href="http://'.$_SERVER["HTTP_HOST"].'/news/index.html" class="black">Все новости</a></td>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/00_pixel.gif" width="20" height="1" alt=""/></td>
                    </tr>
                </table>
                <div style="height: 30px;">&nbsp;</div>';
            foreach ($news as $newsModel) {
                $img = json_decode($newsModel->image,true);
                $text .= '<table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/00_pixel.gif" width="20" height="1" alt=""/></td>
                        <td style="width: 110px;">
                            <a href="http://'.$_SERVER["HTTP_HOST"].'/news/show/id/'.$newsModel->id.'.html"><img src="http://'.$_SERVER["HTTP_HOST"].'/upload/News/sm/'.$img[0].'" width="110" alt=""/></a>
                        </td>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/00_pixel.gif" width="20" height="1" alt=""/></td>
                        <td>
                            <div style="padding-bottom: 5px;">
                                <div style="font-family: \'Arial Narrow\', Arial; font-size: 16px; font-weight: bold;">
                                    <a href="http://'.$_SERVER["HTTP_HOST"].'/news/show/id/'.$newsModel->id.'.html">'.$newsModel->title.'</a>
                                </div>
                            </div>
                            '.$newsModel->content.'
                            <div style="font-size: 11px; padding-top: 5px; color: #7f7f7f;">'.date("d.m.Y", $newsModel->created_at).'</div>
                        </td>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/00_pixel.gif" width="20" height="1" alt=""/></td>
                    </tr>
                </table>
                <div style="height: 25px;">&nbsp;</div>';
            }
        }
        $text .= '</td>
            <td style="width: 30px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="30" height="1" alt=""/></td>
        </tr>
    </table>
    <div style="height: 30px;">&nbsp;</div>
    <table cellpadding="0" cellspacing="0" style="width: 700px; margin-left: auto;margin-right: auto;background: #005231;">
        <tr>
            <td style="width: 30px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="30" height="1" alt=""/></td>
            <td>
                <table cellpadding="0" cellspacing="0" style="width: 100%; height: 75px;">
                    <tr>
                        <td style="vertical-align: middle; color: #ffffff; width: 180px;">
                            <a href="http://'.$_SERVER["HTTP_HOST"].'" class="white">Перейти на сайт</a> &nbsp; <img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/target-blank.png" width="9" height="7" alt=""/>
                        </td>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                        <td style="vertical-align: middle; text-align: center; color: #ffffff;">
                            <a href="[UNSUB]" class="white">Отписаться от рассылки</a>
                        </td>
                        <td style="width: 20px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="20" height="1" alt=""/></td>
                        <td style="vertical-align: middle; text-align: right; font-size: 12px; color: #ffffff;">
                            &copy; 2006 - '.date("Y").' Alina Ltd
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 30px;"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/subscribe/00_pixel.gif" width="30" height="1" alt=""/></td>
        </tr>
    </table>
</div>
</body>
</html>';
        if ($subscribers != NULL) {
            foreach ($subscribers as $subscriber) {
                $re = '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i';
                if (preg_match($re, $subscriber->email)) {
                    $unsub = "http://".$_SERVER["HTTP_HOST"]."/site/subscribe/code/".md5($subscriber->id)."/email/".md5($subscriber->email)."/unsub/1.html";
                    $text = str_replace("[UNSUB]",$unsub,$text);
                    $message = Swift_Message::newInstance()
                    ->setSubject($model->title)
                    ->setFrom($this->email)
                    ->setTo($subscriber->email);
                    $message->setBody($text, 'text/html');
                    $mailer = Swift_Mailer::newInstance($this->transport);
                    return $mailer->send($message);
                }
            }
        }
    }
    
}

?>