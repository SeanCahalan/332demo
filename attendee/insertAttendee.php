<!DOCTYPE html>
<html>
    <head>
        <title>332 Conference DB</title>
        <!-- Import JQuery, a Javascript Library  -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- Bootstrap library for CSS formatting -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="/332demo/css/style.css" />
    </head>
    <body>
        <!-- Display  -->
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
                // set PDO error mode to exception to catch error code and information
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

                if($fname == '') $fname = NULL;
                if($lname == '') $lname = NULL;

                // Perform SQL query as a transaction, that rolls back in the event of an error
                try{
                    $conn->beginTransaction();
                    $stmt = $conn->prepare("INSERT INTO attendee (fname, lname, price) 
                        VALUES (:fname, :lname, :price)");
                    // Bind on strongly typed parameterized queries, avoid SQL Injection
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
                    // No errors. SQL statements are safe to be permanently committed
                    $conn->commit();
                } catch (Exception $e) {
                    $conn->rollback();
                    throw $e;
                }

                echo '<div class="alert alert-success">';
                echo "New records created successfully. ";
                echo $_POST['fname'] . " was added."; 
                echo '<a href="/332demo/attendee/attendee.php?sort=' . $attendeeType . '">';
                echo " View " . $attendeeType . " table</a>";
                echo '</div>';
                
            }
            // Error occurs before any database interaction
            catch(PDOException $e) {
                echo '<div class="alert alert-danger">';
                echo "Error: " . $e->getMessage();
                echo "</div>";
            }

            $conn = null;
            ?>
        </div>
    </body>
</html>