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

            echo '<div class="alert alert-success">';
            echo "Schedule updated successfully. ";
            echo '<a href="/332demo/schedule/schedule.php"> View schedule </a>';
            echo '</div>';

        } catch (Exception $e) {
            $conn->rollback();
            echo '<div class="alert alert-danger">';
            echo "Error: " . $e->getMessage();
            echo "</div>";
            // throw $e;
        }

        

        ?>
    </div>



</div>
</body>

</html> 