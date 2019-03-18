<?php
    require_once('../util/PrintTable.php');

    $servername = "localhost";
    $username = "root";
    $dbname = "conference";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from student)"); 
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        printTable($stmt);
    
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from professional)"); 
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        printTable($stmt);
    
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from sponsor)"); 
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        printTable($stmt);
    
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


    $conn = null;
?>