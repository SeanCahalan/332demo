<?php 
    function printTable($headers, $stmt){
        require_once('TableRows.php');

        echo "<table style='border: solid 1px black;'>";
        foreach($headers as $header){
            echo "<th>$header</th>";
        }
        echo "</tr>";

        foreach(new TableRows(new RecursiveArrayIterator($stmt)) as $k=>$v) { 
            echo $v;
        }

        echo "</table>";
    }

?>