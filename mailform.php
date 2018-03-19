<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();

$mail->CharSet = 'UTF-8';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "maint.zakaz@gmail.com";
$mail->Password = "MMaint112233";
$mail->setFrom('greenhouses.kz@mail.ru');
$mail->addAddress('greenhouses.kz@mail.ru', 'Maint Company');
/*$mail->setFrom('savezhanov.d@maint.kz');
$mail->addAddress('savezhanov.d@maint.kz', 'Maint Company');*/
$mail->isHTML(true);

$mail->Subject = 'Заявка';
$mail->Body    = "
    <html>
			<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
			</head>
			<body>
				Имя: ".$_POST['name']."<br/>
				E-mail: ".$_POST['email']."<br/>
				Компания: ".$_POST['company']."<br/>
				Контакты: ".$_POST['contact']."<br/>
			</body>
	</html>";
$mail->AltBody = 'This is a plain-text message body';

if (!$mail->send()) {
    exit("Mailer Error: " . $mail->ErrorInfo);
}
?>
<?php

$model = new Feedback;

    /*if (isset($_POST['email']))*/

$model->name = $_POST['name'];
$model->email = $_POST['email'];
$model->text = $_POST['text'];

$model->save();
    /*$model->image=$this->saveFile($model,'image');
    if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Сохранено');
        $this->redirect(array('list'));
    } else {
        Yii::app()->user->setFlash('error', 'Ошибка при сохранении');

    }*/

?>
