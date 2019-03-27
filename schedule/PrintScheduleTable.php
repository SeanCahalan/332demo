<?php 
    function printScheduleTable($values){
        $headers = ['Event Name', 'Room Number', 'Start Time', 'End Time', ' '];
        echo "<table style='border: solid 1px black;'>";
        foreach($headers as $header){
            echo "<th>$header</th>";
        }
        echo "</tr>";

        foreach ($values as $row) {
            echo "<tr>";
            foreach ($row as $stmt){
                echo '<td style="width:150px;border:1px solid black;">'.$stmt."</td>";
            }
            $room = $row['room'];
            $startTime = $row['start_time'];
            $endTime = $row['end_time'];
            $functionCall = "editSchedule(". $room .", '" . $startTime."', '". $endTime ."')";
            echo '<td>'.'<button id="edit" type="button" class="btn btn-primary" onclick="'.$functionCall.'">Edit</button>'."</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

?>

