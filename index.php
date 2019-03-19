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

        

        <script>
            $( function() {
                // $( "#tabs" ).tabs();
                $('#tabs').tabs({
                    beforeActivate: function (event, ui) {
                        window.location.hash = ui.newPanel.selector;
                    }
                });
            } );
        </script>
    </head>
    <body>

        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Info</a></li>
                <li><a href="#tabs-2">Committees</a></li>
                <li><a href="#tabs-3">Attendees</a></li>
                <li><a href="#tabs-4">Sponsors</a></li>
                <li><a href="#tabs-5">Schedule</a></li>
            </ul>
            <div id="tabs-1"></div>
            <div id="tabs-2"></div>
            <div id="tabs-3"></div>
            <div id="tabs-4"></div>
            <div id="tabs-5"></div>
        </div>

        <?php
            if (isset($_POST['subcommittee'])) {
                echo $_POST['subcommittee'] . " from index";
            }
        ?>

        <script type="text/javascript" src="/332demo/index.js"></script>

    </body>
</html>