<meta http-equiv='refresh' content='5; url=/'>
<meta charset="UTF-8" />
<?php
$token = 'y0_AgAAAAA_7vhRAAhnFQAAAADOdOkrwtUySKsgTCCVw99cFpX6fZV9cNM';

if (isset($_POST['surname']) && isset($_POST['name']) && isset($_POST['patr']) && isset($_POST['dateBirth']) && isset($_POST['city']) && isset($_POST['univer']) && isset($_POST['prof']) && isset($_POST['email']) && isset($_POST['tel'])) {
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patr = $_POST['patr'];
    $dateBirth = $_POST['dateBirth'];
    $city = $_POST['city'];
    $univer = $_POST['univer'];
    $prof = $_POST['prof'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $db_host = "localhost";
    $db_user = "ch05761_app";
    $db_password = "SGhnqB7J";
    $db_base = 'ch05761_app';
    $db_table = "applications";

    try {
        $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
        $db->exec("set names utf8");
        $data = array('surname' => $surname, 'name' => $name, 'patr' => $patr, 'dateBirth' => $dateBirth, 'city' => $city, 'univer' => $univer, 'prof' => $prof, 'email' => $email, 'tel' => $tel);
        $query = $db->prepare("INSERT INTO $db_table (Фамилия, Имя, Отчество, Дата, Город, ВУЗ, Профессия, Телефон, Почта) values (:surname, :name, :patr, :dateBirth, :city, :univer, :prof, :tel, :email)");
        $query->execute($data);
        $result = true;
    } catch (PDOException $e) {
        print "Ошибка!: " . $e->getMessage() . "<br/>";
    }

    if ($result) {
        echo "Успех. Информация занесена в базу данных" . "<br/>";
    }

    if ($_FILES) {
        foreach ($_FILES["imageUploads"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["imageUploads"]["tmp_name"][$key];
                $name = $_FILES["imageUploads"]["name"][$key];
                move_uploaded_file($tmp_name, "test/$name");
                $file = __DIR__ . "/test/$name";
                $path = '/test/';
                $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/upload?path=' . urlencode($path . $email . '_portfolio') . "&overwrite=true");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $token));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $res = curl_exec($ch);
                curl_close($ch);
                $res = json_decode($res, true);
                if (empty($res['error'])) {
                    $fp = fopen($file, 'r');
                    $ch = curl_init($res['href']);
                    curl_setopt($ch, CURLOPT_PUT, true);
                    curl_setopt($ch, CURLOPT_UPLOAD, true);
                    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file));
                    curl_setopt($ch, CURLOPT_INFILE, $fp);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($http_code == 201) {
                        echo 'Портфолио загружено' . "<br/>";
                    }
                }
                unlink($file);
            }
        }
    }

    if ($_FILES) {
        foreach ($_FILES["videoUploads"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK && pathinfo($_FILES["videoUploads"]["name"][$key])['extension'] == 'mp4') {
                $tmp_name = $_FILES["videoUploads"]["tmp_name"][$key];
                $name = $_FILES["videoUploads"]["name"][$key];
                move_uploaded_file($tmp_name, "test/$name");
                $file = __DIR__ . "/test/$name";
                $path = '/test/';
                $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/upload?path=' . urlencode($path . $email . '_video') . "&overwrite=true");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $token));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $res = curl_exec($ch);
                curl_close($ch);
                $res = json_decode($res, true);
                if (empty($res['error'])) {
                    $fp = fopen($file, 'r');
                    $ch = curl_init($res['href']);
                    curl_setopt($ch, CURLOPT_PUT, true);
                    curl_setopt($ch, CURLOPT_UPLOAD, true);
                    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file));
                    curl_setopt($ch, CURLOPT_INFILE, $fp);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($http_code == 201) {
                        echo 'Видео загружено' . "<br/>";
                    }
                }
                unlink($file);
            }
        }
    }
}
?>