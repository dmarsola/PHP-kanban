<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Tasks - Kan Ban</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0, user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>


<body>

<h2>Task Manager</h2>

<?php

require_once("functions.inc");
$id=""; $dTitle=""; $description=""; $dateCreated=""; $dateUpdated=""; $status="";

$tasksFromFile = getTasks();

$displayForm = (isset($_GET['dispForm']))? $_GET['dispForm'] : FALSE;
$taskSaved = FALSE;
require_once("functions.inc");


if(isset($_GET['id'])) {
    $tasksFromFile = getTasks();
    $displayForm = TRUE;
    $id = $_GET["id"];
    foreach($tasksFromFile as $task){
        if ($task['id'] == $id){
            $id = $task['id'];
            $dTitle = $task['title'];
            $description = $task['description'];
            $status = $task['status'];
            $dateCreated = $task['created'];
            $dateUpdated = $task['updated'];
            break;
        }
    }
    echo "The status in the get is: " . $status;
}

if (isset($_POST["submit"])){
    echo "Does it go into post as well??";
    $id = (empty($_POST["id"])) ? getNewID() : $_POST["id"];
    $taskSaved = TRUE;
    $dTitle = $_POST["dTitle"];
    $description = $_POST["description"];
    $dateUpdated = date("F j, Y");
    $dateCreated = (empty($_POST["dateCreated"])) ? $dateUpdated : $_POST["dateCreated"];
    $status = $_POST["status"];

    $tempArr = array();
    $tempArr['id'] = $id;
    $tempArr['title'] = $dTitle;
    $tempArr['description'] = $description;
    $tempArr['created'] = $dateCreated;
    $tempArr['updated'] = $dateUpdated;
    $tempArr['status'] = $status;

    if(empty($_POST["id"])) {
        addTask($tempArr);
    } else {
        updateTask($id, $tempArr);
    }
}


if ($displayForm) {
    ?>
    <form id="dForm" name="dForm" method="POST" action="./index.php">
        <input type="hidden" name="id" value="<?php echo $id?>">
        <input type="hidden" name="dateCreated" value="<?php echo $dateCreated?>">

        <label for="dTitle"> Task Title: </label>
        <input type="text" name="dTitle" id="dTitle" value="<?php echo $dTitle; ?>" maxlength="40"/>

        <label for="description"> Description: </label>
        <input type="text" name="description" id="description" value="<?php echo $description; ?>" maxlength="140"/>

        <label for="status"> Task Status: </label>
        <select name="status" id="status">
            <?php
            if ($status){
                if ($status == "todo"){
                    echo '<option value="todo" selected>To Do</option>';
                    echo '<option value="indev">In Development</option>';
                } else if ($status == "indev"){
                    echo '<option value="indev" selected>In Development</option>';
                    echo '<option value="intest">In Test</option>';
                } else if ($status == "intest"){
                    echo '<option value="indev">In Development</option>';
                    echo '<option value="intest" selected>In Test</option>';
                    echo '<option value="complete">Complete</option>';
                } else if ($status == "complete"){
                    ?>
                    <option value="complete" selected disabled>Complete</option>
                    <?php
                }
            } else {
            ?>
                <option value="todo" selected>To Do</option>
            <?php


            }
            ?>

        </select>
        <div></div>
        <input type="submit" name="submit" id="submit" value="SAVE" />
        <div></div><a href="./index.php">Cancel</a>
    </form>


    <?php
} else {
    ?>
    <a href="./index.php?dispForm=true" class="newTask noDecoration"><i class="fas fa-plus-circle"></i> Add New Task</a>
<?php
}

if ($taskSaved) {
    ?>
    <h3 class="saved"><i class="fas fa-check"></i> Task saved! Now go get work done.</h3>
    <?php
}
?>
<h3 class="center pad">Current Tasks</h3>
<main>

    <?php
    $tasksFromFile = getTasks();
    if ($tasksFromFile){
        foreach($tasksFromFile as $task){
            ?>
            <div class="task <?php echo $task['status']?>">
                <a href="./index.php?id=<?php echo $task['id'] ?>" class="noDecoration"><i class="far fa-edit"></i></a>
                <h3 class="title center pad"><?php echo $task['title']?></h3>
                <p><?php echo $task['description']?></p>
                <p>Status: <?php echo getStatus($task['status'])?></p>
                <p class="smaller">Created: <?php echo $task['created']?><br />
                    Updated: <?php echo $task['updated']?></p>
            </div>
            <?php
        }
    }

    ?>

</main>

<footer><p>All rights reserved dMarsola.</p></footer>
</body>
</html>


