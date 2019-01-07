<?php
/**
 * Created by PhpStorm.
 * User: douglasmarsola
 * Date: 2018-11-30
 * Time: 7:54 AM
 */

require_once('functions.inc');

$taskStatus = "";
$tasks = array();

if (isset($_POST["status"])) $taskStatus = $_POST["status"];
if (isset($_GET["status"])) $taskStatus = $_GET["status"];

$tasks = ($taskStatus == 'all') ? getTasks() : getTasksByStatus($taskStatus);
$response = array();

foreach ($tasks as $task){
    $temp['id'] = $task['id'];
    $temp['title'] = $task['title'];
    $temp['updated'] = $task['updated'];
    $temp['status'] = $task['status'];
    array_push($response, $temp);
}

//http_response_code(200);
header('Content-Type: application/json');
echo json_encode($response);