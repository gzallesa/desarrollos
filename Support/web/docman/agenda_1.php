<?php
require_once 'lib/db.php';
require_once 'lib/group.php';
require_once 'lib/folder.php';
require_once 'lib/user.php';

?>
<html>
<head>
    <title>ooppIntranet</title>
    <link rel="stylesheet" href="styles/paragridma.css">
    <link rel="stylesheet" href="styles/eventCalendar.css">
    <link rel="stylesheet" href="styles/eventCalendar_theme_responsive.css">
    <script src="js2/login.js"></script>
    <script src="js2/events.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-1.8.3.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
</script>
</head>
<body>
    <div id="contenid"></div>
    <div id="calendar2" style="margin-top: 10px; margin-right: 0px; margin-left: 5px; width: 230px;"></div>
            <script>
                    $(document).ready(function() {
                            $("#calendar2").eventCalendar({
                                    eventsjson: 'json/events.json_2.php' // link to events json
                            });
                    });
            </script>
</body>
<script src="js2/jquery.eventCalendar.js" type="text/javascript"></script>
</html>