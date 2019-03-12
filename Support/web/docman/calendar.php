<!DOCTYPE html>
<html>
<head>
    <title>ooppIntranet</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--    eventCalendar-->
        <link rel="stylesheet" href="css/paragridma.css">
        <link rel="stylesheet" href="css/eventCalendar.css">
        <link rel="stylesheet" href="css/eventCalendar_theme_responsive.css">
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script><!--    EndEventCalendar-->

</head>
<body>
<br>
        <div id="calendar" style="margin-top: 10px; margin-right: 0px; margin-left: 5px; width: 230px;height: 500px"></div>
                <script>
                        $(document).ready(function() {
                                $("#calendar").eventCalendar({
                                        eventsjson: 'http://intranet.oopp.gob.bo/events' // link to events json
                                });
                        });
                </script>
</body>
<script src="js/jquery.eventCalendar.js" type="text/javascript"></script>
</html>
