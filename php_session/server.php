<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();


if(!isset($_SESSION['register'])){
    $_SESSION['register']=0;
}
//もし$_SESSION['register']に値がセットされてなかったら0を代入(初期化)

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $ret=calc($postData);  
    echo $ret;
}else{
    echo 'error';
}


function calc($postData){
    $op = null;
    $num = null;
    $register = $_SESSION['register'];

    if(is_numeric($postData[0])){
        $op = '=';
        $num = intval($postData);
    }else{
        $op = substr($postData,0,1);
        $num =intval(substr($postData, 1));
    }
    switch($op){
        case '=';
            $_SESSION['register'] = $num;
            break;
        case '+':
            $_SESSION['register'] = $register + $num;
            break;
        case '-':
            $_SESSION['register'] = $register - $num;
            break;
        case '*':
            $_SESSION['register'] = $register * $num;
            break;
        case '/':
            if($num === 0){
                throw new Exception ('0 divide');
            }
            $_SESSION['register'] /= $register / $num;
            $_SESSION['register'] = floor($_SESSION['register']);
            break;
        default:
            throw new Exception ('invalid operator');
    }
    // $_SESSION['register'] = $register;
    // return intval($_SESSION['register']);
    $result = intval($_SESSION['register']);

    return $result;

    echo $_SESSION['register'];
}




//php -S localhost:8000 server.php

//url -X POST -d "文字列" http://localhost:8000