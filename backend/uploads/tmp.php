<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/external/functions.php");

$lang_vals = get_lang();
$c = $lang_vals[0];
$lang = $lang_vals[2];
// EN RUS UA

$error = '';
$success = "0";

$SESSION_NAME = !empty($_COOKIE['nxsession']) ? $_COOKIE['nxsession'] : false;
if ($SESSION_NAME) {
    session_name($SESSION_NAME);
} else {
    $SESSION_NAME = session_name();
    setcookie('nxsession', $SESSION_NAME, time() + (86400 * 7), '/');
}
session_start();

$errors_list = array('1' => 'Каптча введена не верно');

$titles = array(
    '1' => array(
        '1'  => 'Компания',
        '2'  => 'Номер регистрации компании',
        '3'  => 'Направление деятельности',
        '4'  => 'Адрес',
        '5'  => 'Адрес',
        '6'  => 'Адрес',
        '7'  => 'Город',
        '8'  => 'Область/Штат',
        '9'  => 'Почтовый индекс',
        '10' => 'Страна',
        '11' => 'Электронная почта',
        '12' => 'Телефон',
        '13' => 'Язык коммуникации',
        '14' => 'Количество сотрудников, которые совершают авиаперелеты',
        '15' => 'Предыдущий календарный год',
        '16' => 'Текущий календарный год',
    ),
    '2' => array(
        '1'  => 'Обращение',
        '2'  => 'Имя',
        '3'  => 'Отчество',
        '4'  => 'Фамилия',
        '5'  => 'Дата рождения',
        '6'  => 'Должность',
        '7'  => 'Электронная почта',
        '8'  => 'Телефон',
        '9'  => 'Мобильный телефон',
        '10' => 'Рабочий телефон',
        '11' => 'Город',
        '12' => 'Страна',
    ),
    '3' => array(
        '1' => 'Название агентства',
        '2' => 'Номер IATA',
        '3' => 'Электронная почта',
        '4' => 'Телефон',
        '5' => 'Мобильный телефон',
        '6' => 'Рабочий телефон',
        '7' => 'Город',
        '8' => 'Страна',
    ),
    '4' => array(
        '1' => 'Получать новости и акции МАУ и программы Панорама Клуб на электронную почту',
        '2' => 'Получать новости и специальные предложения партнеров программы Панорама Клуб на электронную почту',
        '3' => "Получать подтверждение о начислении/списании миль на электронную почту",
        '4' => 'Получать баланс на электронную почту',
        '5' => 'Получать новости и акции МАУ и программы Панорама Клуб по SMS',
    )
);


$section_names = array(
    '1' => 'Информация о Компании',
    '2' => 'Администратор',
    '3' => 'Агенство',
    '4' => 'Подписка на новости',
);

$glues = array();
$glues['2']['5'] = '/';


$form = (isset($_REQUEST['form'])) ? $_REQUEST['form'] : false;

if ($form) {
    if ($error === '') {

        require_once "mysql.class";
        $con = new mysql_connector();
        $conid = $con->connect();

        $db_fields = array();
        $db_values = array();


        $content = '';
        foreach ($form as $s_key => $section) {

            $content .= '<tr><td colspan="2"><b>' . $section_names[$s_key] . '</b></td></tr>';
            foreach ($section as $r_key => $row) {
//DB
                if (is_array($row)) {
                    foreach ($row as $mr_key => $srow) {
                        if (!empty($srow)) {
                            $db_fields[] = '`val_' . $s_key . '_' . $r_key . '_' . $mr_key . '`';
                            $db_values[] = "'" . $srow . "'";
                        }
                    }

                } else {
                    if (!empty($row)) {
                        $db_fields[] = '`val_' . $s_key . '_' . $r_key . '`';
                        $db_values[] = "'" . $row . "'";
                    }
                }

                if (is_array($row)) {
                    $glue = (isset($glues[$s_key][$r_key])) ? $glues[$s_key][$r_key] : '-';
                    $row = implode($glue, $row);
                }
                if ($row == 'on') {
                    $row = 'Да';
                }
                $prefix = '';
                if ($s_key == 1 && $r_key == 15) {
                    $prefix = '<tr><td colspan="2">Бюджет Компании на авиаперелеты, доллары США:</td></tr>';
                }

                $content .= $prefix . '<tr><td>' . $titles[$s_key][$r_key] . '</td><td>' . $row . '</td></tr>';


            }
        }
        $content = '<table border="1"><tbody><tr><td>Страна</td><td>' . $c . '</td></tr><tr><td>Язык</td><td>' . $lang . '</td></tr>' . $content . '</tbody></table>';


        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers_template = "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers_template .= "MIME-Version: 1.0" . "\r\n";

        // Дополнительные заголовки
        $headers_template .= "To: Admin <%s>" . "\r\n";
        $headers_template .= "From: MAU <no-reply@flyuia.com>" . "\r\n";

        $content = iconv(mb_detect_encoding($content), "UTF-8", $content);

        //mail('akravchenko@lemon.ua', 'PC registration', $content, sprintf($headers_template, 'akravchenko@lemon.ua'));
        //mail('Myronova.Svitlana@flyuia.com', 'PC registration', $content, sprintf($headers_template, 'Myronova.Svitlana@flyuia.com'));
        //mail('Levchenko.Anna@flyuia.com', 'PC registration', $content, sprintf($headers_template, 'Levchenko.Anna@flyuia.com'));
        require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'autoload.php';
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('no-reply@flyuia.com', 'MAU');
        $mail->addAddress('panorama.corporate@flyuia.com', '');
        $mail->isHTML(true);
        $mail->Subject = 'PC registration';
        $mail->Body = $content;
        $mail->send();

        $query = "INSERT INTO `pc_registration` (" . implode(', ', $db_fields) . ") VALUES (" . implode(', ', $db_values) . ")";
        $res = $con->query($query, $conid);


        $r_id = mysql_insert_id();

        if (isset($_POST["rules_agree"])) {
            $rules_agree = $_POST["rules_agree"];
        } else {
            $rules_agree = "";
        }

        if ($lang == "RUS") {
            $_lang = "ru";
        } else if ($lang == "EN") {
            $_lang = "en";
        } else if ($lang == "UA") {
            $_lang = "ua";
        } else {
            $_lang = "0";
        }

        $_reg = ($rules_agree == "on") ? 1 : 0;
        $query = "INSERT INTO `test_pc_registration_log` (`reg_id`, `name`, `status`, `lang`) VALUES ($r_id, $db_values[0], $_reg, '$_lang')";
        $res = $con->query($query, $conid);

//Отправка пользователю email об успешной регистрации

        foreach ($db_fields as $key => $value) {
            if ($value == "`val_2_7`") {
                $mail_to = trim(str_replace("'", "", $db_values[$key]));
            }
        }

        if ($lang == "RUS") {
            $mail_content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/forms/reg_mail_templates/Autoreply_RUS.html");
            $mail_theme = "Регистрация в программе Panorama Club CORPORATE";
        } else if ($lang == "EN") {
            $mail_content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/forms/reg_mail_templates/Autoreply_ENG.html");
            $mail_theme = "Panorama Club CORPORATE Application form";
        } else if ($lang == "UA") {
            $mail_content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/forms/reg_mail_templates/Autoreply_UKR.html");
            $mail_theme = "Реєстрація в програмі Panorama Club CORPORATE";
        }


        //echo "<!--";
        //echo $mail_to;
        //var_dump($db_fields);
        //var_dump($db_values);
        //echo "-->";

        $reg_headers_template = "MIME-Version: 1.0" . "\r\n";
        $reg_headers_template .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $reg_headers_template .= "From: MAU <no-reply@flyuia.com>" . "\r\n";

        list($user, $domain) = explode("@", $mail_to, 2);
        if (checkdnsrr($domain, "MX") && checkdnsrr($domain, "A")) {
            mail($mail_to, '=?utf-8?B?' . base64_encode($mail_theme) . '?=', $mail_content, $reg_headers_template);
        }

        $success = "1";
        //$output = 'Success';
    }

}

if ($lang == 'RUS') {
    $output = $modx->parseChunk('pc_registration_form_rus', array('error'   => $error,
                                                                  'success' => $success), '[+', '+]');
} else if ($lang == 'EN') {
    $output = $modx->parseChunk('pc_registration_form_eng', array('error'   => $error,
                                                                  'success' => $success), '[+', '+]');
} else {
    $output = $modx->parseChunk('pc_registration_form_ukr', array('error'   => $error,
                                                                  'success' => $success), '[+', '+]');
}
return $output;
?>