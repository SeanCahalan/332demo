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

    <?php
        $servername = "localhost";
        $username = "root";
        $dbname = "conference";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // try transactions for touching multiple tables
            if(!isset($_POST["transaction_type"])){
                throw new Exception('Missing Sponsor Transaction Type.');
            }

            if(!isset($_POST["company_name"])){
                throw new Exception('Missing Sponsor Name');
            }

            $transaction_type = $_POST["transaction_type"];
            $company_name = $_POST["company_name"];

            // Check if the company already exists
            $stmt = $conn->prepare("SELECT * FROM sponsor_company WHERE company_name=:company_name");
            $stmt->execute(['company_name' => $company_name]); 
            $company_exists = !empty($stmt->fetch());
            
            // Check if the company already exists
            if ($transaction_type === 'add') {
                if ($company_exists) {
                    throw new Exception("The company ${company_name} already exists");
                } else if (!isset($_POST["sponsor_type"])) {
                    throw new Exception("Company Sponsor type not defined");
                }
                $sponsor_type = $_POST["sponsor_type"];
            } 
            // Prep work to delete all sponsor attendees
            else if ($transaction_type === 'del' && !$company_exists) {
                throw new Exception("The company ${company_name} does not exist");
            }

            try{
                $conn->beginTransaction();

                if ($transaction_type === 'add') {
                    $stmt = $conn->prepare("INSERT INTO sponsor_company (company_name, emails_sent, class) 
                        VALUES (:company_name, 0, :sponsor_type)");
                    $stmt->bindParam(':company_name', $company_name);
                    $stmt->bindParam(':sponsor_type', $sponsor_type);
                    $stmt->execute();
                } else if ($transaction_type === 'del') {
                    // Delete all sponsors
                    $stmt = $conn->prepare("DELETE FROM `attendee` WHERE `id` IN (SELECT id FROM `sponsor` WHERE company_name=:company_name)");
                    $stmt->execute(['company_name' => $company_name]); 

                    // Delete the sponsor company
                    $stmt = $conn->prepare("DELETE FROM `sponsor_company` WHERE company_name=:company_name");
                    $stmt->execute(['company_name' => $company_name]); 
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollback();
                throw $e;
            }
            if ($transaction_type === 'add') {
                echo $company_name . " was added successfully."; 
            } else if ($transaction_type === 'del') {
                echo $company_name . " was deleted successfully."; 
            }
        }
        catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
        ?>
        <div><a href="/332demo/sponsor/sponsor.php" >
            "Return to Sponsor table"
        </a></div>

    </div> <!-- End Content -->

    <script type="text/javascript" src="/332demo/index.js"></script>

    </body>
</html>