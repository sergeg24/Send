<?php
$to   = "";
$site = $_SERVER['SERVER_NAME'];

function save() {
    $file  = $_SERVER['SERVER_NAME'].".send";
    $today = date("F j, Y, g:i a");
    $htmlspecialchars = '[' . $today . '] ';

    foreach ($_POST as $name => $value) {
        if($value!='undefined' && $value!=''){
            $htmlspecialchars .= $name . ":" . $value . "|";
        }
    }

    $htmlspecialchars = substr($htmlspecialchars,0,-1) . "\n";

    if ($fopen = fopen($file, "a+")) {
        fwrite($fopen, iconv("UTF-8", "WINDOWS-1251", $htmlspecialchars));
    }

    fclose($fopen);
}

if($_POST["form"] == "1"){

    $name  = $_POST['name'];
    $phone = $_POST['phone'];

    $phone = str_replace('+', '', $phone);

    $titles = "Заявка с формы (Заказать звонок) с сайта " . $site;

    $mess  = "<body><strong>".$titles."</strong><br />";
    $mess .= "<br />";
    $mess .= "<strong>Контактные данные:</strong><br />";
    $mess .= "Имя: <br />" . $name . "<br />";
    $mess .= "Телефон: <br />+" . $phone;

    $header  = "Content-type: text/html; charset=\"utf-8\"\n";
    $header .= "From: " . $site . "<info@".$site.">\n";
    $header .= "Subject: " . $titles . "\n";

    if (empty($phone)) {
        echo "Укажите номер телефона!";
    } else if (!preg_match('/^.[0-9\(\)\-\+]+$/',$phone)) {
        echo "Укажите корректный номер телефона!";
    } else {
        if (mail($to, $titles, $mess, $header)) {
            echo "1";
        } else {
            echo "Не удалось отправить сообщение!";
        }
    }
}