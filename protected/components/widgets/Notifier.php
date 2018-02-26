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
//        $this->transport = Swift_MailTransport::newInstance();
        //$this->transport = Swift_SmtpTransport::newInstance('smtp.mail.ru', 25)->setUsername('niko_lay')->setPassword('43046721');
        if (strstr($_SERVER["HTTP_HOST"], "den")) {
            $this->transport = Swift_SmtpTransport::newInstance('mail.sitepark.kz', 25)->setUsername('denny@sitepark.kz')->setPassword('1234qwert=');
        }
        else {
            $this->transport = Swift_SmtpTransport::newInstance('localhost', 25);
        }
    }

    function faq( $model ) {
        $eemail = SysSetting::getValue('adminMail');
        if ( strstr( $eemail, ',' )!==false ) {
            $eemail=explode( ',', $eemail );
        }
        $message = Swift_Message::newInstance()
        ->setSubject('Сообщение с Заданным вопросом с сайта "'.Yii::app()->name.'"')
        ->setFrom($this->email)
        ->setTo($eemail);
        $message->setBody( "
<b>Имя:</b> {$model->name} <br>
<b>E-mail:</b> {$model->email} <br>
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
    
}

?>