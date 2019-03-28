<?php 
    function printTable($headers, $values){
        echo '<table class="table table-bordered table-hover">';
        
        echo '<thead class="thead-dark">';
        echo '<tr>';
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
            echo "</tr>";
        }

        echo "</table>";
    }

?>