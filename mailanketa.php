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
$mail->setFrom('savezhanov.d@maint.kz');
$mail->addAddress('savezhanov.d@maint.kz', 'Maint Company');
$mail->isHTML(true);

$mail->Subject = 'Заявка';
$mail->Body    = "
    <html>
			<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<style>
				body{ font-family: 'Times New Roman';}
				p { font-weight:bold;}
				</style>
			</head>
			<body>
			    ДАННЫЕ О ФИРМЕ
				<p>Наименование:</p> ".$_POST['nomination']."<br/>
				<p>Форма собственности:</p> ".$_POST['self_form']."<br/>
				<p>Адрес района строительства:</p> ".$_POST['address']."<br/>
				<p>Ф.И.О. руководителя:</p> ".$_POST['head_name']."<br/>
				<p>Рабочий № телефон:</p> ".$_POST['headtel_number']."<br/>
				<p>Факс:</p> ".$_POST['head_fax']."<br/>
				<p>Мобильный:</p> ".$_POST['head_mobile']."<br/>
				<p>Ф.И.О. контактного лица:</p> ".$_POST['contact_name']."<br/>
				<p>Рабочий № телефон:</p> ".$_POST['contacttel_number']."<br/>
				<p> Мобильный:</p> ".$_POST['contact_mobile']."<br/>
				
				ЗАЯВКА НА ТЕПЛИЦУ
				<p> Характеристика района строительства (по СНИП):</p>
				<p> Сила ветра:</p> ".$_POST['wind_strength']."<br/>
				<p> Снеговая нагрузка:</p> ".$_POST['snow_load']."<br/>
				<p> Сейсмичность:</p> ".$_POST['seismicity']."<br/>
				<p> Регион Казахстана:</p> ".$_POST['region']."<br/>
				<p> Место дислокации:</p> ".$_POST['place']."<br/>
				<p> Размер предполагаемой теплицы :</p> ".$_POST['greenhouse_size']."<br/>
				<p> Культура:</p> ".$_POST['culture']."<br/>
				<p> Вид теплицы:</p> ".$_POST['greenhouse_type']."<br/>
				<p> Покрытие теплицы:</p> ".$_POST['greenhouse_coating']."<br/>
				<p> Размеры теплицы:</p>
				<p> Ширина:</p> ".$_POST['greenhouse_width']."<br/>
				<p> Длина:</p> ".$_POST['greenhouse_length']."<br/>
				<p> Источник отопление:</p> ".$_POST['heating_source']."<br/>
				<p> Субстрат:</p> ".$_POST['substrate']."<br/>
				<p> Система электродосвечивания:</p> ".$_POST['system']."<br/>
				<p> Другие пожелания:</p> ".$_POST['message']."<br/>
																
			</body>
	</html>";
$mail->AltBody = 'This is a plain-text message body';

if (!$mail->send()) {
    exit("Mailer Error: " . $mail->ErrorInfo);
}

?>
