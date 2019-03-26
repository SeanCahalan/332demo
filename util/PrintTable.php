<?php 
    function printTable($headers, $values){
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
            echo "</tr>";
        }

        echo "</table>";
    }

?>