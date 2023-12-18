<?php

session_start();

$file = "users.json";
$email = $_POST["email"];
$senha = $_POST["password"];
if(!empty($email) && !empty($senha)){
    $jsonData = readFiles($file);
    if(findUser($jsonData, $email)){
        if(verifyPass($jsonData,$senha, $email)){
            $name = returnName($jsonData, $email);
            $_SESSION['username'] = $name;
            $_SESSION['email'] = $email;
            echo json_encode([
                "status"=> 200,
                "message"=> "Login efetuado com sucesso"
                ]);
        }else{
            echo json_encode([
                "error"=> true,
                "status"=> 401,
                "message"=> "Senha incorreta",
            ]);
        }
    }else{
        echo json_encode([
            "error"=> true,
            "status"=> 401,
            "message"=> "Usuário não encontrado"
        ]);
        exit;
    }
}else{
    echo json_encode([
        "error" => true,
        "message" => "Não preenchido todos os campos"
    ]);
    exit;
}

function readFiles($file) {
    $content = [];
    if (file_exists($file)) {
        $content = json_decode(file_get_contents($file), true);
    }
    return $content;
}
function findUser($jsonData, $email){
    foreach ($jsonData as $user){
        if($email == $user["email"]){
            return true;
        }
    }
    return false;
}
function verifyPass($jsonData,$senha, $email){
    foreach($jsonData as $user){
        if($email == $user["email"]){
            $hash = $user["password"];
            if(password_verify($senha, $hash)){
                return true;
            }else{
                return false;
            }
        }
    }
}
function returnName($jsonData, $email){
    foreach($jsonData as $user){
        if($email == $user["email"]){
            $name = $user["email"];
                return $name;
        }
    }
}
?>