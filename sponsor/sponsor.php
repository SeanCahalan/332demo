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
                <li class="active"><a href="/332demo/sponsor/sponsor.php">Sponsors</a></li>
                <li><a href="/332demo/schedule/schedule.php">Schedule</a></li>
            </ul>
        </div>

        <div class="content">
        <!-- Initialize the database connection -->
        <?php 
            include '../util/DBController.php';
            $db_handle = new DBController();

            // default selection shows all jobs
            $selected_company = "*";
            if(isset($_GET['selected_company'])){
                $selected_company = $_GET["selected_company"];
            }
            else if(isset($_POST['selected_company'])){
                $selected_company = $_POST["selected_company"];
            }
        ?>

        <!-- Drop down menu to filter companies -->
        <form method="post" action="/332demo/sponsor/sponsor.php">
            <select name="selected_company" onchange="this.form.submit()">
                <?php 
                    $companies = $db_handle->runQuery("SELECT company_name, class FROM sponsor_company;");
                    // Default ALL option
                    echo "<option selected='selected' value='*'>All Companies</option>\n";
                    foreach ($companies as $company) {
                        $is_selected = ($selected_company==$company['company_name']) ? "selected='selected' " : "";
                        echo "<option ".$is_selected."value='${company['company_name']}'> ${company['company_name']} </option>\n";
                    }
                ?>
            </select>
        </form>

        <?php 
            require_once('../util/PrintTable.php');
            if ($selected_company == "*") {
                $sql = "SELECT company_name, class FROM sponsor_company";
            } else {
                $sql = "SELECT company_name, class FROM sponsor_company WHERE company_name='${selected_company}'";
            }
            $result = $db_handle->runQuery($sql);
            printTable(['Company Name', 'Sponsorship'], $result);
        ?>

        </div> <!-- End Content -->

        <script type="text/javascript" src="/332demo/index.js"></script>

    </body>
</html>