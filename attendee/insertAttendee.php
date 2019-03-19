<?php
$servername = "localhost";
$username = "root";
$dbname = "conference";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO attendee (fname, lname, price) 
    VALUES (:fname, :lname, :price)");
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':price', $price);

// insert a row
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $price = $_POST["price"];
    $stmt->execute();

    $id = $conn->lastInsertId();
    if(isset($_POST["company"])){
        print("sponsor");
        $stmt = $conn->prepare("INSERT INTO sponsor VALUES ($id, :company)");
        $stmt->bindParam(':company', $_POST["company"]);
    } elseif(isset($_POST["room"])){
        print("student");
        $room = $_POST["room"];
        if(!is_numeric($room)){
            $room = NULL;
        }
        $stmt = $conn->prepare("INSERT INTO student VALUES ($id, $room)");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE hotel_rooms
        SET beds = beds + 1
        WHERE room_number = $room");
    } else {
        print("professional");
        $stmt = $conn->prepare("INSERT INTO professional VALUES ($id)");
    }

    $stmt->execute();

    echo "New records created successfully. ";
    echo $_POST['fname'] . " was added."; 
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>