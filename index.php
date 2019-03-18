<!DOCTYPE html>
<html>
    <head>
        <title>332 Conference DB</title>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"/> -->

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            $( function() {
                $( "#tabs" ).tabs();
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
        ?>

        <script type="text/javascript" src="/332demo/index.js"></script>

    </body>
</html>