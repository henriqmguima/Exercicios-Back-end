<?php

require "jobs.php";
$response = [];
foreach($jobs as $job){
    $response[] = $job;
}
echo json_encode([
    "status" => "sucess",
    "message" => "lista de vagas",
    "jobs" => $response
]);
