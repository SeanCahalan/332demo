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

    
    </head>
    <body>
        <div id="tabs">
            <ul>
                <li><a href="/332demo/info/info.php">Info</a></li>
                <li><a href="/332demo/committee/committee.php">Committees</a></li>
                <li><a href="/332demo/attendee/attendee.php">Attendees</a></li>
                <li><a href="/332demo/sponsor/sponsor.php">Sponsors</a></li>
                <li><a href="/332demo/schedule/schedule.php">Schedule</a></li>
            </ul>
        </div>

<?php
include '../util/DBController.php';
include '../util/PrintTable.php';
$db_handle = new DBController();
$names = $db_handle->runQuery("SELECT DISTINCT name FROM subcommittees ORDER BY name ASC");
?>
<form method="POST" action="/332demo/committee/committee.php" name="search">
    <div class="search-box">
        <select id="Place" name="subcommittee">
            <option value="0">Select Subcommittees</option>
            <?php
                if (! empty($names)) {
                    foreach ($names as $key => $value) {
                        echo '<option value="' . $names[$key]['name'] . '">' . $names[$key]['name'] . '</option>';
                    }
                }
            ?>
        </select>
        <button id="Filter">Search</button>
    </div>

    <?php 
        if (isset($_POST['subcommittee'])) {
            echo $_POST['subcommittee'];
        }
    ?>
  

    <?php
        if (! empty($_POST['subcommittee'])) {
            ?>
        <?php
            $query = "SELECT cm.fname, cm.lname, icno.name
            FROM (committee_members cm 
            INNER JOIN is_committee_member_of icno ON cm.id = icno.id)";
       
            $query = $query . " WHERE icno.name IN ('" . $_POST['subcommittee'] . "')";
            //echo $query;
            $result = $db_handle->runQuery($query);
        }
        if (! empty($result)) {
            printTable(["First name", "Last name", "Subcommittee"], $result)
            ?>
            
  
    <?php
        }
        ?>

</form>

<script type="text/javascript" src="/332demo/index.js"></script>

</body>
</html>

