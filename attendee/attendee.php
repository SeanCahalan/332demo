<div class="content">




<?php 
    include '../util/DBController.php';
    $db_handle = new DBController();
?>

<button id="student" type="button" class="btn btn-primary" onclick="addAttendee('student')">
    Add Student
</button>

<button id="professional" type="button" class="btn btn-primary" onclick="addAttendee('professional')">
    Add Professional
</button>

<button id="sponsor" type="button" class="btn btn-primary" onclick="addAttendee('sponsor')">
    Add Sponsor
</button>

<div class="modal fade" id="add_attendee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add an attendee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="/332demo/attendee/insertAttendee.php"> 
                    <label id="first"> First name:</label><br/>
                    <input type="text" name="fname"><br/>

                    <label id="first">Last name:</label><br/>
                    <input type="text" name="lname"><br/>

                    <label id="first">Price:</label><br/>
                    <input type="number" name="price"><br/>

                    <div id="additional_attendee_form"></div>

                    <button type="submit" name="save">save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('../util/PrintTable.php');

    try {
        $sql = "SELECT attendee.id, attendee.fname, attendee.lname, student.room_number
        FROM ((attendee 
        INNER JOIN student ON attendee.id = student.id)
        LEFT JOIN hotel_rooms ON student.room_number = hotel_rooms.room_number)";
        $result = $db_handle->runQuery($sql);
        printTable(['ID', 'First name', 'Last name', '<a>Room number</a>'], $result);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        $sql = "SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from professional)";
        $result = $db_handle->runQuery($sql);
        printTable(['ID', 'First name', 'Last name'], $result);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        $sql = "SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from sponsor)";
        $result = $db_handle->runQuery($sql);
        printTable(['ID', 'First name', 'Last name'], $result);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


    $conn = null;
?>

</div>