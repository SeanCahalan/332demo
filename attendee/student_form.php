<div>
<label id="first">Room Number</label><br/>
<select type="text" name="room">
    <option>no selection</option>
    <?php 
        include '../util/DBController.php';
        $db_handle = new DBController();

        $rooms = $db_handle->runQuery("SELECT room_number FROM hotel_rooms WHERE hotel_rooms.beds < 4");
        foreach($rooms as $room){
            echo "<option>";
            echo $room["room_number"];
            echo "</option>";
        }
    ?>
</select><br/>
</div>