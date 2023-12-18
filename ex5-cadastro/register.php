<?php
$file = "patients.json";
if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["notes"])){
    // botei a leitura do arquivo nessa função, desta forma funciona existindo o arquivo json ou não.
    $dataPatients = readFiles($file);
    if(patientExistent($dataPatients, $_POST["email"])){
        // aqui vc devolve a resposta e encerra
        echo json_encode([
            "error" => true,
            "message" => "Email já cadastrado"
        ]);
        exit;
    }else{
        $id = idPatients($dataPatients);
        // cria o novo paciente
        $newPatient = [
            'id' => $id,
            'name' => $_POST["name"],
            'phone' => $_POST["phone"],
            'email' => $_POST["email"],
            'notes' => $_POST["notes"]
        ];
        // devolve a resposta
        echo json_encode([
            "message" => "Paciente cadastrado com sucesso",
            "patient" => $newPatient
        ]);
        // insere o novo paciente como um novo elemente do array dataPatients
        $dataPatients[] = $newPatient;
        $jsonUpdate = json_encode($dataPatients);
        file_put_contents($file, $jsonUpdate);
    }
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
// função que lê o arquivo e devolve um array
// vazio caso o arquivo nao exista, ou o conteúdo do arquivo convertido no array.
function readFiles($file) {
    $content = [];
    if (file_exists($file)) {
        $content = json_decode(file_get_contents($file), true);
    }
    return $content;
}
?>