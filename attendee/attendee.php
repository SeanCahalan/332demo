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
    include '../util/DBController.php';
    $db_handle = new DBController();

    $sort = "all";
    if(isset($_GET['sort'])){
        $sort = $_GET["sort"];
    }
    if(isset($_POST['sort'])){
        $sort = $_POST["sort"];
    }
    

    $room = 'all';
    if(isset($_POST['room'])){
        $room = $_POST["room"];
    }
    
?>

<form method="post" action="/332demo/attendee/attendee.php">
    <div class="input-group mb-3" style="width: 320px;">
        <div class="input-group-prepend">
            <span class="input-group-text">Sort attendees by type</span>
        </div>
        <select name="sort" onchange="this.form.submit()" class="custom-select">
            <option <?php if($sort=='all'){?>selected="selected"<?php }?> value="all">All</option>
            <option <?php if($sort=='student'){?>selected="selected"<?php }?> value="student">Student</option>
            <option <?php if($sort=='professional'){?>selected="selected"<?php }?> value="professional">Professional</option>
            <option <?php if($sort=='sponsor'){?>selected="selected"<?php }?> value="sponsor">Sponsor</option>
        </select>
    </div> 
</form>

<?php if($sort == "student"){ 
?>
    <form method="post" action="/332demo/attendee/attendee.php?sort=student">
        <div class="input-group mb-3" style="width: 320px;">
            <div class="input-group-prepend">
                <span class="input-group-text">Sort students by hotel room</span>
            </div>
            <select name="room" onchange="this.form.submit()" class="custom-select">
                <option <?php if(! is_numeric($room)){?>selected="selected"<?php }?> value="all">All</option>
                <?php 
                    $rooms = $db_handle->runQuery("SELECT room_number FROM hotel_rooms");
                    foreach($rooms as $number){
                        if($room==$number["room_number"]){
                            echo '<option selected="selected" value="'.$number["room_number"].'">';
                        } else {
                            echo '<option value="'.$number["room_number"].'">';
                        }
                        echo $number["room_number"];
                        echo "</option>";
                    }
                ?>
            </select>
        </div> 
    </form>
<?php } ?>

<?php if($sort == "student" || $sort == "all"){ 
?>
    <button id="student" type="button" class="btn btn-primary" onclick="addAttendee('student')">
        Add Student
    </button>
<?php } ?>

<?php if($sort == "professional" || $sort == "all"){ 
?>
    <button id="professional" type="button" class="btn btn-primary" onclick="addAttendee('professional')">
        Add Professional
    </button>
<?php } ?>

<?php if($sort == "sponsor" || $sort == "all"){ 
?>
    <button id="sponsor" type="button" class="btn btn-primary" onclick="addAttendee('sponsor')">
        Add Sponsor
    </button>
<?php } ?>

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

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">First name</span>
                        </div>
                        <input type="text" class="form-control" name="fname">
                    </div>
              
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Last name</span>
                        </div>
                        <input type="text" class="form-control" name="lname">
                    </div>

                    <div id="additional_attendee_form"></div>

                    <button type="submit" name="save" class="btn btn-primary">save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('../util/PrintTable.php');

    if($sort == "all"){
        try {
            $sql = "SELECT id, fname, lname FROM attendee";
            $result = $db_handle->runQuery($sql);
            printTable(['ID', 'First name', 'Last name'], $result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif($sort == "student") {
        
        try {
            $sql = "SELECT attendee.id, attendee.fname, attendee.lname, student.room_number
            FROM ((attendee 
            INNER JOIN student ON attendee.id = student.id)
            LEFT JOIN hotel_rooms ON student.room_number = hotel_rooms.room_number)";
            if(is_numeric($room)){
                $sql = $sql . " WHERE student.room_number = " . $room;
            }
            $result = $db_handle->runQuery($sql);
            printTable(['ID', 'First name', 'Last name', '<a>Room number</a>'], $result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif($sort == "professional"){
        try {
            $sql = "SELECT id, fname, lname FROM attendee WHERE id in (SELECT id from professional)";
            $result = $db_handle->runQuery($sql);
            printTable(['ID', 'First name', 'Last name'], $result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif($sort == "sponsor"){
        try {
            $sql = "SELECT a.id, fname, lname, company_name FROM attendee a
                INNER JOIN sponsor s ON a.id = s.id";
            $result = $db_handle->runQuery($sql);
            printTable(['ID', 'First name', 'Last name', 'Company'], $result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

?>

</div>
<script type="text/javascript" src="/332demo/index.js"></script>

</body>
</html>