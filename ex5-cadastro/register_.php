<?php
$response = [];
$file = "patients.json";
if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["notes"])){
    $dataPatients = json_decode(file_get_contents($file), true);
    if(patientExistent($dataPatients, $_POST["email"])){
        $response[]=[
            "error" => true,
            "message" => "Email já cadastrado"
        ];
    }else{
        $id = idPatients($dataPatients);
        $response[] = [
            "message" => "Paciente cadastrado com sucesso",
            "patient" => [
                'id' => $id,
                'name' => $_POST["name"],
                'phone' => $_POST["phone"],
                'email' => $_POST["email"],
                'notes' => $_POST["notes"]
            ]
        ];
    }
    echo json_encode([
        "error" => false,
        "message" => "Paciente cadastrado com sucesso"
    ]);
    if(idPatients($dataPatients)==1){
        $dataPatients[]=$response;
    }else{
        $dataPatients[]=", /n".$response;
    }
    $jsonUpdate = json_encode($dataPatients);
    file_put_contents($file, $jsonUpdate);
}else{
    echo json_encode([
        "error" => true,
        "message" => "Não implementado"
    ]);
}

function patientExistent($json, $email){
    if(isset($json)){
        foreach($json as $patient){
            if($patient["email"] == $email){
                return true;
            }
        }
    }
    return false;
}
function idPatients($json){
    $id = 1;
    if(isset($json)){
        foreach($json as $patient){
            if($patient["id"]==$id){
                $id++;
            }
        }
    } 
    return $id;
}
?>