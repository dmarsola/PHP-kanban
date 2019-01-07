<?php

define("FILE","./task/tasks.json");

function getNewID(){
    $idNum = file_get_contents("./currID.txt");
    file_put_contents("./currID.txt", $idNum+1);
    return $idNum;
}

function getStatus($status) {
    switch ($status){
        case 'todo':
            return 'To do';
            break;
        case 'indev':
            return 'In development';
            break;
        case 'intest':
            return 'In test';
            break;
        case 'complete':
            return 'Complete';
            break;
        default:
            return 'Unknown';
    }
}

function getTasks() {
    return (file_exists(FILE))?
        json_decode(file_get_contents(FILE), true)
        : array();
}


function getTasksByStatus($taskStatus) {
    $temp = array();
    foreach(getTasks() as $task){
        if ($task['status'] == $taskStatus){
            array_push($temp, $task);
        }
    }
    return $temp;
}

function getTaskByID($id) {
    $temp = array();
    foreach(getTasks() as $task){
        if ($task['id'] == $id){
            array_push($temp, $task);
            return $temp;
        }
    }
    return null;
}

function removeTask($num) {
    $temp = array();
    foreach(getTasks() as $task){
        if ($task['id'] != $num){
            array_push($temp, $task);
        }
    }
    saveJSONFile($temp);
}

function updateTask($num, $info) {
    removeTask($num);
    addTask($info);
}

function addTask($info) {
    $temp = getTasks();
    array_unshift($temp, $info);
    saveJSONFile($temp);
}

function saveJSONFile($content) {
    file_put_contents(FILE, json_encode(sortTasks($content)));
}

function sortTasks($content) {
    $temp = array();
    foreach ($content as $el)
        if ($el['status'] == 'todo')
            array_push($temp, $el);
    foreach ($content as $el)
        if ($el['status'] == 'indev')
            array_push($temp, $el);
    foreach ($content as $el)
        if ($el['status'] == 'intest')
            array_push($temp, $el);
    foreach ($content as $el)
        if ($el['status'] == 'complete')
            array_push($temp, $el);
    return $temp;
}













