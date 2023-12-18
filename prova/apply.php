<?php

require "users.php";
require "applications.php";
if(isset($_POST["email"]) && isset($_POST["password"])){
    $email = $_POST["email"];
    $senha = $_POST["password"];
    $job = $_POST["jobs"];
    
    $idUser = returnId($email, $users);
    if(findUser($email, $users)){
        if(findPass($email, $senha, $users)){
            if(doApply($idUser, $applications, $job)){
                echo json_encode([
                    "status" => "error",
                    "message" => "Usuário já se candidatou a esta vaga"
                ]);
            }else{
                echo json_encode([
                    "status" => "sucess",
                    "message" => "Candidatura realizada com sucesso"
                ]);
            }
        }else{
            echo json_encode([
                "status"=> "error",
                "message"=> "Senha incorreta"
            ]);
        }
    }else{
        echo json_encode([
            "status"=> "error",
            "message"=> "Usuário não encontrado"
        ]);
    }
}else{
    echo json_encode([
        "status"=> "error",
        "message"=> "Um mais campos vazios"
    ]);
}

function findPass($email, $senha, $users){
    foreach($users as $user){
        if($user["email"] == $email){
            $hash = $user["password"];
            if(password_verify($senha, $hash)){
                return true;
            }else{
                return false;
            }
        }
    }
    return false;
}
function findUser($email, $users){
    foreach($users as $user){
        if($user["email"] == $email){
            return true;
        }
    }
    return false;
}
function returnId($email, $users){
    foreach($users as $user){
        if($user["email"] == $email){
            $id = $user["id"];
            return $id;
        }
    }
    return null;
}

function doApply($id, $applications, $job){
    foreach($applications as $application){
        if($application["user"]==$id){
            $idJob=$application["job"];
            if($idJob == $job){
                return true;
            }
        }
    }
    return false;
}