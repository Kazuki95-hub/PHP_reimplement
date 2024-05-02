<?php

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
    $register = intval(file_get_contents('register.txt'));
    // file_put_contents('register.txt','');
    if(is_numeric($postData[0])){
        $op = '=';
        $num = intval($postData);
    }else{
        $op = substr($postData,0,1);//演算子が文字列かと思ったら数値だった
        $num = intval(substr($postData, 1));
    }

    switch($op){
        case '=':
            $register = $num;
            break;
        case '+':
            $register += $num;
            break;
        case '-':
            $register -= $num;
            break;
        case '*':
            $register *= $num;
            break;
        case '/':
            if($num === 0){
                throw new Exception ('0 divide');
            }
            $register /= $num;
            $register = floor($register);
            break;
        default:
            throw new Exception ('invalid operator');
    }
    // if($op !== '='){
        file_put_contents('register.txt',$register);
    // }

    return $register;
    
}

function register_reset(){
    file_put_contents('register.txt','0');
}



//php -r "include 'server2.php'; register_reset();"

//php -S localhost:8000 server.php

//curl -X POST -d "文字列" http://localhost:8000