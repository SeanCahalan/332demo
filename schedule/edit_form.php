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
    <label id="startTime"> Start Time:</label><br />
    <input type="text" name="startTime" <?php echo 'value="' . $current_start . '"' ?>><br />

    <label id="endTime">End Time:</label><br />
    <input type="text" name="endTime" <?php echo 'value="' . $current_end . '"' ?>><br />

    <label id="room">Room Number:</label><br />
    <input type="text" name="room" <?php echo 'value="' . $current_room . '"' ?>><br />
</div> 