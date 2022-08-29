<meta http-equiv='refresh' content='1000; url=/'>
<meta charset="UTF-8" />
<?php
$surname = $_POST['surname'];
$name = $_POST['name'];
$patr = $_POST['patr'];
$dateBirth = $_POST['dateBirth'];
$city = $_POST['city'];
$univer = $_POST['univer'];
$prof = $_POST['prof'];
$email = $_POST['email'];
$tel = $_POST['tel'];
// $imageUploads = $_POST['imageUploads'];
// $videoUploads = $_POST['videoUploads'];
$mes = "Фамилия: $surname \nИмя: $name \nОтчество: $patr \nДата рождения: $dateBirth \nГород: $city \nВУЗ: $univer \nПрофессия: $prof \nТелефон: $tel \nE-mail: $email";
$send = mail("immunework@gmail.com", "Заявка: $email", $mes, "Content-type:text/plain; charset = UTF-8\r\nFrom:admin@ch05761.tmweb.ru");
if ($send == 'true') {echo "Успешно";}
else {echo "Ой, что-то пошло не так";}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>