<?php

//переписываем данные из файла в массив (в файле почты и пароли через пробел, каждая пара с новой строки)
$lines = file('login.txt', FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
//создаем массив в который будем переписывать из $lines по принципу - $auth[почта] = пароль (см. ассоциативные массивы PHP)
$auth = [];

//Проходимся по массиву lines
foreach ($lines as $line) {
    //создается список из двух переменных, строка делится на две через пробел, то что слева от пробела в логин, что справа в пароль
    list($login, $password) = explode(" ", $line);
    $auth[$login] = $password;
}

//AJAX
if(isset($_POST['mail']))
{
    file_put_contents('login.txt', PHP_EOL . $_POST['mail'], FILE_APPEND);
    $flag = false;
    foreach ($auth as $key=>$value)
        {
            if($key == $_POST['mail']){
                $flag = true;
            }
        }
    if($flag){
        echo "Пользователь зарегистрирован";
    }else{
        echo "Пользователь не зарегистрирован";
    }
}