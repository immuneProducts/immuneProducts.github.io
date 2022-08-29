<?php
require './PHPMailer.php';
require './SMTP.php';
require './Exception.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
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

$mail->From = "admin@ch05761.tmweb.ru";
$mail->FromName = "test";

$mail->addAddress("immunework@gmail.com", $name);

echo "1";
if (!empty($file['name'][0])) {
    echo "2";
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

$mail->isHTML(true);

$mail->Subject = "Subject Text";
$mail->Body = "Фамилия: $surname \nИмя: $name \nОтчество: $patr \nДата рождения: $dateBirth \nГород: $city \nВУЗ: $univer \nПрофессия: $prof \nТелефон: $tel \nE-mail: $email";

try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}

echo json_encode(["resultfile" => $rfile]);