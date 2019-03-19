<div>
<label id="first">Company</label><br/>
<select type="text" name="company">
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
</select><br/>
</div>