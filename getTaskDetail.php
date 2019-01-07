<?php
/**
 * Created by PhpStorm.
 * User: douglasmarsola
 * Date: 2018-11-30
 * Time: 7:54 AM
 */

require_once('functions.inc');

$taskID = "";

if (isset($_POST["id"])) $taskID = $_POST["id"];
if (isset($_GET["id"])) $taskID = $_GET["id"];

if ($taskID){
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(getTaskByID($taskID));
}


//3. Return details. Create a PHP file called getTaskDetail.php which returns all the information about a single
// (requested) task from the list. This php program has one parameter passed through either a get or post which
// is the id of the task to return. It returns all the information about the task.