<!DOCTYPE html>
<html>

<body>
    <div>
        <?php
        $servername = "localhost";
        $username = "root";
        $dbname = "conference";

        session_start();
        $currentRoom = $_SESSION['current_room'];
        $currentStart = $_SESSION['current_start'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $room = $_POST['room'];
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
            $conn->beginTransaction();
            $stmt = $conn->prepare(
                "UPDATE session
                SET room = :room, start_time = :startTime, end_time = :endTime
                WHERE room = :currentRoom AND start_time = :currentStart"
            );
            $stmt->bindParam(':room', $room);
            $stmt->bindParam(':startTime', $startTime);
            $stmt->bindParam(':endTime', $endTime);
            $stmt->bindParam(':currentRoom', $currentRoom);
            $stmt->bindParam(':currentStart', $currentStart);
            $stmt->execute();
            //echo $stmt->debugDumpParams();
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }

        echo "Schedule updated successfully. ";

        ?>
    </div>

    <div>
        <a href="/332demo/schedule/schedule.php"> View schedue </a>
    </div>

</body>

</html> 