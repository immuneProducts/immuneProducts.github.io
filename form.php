<meta http-equiv='refresh' content='10; url=/'>
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
$imageUploads = $_POST['imageUploads'];
$videoUploads = $_POST['videoUploads'];
// Формируем сообщение для отправки, в нём мы соберём всё, что ввели в форме
$mes = "Фамилия: $surname \nИмя: $name \nОтчество: $patr \nДата рождения: $dateBirth \nГород: $city \nВУЗ: $univer \nПрофессия: $prof \nТелефон: $tel \nE-mail: $email";
// Пытаемся отправить письмо по заданному адресу
// Если нужно, чтобы письма всё время уходили на ваш адрес — замените первую переменную $email на свой адрес электронной почты
$send = mail("immunework@gmail.com", "Заявка: $email", $mes, "Content-type:text/plain; charset = UTF-8\r\nFrom:$email");
// Если отправка прошла успешно — так и пишем
if ($send == 'true') {echo "Успешно";}
// Если письмо не ушло — выводим сообщение об ошибке
else {echo "Ой, что-то пошло не так";}
?>