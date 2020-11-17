<?php
require_once ("connect_db.php");

$query = "select email, password from table_auth";
$result = $pdo->query($query);

if(isset($_POST['mail']))
{
    $flag = false;
    while($auth = $result->fetch())
    {
        if($auth['email'] == $_POST['mail']){
            $flag = true;
        }
    }
    if($flag){
        echo "Пользователь зарегистрирован";
    }else{
        echo "Пользователь не зарегистрирован";
    }
}