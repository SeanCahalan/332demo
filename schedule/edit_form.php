<?php 
session_start();

$room = 0;
$startTime = "na";
$endTime = "na";

if (isset($_POST['room'])) {
    $current_room = $_POST['room'];
}

if (isset($_POST['start_time'])) {
    $current_start = $_POST['start_time'];
}

if (isset($_POST['end_time'])) {
    $current_end = $_POST['end_time'];
}

$_SESSION['current_room'] = $current_room;
$_SESSION['current_start'] = $current_start;

?>

<div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Start time</span>
        </div>
        <input type="text" class="form-control" name="startTime" <?php echo 'value="' . $current_start . '"' ?>>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">End time</span>
        </div>
        <input type="text" class="form-control" name="endTime" <?php echo 'value="' . $current_end . '"' ?>>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Room number</span>
        </div>
        <input type="text" class="form-control" name="room" <?php echo 'value="' . $current_room . '"' ?>>
    </div>
</div> 