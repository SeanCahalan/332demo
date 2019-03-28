<?php 
    function printScheduleTable($values){
        $headers = ['Event Name', 'Room Number', 'Start Time', 'End Time', ' '];
        echo '<table class="table table-bordered table-hover">';

        echo '<thead class="thead-dark">';
        echo "<tr>";
        foreach($headers as $header){
            echo "<th>$header</th>";
        }
        echo "</tr>";
        echo "</thead>";

        foreach ($values as $row) {
            echo "<tr>";
            foreach ($row as $stmt){
                echo '<td>'.$stmt."</td>";
            }
            $room = $row['room'];
            $startTime = $row['start_time'];
            $endTime = $row['end_time'];
            $functionCall = "editSchedule(". $room .", '" . $startTime."', '". $endTime ."')";
            echo '<td>'.'<button id="edit" type="button" class="btn btn-outline-warning" onclick="'.$functionCall.'">Edit</button>'."</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

?>

