<?php
header('Content-Type: application/json');


$file = "patients.json";

if(file_exists($file)){
    $jsonReturn = [];
    $arquivo = file_get_contents($file);
    $dataBase = json_decode($arquivo, true);
    foreach($dataBase as $patients){
        $patient = $patients['patient'];
            $jsonReturn[]= [
                "name" => $patient["name"],
                "email" => $patient["email"],
                "phone" => $patient["phone"],
                "notes" => $patient["notes"]." ".$patient["id"]
            ];
    };
    echo json_encode($jsonReturn);
}else{
    echo json_encode([
        "error" => true,
        "message" => "Nenhum paciente registrado"
    ]);
}
?>