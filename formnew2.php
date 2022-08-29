
<?php
// Файлы phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

// Переменные, которые отправляет пользователь
$surname = $_POST['surname'];
$name = $_POST['name'];
$patr = $_POST['patr'];
$dateBirth = $_POST['dateBirth'];
$city = $_POST['city'];
$univer = $_POST['univer'];
$prof = $_POST['prof'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$file = $_FILES['imageUploads'];

// Формирование самого письма
$title = "Заголовок письма";
$body = "
<h2>Новое письмо</h2>
<b>Фамилия:</b> $surname<br>
<b>Имя:</b> $name<br>
<b>Почта:</b> $email<br><br>
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'immunework'; // Логин на почте
    $mail->Password   = 'snqakrdnepucwuzk'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('immunework@gmail.com', 'immunework'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('immunework@gmail.com');  

    // Прикрипление файлов к письму
if (!empty($file['name'][0])) {
    for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
        $filename = $file['name'][$ct];
        if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
            $rfile[] = "Файл $filename прикреплён";
        } else {
            $rfile[] = "Не удалось прикрепить файл $filename";
        }
    }   
}
// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);