<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Hotel room number</span>
    </div>
    <select type="text" name="room" class="custom-select">
        <option value="">no selection</option>
        <?php 
            include '../util/DBController.php';
            $db_handle = new DBController();

            $rooms = $db_handle->runQuery("SELECT room_number FROM hotel_rooms 
                WHERE hotel_rooms.beds * 2 > hotel_rooms.occupants");
            foreach($rooms as $room){
                echo "<option>";
                echo $room["room_number"];
                echo "</option>";
            }
        ?>
    </select>
</div>