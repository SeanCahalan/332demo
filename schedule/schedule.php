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

    <link rel="stylesheet" href="/332demo/css/style.css" />
</head>

<body>
    <div id="tabs">
        <ul>
            <li><a href="/332demo/info/info.php">Info</a></li>
            <li><a href="/332demo/committee/committee.php">Committees</a></li>
            <li><a href="/332demo/attendee/attendee.php">Attendees</a></li>
            <li><a href="/332demo/sponsor/sponsor.php">Sponsors</a></li>
            <li class="active"><a href="/332demo/schedule/schedule.php">Schedule</a></li>
        </ul>
    </div>

    <div class="content">

        <?php 
        include '../util/DBController.php';
        $db_handle = new DBController();

        try {
            $sql = "SELECT DISTINCT cast(start_time as date) AS day FROM session";
            $result = $db_handle->runQuery($sql);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $sort = "all";
        if (isset($_GET['sort'])) {
            $sort = $_GET["sort"];
        }
        if (isset($_POST['sort'])) {
            $sort = $_POST["sort"];
        }

        ?>

        <form method="post" action="/332demo/schedule/schedule.php">
            <select name="sort" onchange="this.form.submit()">
                <option <?php if ($sort == 'all') { ?>selected="selected" <?php 
                                                                        } ?> value="all">All</option>
                <?php
                foreach ($result as $row) {
                    //echo '<option value="'.$row['day'].'">'.$row['day'].'</option>';
                    $option = '<option ';
                    if ($sort == $row['day']) {
                        $option .= 'selected="selected" ';
                    }
                    $option .= 'value="' . $row['day'] . '">' . $row['day'] . '</option>';
                    echo $option;
                }
                ?>
            </select>
        </form>

        <div class="modal fade" id="edit_schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Schedule</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/332demo/schedule/editSchedule.php">
                            <div id="edit_schedule_form"></div>
                            <button type="submit" name="save">save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        require_once('../schedule/PrintScheduleTable.php');
        if ($sort == "all") {
            try {
                $sql = "SELECT name, room, start_time, end_time FROM session ORDER BY start_time";
                $result = $db_handle->runQuery($sql);
                printScheduleTable($result);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            try {
                $sql = "SELECT name, room, start_time, end_time FROM session WHERE cast(start_time as date) = '" . $sort . "' ORDER BY start_time";
                $result = $db_handle->runQuery($sql);
                printScheduleTable($result);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        ?>



    </div>
    <script type="text/javascript" src="/332demo/index.js"></script>
</body>

</html> 