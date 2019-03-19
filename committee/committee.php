<?php
$_POST = json_decode(file_get_contents('php://input'), true);
include '../util/DBController.php';
$db_handle = new DBController();
$names = $db_handle->runQuery("SELECT DISTINCT name FROM subcommittees ORDER BY name ASC");
?>
<form method="POST" action="/332demo/index.php#tabs-2" name="search">
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
            <table cellpadding="10" cellspacing="1">

        <thead>
            <tr>
                <th><strong>Name</strong></th>
                <th><strong>Gender</strong></th>
                <th><strong>Country</strong></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $query = "SELECT cm.fname, cm.lname, icno.name
            FROM (committee_members cm 
            INNER JOIN is_committee_member_of icno ON cm.id = icno.id)";
       
            $query = $query . " WHERE icno.name in (" . $_POST['subcommittee'] . ")";
            
            $result = $db_handle->runQuery($query);
        }
        if (! empty($result)) {
            foreach ($result as $key => $value) {
                ?>
        <tr>
                <td><div class="col" id="user_data_1"><?php echo $result[$key]['fname']; ?></div></td>
                <td><div class="col" id="user_data_2"><?php echo $result[$key]['lname']; ?> </div></td>
            </tr>
        <?php
            }
            ?>
            
        </tbody>
    </table>
    <?php
        }
        ?>

</form>

