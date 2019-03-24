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
                <li class="active"><a href="/332demo/info/info.php">Info</a></li>
                <li><a href="/332demo/committee/committee.php">Committees</a></li>
                <li><a href="/332demo/attendee/attendee.php">Attendees</a></li>
                <li><a href="/332demo/sponsor/sponsor.php">Sponsors</a></li>
                <li><a href="/332demo/schedule/schedule.php">Schedule</a></li>
            </ul>
        </div>

        <div class="content">

        <?php 
            include '../util/DBController.php';
            $db_handle = new DBController();

            $numAttendees = $db_handle->runQuery("SELECT COUNT(id) as num FROM attendee")[0]['num'];
            $numStudents = $db_handle->runQuery("SELECT COUNT(id) as num FROM student ")[0]['num'];
            $numProfessionals = $db_handle->runQuery("SELECT COUNT(id) as num FROM professional ")[0]['num'];

            $attendanceSum = $db_handle->runQuery("SELECT SUM(price) as sum FROM attendee")[0]['sum'];
            

            $sponsorships = $db_handle->runQuery("SELECT st.class, cost, COUNT(st.class), SUM(cost)
                FROM sponsor_company sc INNER JOIN sponsor_type st ON sc.class = st.class
                GROUP BY st.class");
            $sponsorSum = $db_handle->runQuery("SELECT SUM(cost) as sum
                FROM sponsor_company sc 
                INNER JOIN sponsor_type st ON sc.class = st.class")[0]['sum'];

        ?>

        <table>
            <tr>
                <td style="text-align: center;" colspan="4">Attendance</td>
            </tr>
            <tr>
                <td>Attendee type</td>
                <td>Ticket cost</td>
                <td>Number of attendees</td>
                <td>Total amount</td>
            </tr>
            <tr>
                <td>Student</td>
                <td>50</td>
                <td><?php echo $numStudents;?></td>
                <td><?php echo $numStudents * 50;?></td>
            </tr>
            <tr>
                <td>Professional</td>
                <td>100</td>
                <td><?php echo $numProfessionals;?></td>
                <td><?php echo $numProfessionals * 100;?></td>
            </tr>
            <tr>
                <td></td><td></td><td></td>
                <td><?php echo $attendanceSum; ?></td>
            </tr>

            <tr>
                <td style="text-align: center;" colspan="4">Sponsorship</td>
            </tr>


            <tr>
                <td>Sponsor type</td>
                <td>Price</td>
                <td>Number of sponsorships</td>
                <td>Total amount</td>
            </tr>

            <?php 
                foreach($sponsorships as $row){
                    echo "<tr>";
                    foreach($row as $col){
                        echo "<td>";
                        echo $col;
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            ?>
            <tr>
                <td></td><td></td><td></td>
                <td><?php echo $sponsorSum; ?></td>
            </tr>
            
        </table>


        </div>

        <script type="text/javascript" src="/332demo/index.js"></script>

</body>
</html>