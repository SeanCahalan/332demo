<?php
    require_once('../util/PrintTable.php');
    include '../util/DBController.php';
    $db_handle = new DBController();

    try {
        $sql = "SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from student)";
        $result = $db_handle->runQuery($sql);
        printTable($result);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        $sql = "SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from professional)";
        $result = $db_handle->runQuery($sql);
        printTable($result);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        $sql = "SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from sponsor)";
        $result = $db_handle->runQuery($sql);
        printTable($result);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


    $conn = null;
?>