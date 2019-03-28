<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Company</span>
    </div>
    <select type="text" name="company" class="custom-select">
        <?php 
            include '../util/DBController.php';
            $db_handle = new DBController();

            $companies = $db_handle->runQuery("SELECT company_name FROM sponsor_company");
            foreach($companies as $company){
                echo "<option>";
                echo $company["company_name"];
                echo "</option>";
            }
        ?>
    </select>
</div> 