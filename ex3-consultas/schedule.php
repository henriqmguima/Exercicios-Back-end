<?php
header("Content-Type: application/json");

require "doctors.php";
require "patients.php";
require "appointments.php";
$response = [];
if(isset($_GET["doctors"])){
    foreach($doctors as $doctor){
        $response[] = [
            "id" => $doctor["id"],
            "name" => $doctor["name"]
        ];
    }
    echo json_encode($response);
}else{
    $nomePaciente = $_POST["patient-name"];
    $doctorId = $_POST["doctor-id"];
    $dataConsulta = $_POST["appointment-date"];
    $horaConsulta = $_POST["appointment-time"];
    $obsConsulta = $_POST["appointment-notes"];
    $dataeHora = $dataConsulta." ".$horaConsulta;
    if(medicoDisponivel($doctorId, $dataeHora) == 0 && findPaciente($nomePaciente)>0){
        $response[] = [
            "message" => "Consulta marcada com sucesso",
            "appointment" => [
                "nomeP" => $nomePaciente,
                "nomeM" => nomeMedico($doctorId),
                "data" => $dataConsulta,
                "hora" => $horaConsulta,
                "obs" => $obsConsulta
            ]
        ];
    }else if(findPaciente($nomePaciente)==0){
        $response[] = [
            "message" => "Paciente não encontrado",
            "error" => true
        ];
    }else{
        $response[] = [
            "message" => "Médico não disponível na data e hora informados",
            "error" => true
        ];
    }
    echo json_encode($response);

}

function medicoDisponivel($id, $data){
    global $appointments;
    foreach($appointments as $appointment){
        if($id == $appointment["doctor_id"]){
            if($appointment["times"] == $data){
                return -1;
            }
        }
    }
    return 0;
}
function nomeMedico($id){
    global $doctors;
    foreach($doctors as $doctor){
        if($id == $doctor["id"]){
            return $doctor["name"];
        }
    }
}
function findPaciente($nome){
    global $patients;
    foreach($patients as $patient){
        if($patient["name"] == $nome){
            return 1;
        }
    }
    return 0;
}
?>