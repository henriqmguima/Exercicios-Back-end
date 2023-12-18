<?php
session_start();

$emailUser = $_SESSION['email'];
$nameUser = $_SESSION['username'];
$fileS= "users.json";
$dataJson = readFiles($fileS);
if(isset($_SESSION['username']) && isset($_SESSION['email'])){
    if(findUser($dataJson, $emailUser)){
    echo json_encode([
        "status"=> 200,
        "message"=> "Usuário logado",
        "user"=> [
            "name"=> $nameUser,
            "email"=> $emailUser
        ]
    ]);
    }
    else{
    echo json_encode([
        "error" => true,
        "status" => 401,
        "message" => "Usuário não logado"
    ]);
    }
}else{
    echo json_encode([
        "error" => true,
        "status" => 401,
        "message" => "Usuário não logado"
    ]);
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
?>
