<?php
require_once "connect_db.php";

$query = "select email, password from table_auth";
$result = $pdo->query($query);

//Проверка содержат ли поля ввода данные, а не пустые строки
if(!empty($_POST["email"]) && !empty($_POST["password"]))
{
    //проверка нажата ли галочка (см. суперглобальные массивы PHP)
    if(isset($_REQUEST["check"]))
    {
        $flag = false;
        //проходимся по auth и разбиваем каждый его элемент на пару ключ(емеил)-значение(пароль)
        while($auth = $result->fetch())
        {
            if($auth['email'] == $_POST['email']){
                include "index.html";
                include "same_user.html";
                $flag = true;
            }
        }
        //если такой почты нет, то записываем эту пару в фаил с новой строки и выводим шаблон success.html
        if($flag == false){
            $query_insert = "insert into table_auth (email, password) VALUES ('{$_POST['email']}', '{$_POST['password']}')";
            $insert = $pdo->exec($query_insert);
            if ($insert !== false){
                include "success.html";
            }
            else{
                echo "Не удалось сделать запись в базу данных";
                echo "<pre>";
                print_r($pdo->errorInfo());
                echo "</pre>";
            }
        }
    }
    //если галочка не нажата, дальше должно быть понятно исходя из комментариев выше.
    else{
        $flag = false;
        while($auth = $result->fetch())
        {
            if($auth['email'] == $_POST['email'] && $auth['password'] == $_POST['password']){
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



