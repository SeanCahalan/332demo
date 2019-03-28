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

            $companies = $db_handle->runQuery("SELECT company_name, class FROM sponsor_company;");

            // default selection shows all jobs
            $selected_company = "*";
            if(isset($_GET['selected_company'])){
                $selected_company = $_GET["selected_company"];
            }
            else if(isset($_POST['selected_company'])){
                $selected_company = $_POST["selected_company"];
            }
        ?>

        <!-- Add a Sponsor -->
        <button id="student" type="button" class="btn btn-primary" data-toggle="modal" data-target="#sponsor_modal_add">
            Add Sponsor
        </button>

        <!-- Bootstrap Modal Box to get user input -->
        <div class="modal fade" id="sponsor_modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_label">Add a Sponsor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="/332demo/sponsor/sponsorTransaction.php"> 

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Company name</span>
                                </div>
                                <input type="text" class="form-control" name="company_name">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Sponsor type</span>
                                </div>
                                <select name="sponsor_type" class="custom-select">
                                    <option value='Bronze'>Bronze</option>
                                    <option value='Silver'>Silver</option>
                                    <option value='Gold'>Gold</option>
                                    <option value='Platinum'>Platinum</option>
                                </select>
                            </div>

                            <input type="hidden" name="transaction_type" value='add'>
                            <button type="submit" name="save" class="btn btn-primary">save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete a Sponsor -->
        <button id="professional" type="button" class="btn btn-danger" data-toggle="modal" data-target="#sponsor_modal_del">
            Delete Sponsor
        </button>
        <br>

         <!-- Bootstrap Modal Box to get user input -->
        <div class="modal fade" id="sponsor_modal_del" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_label">Delete a Sponsor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/332demo/sponsor/sponsorTransaction.php">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Company name</span>
                                </div>
                                <select name="company_name" class="custom-select">
                                    <?php 
                                        // Default ALL option
                                        echo "<option selected='selected' value='*'>All Companies</option>\n";
                                        foreach ($companies as $company) {
                                            echo "<option value='${company['company_name']}'> ${company['company_name']} </option>\n";
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <input type="hidden" name="transaction_type" value='del'>
                            <button type="submit" name="selection" class="btn btn-danger">delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h3 style="margin-top: 20px;">Sponsorships</h3>
        <!-- Drop down menu to filter companies -->
        <form method="post" action="/332demo/sponsor/sponsor.php">
            <div class="input-group mb-3" style="width: 480px;">
                <div class="input-group-prepend">
                    <span class="input-group-text">Sort sponsorship by company</span>
                </div>
                <select name="selected_company" onchange="this.form.submit()" class="custom-select">
                    <?php 
                        // Default ALL option
                        echo "<option selected='selected' value='*'>All Companies</option>\n";
                        foreach ($companies as $company) {
                            $is_selected = ($selected_company==$company['company_name']) ? "selected='selected' " : "";
                            echo "<option ".$is_selected."value='${company['company_name']}'> ${company['company_name']} </option>\n";
                        }
                    ?>
                </select>
            </div> 
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

        <br>
        <!-- Job board listings -->
        <?php 
            // default selection shows all jobs
            $sel_job_comp = "*";
            if(isset($_GET['sel_job_comp'])){
                $sel_job_comp = $_GET["sel_job_comp"];
            }
            else if(isset($_POST['sel_job_comp'])){
                $sel_job_comp = $_POST["sel_job_comp"];
            }
        ?>

        <h3>Job Listings</h3>
        <!-- Drop down menu to filter companies -->
        <form method="post" action="/332demo/sponsor/sponsor.php">
            <div class="input-group mb-3" style="width: 480px;">
                <div class="input-group-prepend">
                    <span class="input-group-text">Sort jobs by company</span>
                </div>
                <select name="sel_job_comp" onchange="this.form.submit()" class="custom-select">
                    <?php 
                        $companies = $db_handle->runQuery("SELECT company_name FROM advertisement;");
                        // Default ALL option
                        echo "<option selected='selected' value='*'>All Companies</option>\n";
                        foreach ($companies as $company) {
                            $is_selected = ($sel_job_comp==$company['company_name']) ? "selected='selected' " : "";
                            echo "<option ".$is_selected."value='${company['company_name']}'> ${company['company_name']} </option>\n";
                        }
                    ?>
                </select>
            </div> 
            
        </form>

        <!-- Display a table of job listings -->
        <?php 
            require_once('../util/PrintTable.php');
            if ($sel_job_comp == "*") {
                $sql = "SELECT * FROM advertisement";
            } else {
                $sql = "SELECT * FROM advertisement WHERE company_name='${sel_job_comp}'";
            }
            $result = $db_handle->runQuery($sql);

            printTable(['Job Title', 'Company', 'City', 'Province', 'Pay' ], $result);
        ?>

        </div> <!-- End Content -->

        <!-- Reference the index file that loads in some helper JS functions -->
        <script type="text/javascript" src="/332demo/index.js"></script>

    </body>
</html>