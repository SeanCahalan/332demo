<?php 
    function printTable($stmt){
        require_once('TableRows.php');

        echo "<table style='border: solid 1px black;'>";
        echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";

        foreach(new TableRows(new RecursiveArrayIterator($stmt)) as $k=>$v) { 
            echo $v;
        }

        echo "</table>";
    }

?>