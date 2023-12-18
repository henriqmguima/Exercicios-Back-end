<?php
require "patients.php";

$response = [];
$error = [];
if(isset($_GET["id"])){
    $id = $_GET["id"];
    foreach ($patients as $patient){
        if($id == $patient["id"]){
            $response = [
                "name" => $patient["name"],
                "idade" => RetornaIdade($patient["birth"]),
                "weight" => $patient["weight"],
                "height" => $patient["height"]/100
            ];
        }
    }
    if($response == null){
        $error["error"] = true;
        $error["message"] = "Paciente não encontrado";
        echo json_encode($error);
    }else {
        echo json_encode($response);
    }
}else{
    foreach ($patients as $patient){
        $response = $patients;
    }
    echo json_encode($response);
}

function RetornaIdade($dataNasc){
    if(isset($dataNasc)){
        $dataNasc = new DateTime($dataNasc);
        $hoje = new DateTime();
        $idade = $hoje ->diff($dataNasc);
    }else{
        $idade = null;
    }
    return $idade->y;
}


?>