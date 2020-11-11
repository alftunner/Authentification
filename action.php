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

//Проверка содержат ли поля ввода данные, а не пустые строки
if(!empty($_POST["email"]) && !empty($_POST["password"]))
{
    //проверка нажата ли галочка (см. суперглобальные массивы PHP)
    if(isset($_REQUEST["check"]))
    {
        $flag = false;
        //проходимся по auth и разбиваем каждый его элемент на пару ключ(емеил)-значение(пароль)
        foreach ($auth as $key=>$value)
        {
            //если такая почта есть, выводим шаблоны index.html и same_user.html
            if($key == $_POST['email']){
                include "index.html";
                include "same_user.html";
                $flag = true;
            }
        }
        //если такой почты нет, то записываем эту пару в фаил с новой строки и выводим шаблон success.html
        if($flag == false){
            $buffer = "{$_POST['email']} {$_POST['password']}";
            file_put_contents('login.txt', PHP_EOL . $buffer, FILE_APPEND);
            include "success.html";
        }
    }
    //если галочка не нажата, дальше должно быть понятно исходя из комментариев выше.
    else{
        $flag = false;
        foreach ($auth as $key=>$value)
        {
            if($key == $_POST['email'] && $value == $_POST['password']){
                include "success_auth.html";
                $flag = true;
            }
        }
        if($flag == false){
            include "index.html";
            include "bad_auth.html";
        }
    }
}
else{
    include "index.html";
    include "bad_auth.html";
}



