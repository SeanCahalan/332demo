<?php
$servername = "localhost";
$username = "root";
$dbname = "conference";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // try transactions for touching multiple tables

    $attendeeType = "professional";
    if(isset($_POST["company"])){
        $attendeeType = "sponsor";
    } elseif(isset($_POST["room"])){
        $attendeeType = "student";
    }

    $price = 0;
    if($attendeeType == "student"){
        $price = 50;
    } elseif($attendeeType == "professional"){
        $price = 100;
    }

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];

    try{
        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO attendee (fname, lname, price) 
            VALUES (:fname, :lname, :price)");
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':price', $price);
        $stmt->execute();

        $id = $conn->lastInsertId();

        if($attendeeType == "sponsor"){
            $stmt = $conn->prepare("INSERT INTO sponsor VALUES ($id, :company)");
            $stmt->bindParam(':company', $_POST["company"]);
            $stmt->execute();
        } elseif($attendeeType == "student"){
            $room = $_POST["room"];
            if(!is_numeric($room)) $room = NULL;
            $stmt = $conn->prepare("INSERT INTO student VALUES ($id, :room)");
            $stmt->bindParam(':room', $room);
            $stmt->execute();
            if(is_numeric($room)){
                $stmt = $conn->prepare("UPDATE hotel_rooms
                    SET beds = beds + 1
                    WHERE room_number = $room");
                $stmt->execute();
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO professional VALUES ($id)");
            $stmt->execute();
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }

    echo "New records created successfully. ";
    echo $_POST['fname'] . " was added."; 
    
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
<div><a <?php echo 'href="/332demo/attendee/attendee.php?sort=' . $attendeeType .'"'; ?> >
    <?php echo "View " . $attendeeType . " table" ?>
</a></div>