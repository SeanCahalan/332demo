<!DOCTYPE html>
<html>
    <head>
        <title>332 Conference DB</title>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"/> -->

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="/332demo/css/style.css" />
    </head>
    <body>
        <div id="tabs">
            <ul>
                <li><a href="/332demo/info/info.php">Info</a></li>
                <li><a href="/332demo/committee/committee.php">Committees</a></li>
                <li class="active"><a href="/332demo/attendee/attendee.php">Attendees</a></li>
                <li><a href="/332demo/sponsor/sponsor.php">Sponsors</a></li>
                <li><a href="/332demo/schedule/schedule.php">Schedule</a></li>
            </ul>
        </div>

        <div class="content">


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
                    SET occupants = occupants + 1
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

</div>
</body>
</html>