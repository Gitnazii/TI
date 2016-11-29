<?php
/*
 * Example of a working config for booking to a calendar.
 */
session_start();
 
require_once('../backend/libs/config.php');
require_once('../backend/libs/cal/corecal.php');
 
/* 
 * Core Calendar Functions (contents of the corecal.php file above)
 */
function sendPostRequest($postargs,$token, $cal){
        global $APIKEY;
        $request = 'https://www.googleapis.com/calendar/v3/calendars/' . $cal . '/events?pp=1&key=' . $APIKEY;
 
        //$auth = json_decode($_SESSION['oauth_access_token'],true);
 
        //var_dump($auth);
 
        $session = curl_init($request);
 
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, true);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session, CURLINFO_HEADER_OUT, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:  application/json','Authorization:  Bearer ' . $token,'X-JavaScript-User-Agent:  Mount Pearl Tennis Club Bookings'));
     
        $response = curl_exec($session);
    
        //echo '<pre>';
        //var_dump(curl_getinfo($session, CURLINFO_HEADER_OUT)); 
        //echo '</pre>';
         
        curl_close($session);
        return $response;
}
 
function sendGetRequest($token,$request){
        global $APIKEY;
        //$request = 'https://www.googleapis.com/calendar/v3/calendars/' . $CAL . '/events?pp=1&key=' . $APIKEY;
 
        //$auth = json_decode($_SESSION['oauth_access_token'],true);
 
        //var_dump($auth);
 
        $session = curl_init($request);
 
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_HTTPGET, true);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLINFO_HEADER_OUT, false);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization:  Bearer ' . $token,'X-JavaScript-User-Agent:  Mount Pearl Tennis Club Bookings'));
 
        $response = curl_exec($session);
 
        //echo '<pre>';
        //var_dump(curl_getinfo($session, CURLINFO_HEADER_OUT)); 
        //echo '</pre>';
 
        curl_close($session);
        return $response;
}
 
function createPostArgsJSON($date,$starttime,$endtime,$title){
        $arg_list = func_get_args();
        foreach($arg_list as $key => $arg){
                $arg_list[$key] = urlencode($arg);
        }
        $postargs = <<<JSON
{
 "start": {
  "dateTime": "{$date}T{$starttime}:00.000-03:30"
 },
 "end": {
  "dateTime": "{$date}T{$endtime}:00.000-03:30"
 },
 "summary": "$title",
 "description": "$title"
}
JSON;
        return $postargs;
}
 
function getAccessToken(){
        $tokenURL = 'https://accounts.google.com/o/oauth2/token';
        $postData = array(
                'client_secret'=>'......', #You need to fill these in to match your site.
                'grant_type'=>'refresh_token',
                'refresh_token'=>'...........', #You need to fill these in to match your site.
                'client_id'=>'.................' #You need to fill these in to match your site.
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        $tokenReturn = curl_exec($ch);
        $token = json_decode($tokenReturn);
        //var_dump($tokenReturn);
        $accessToken = $token->access_token;
        return $accessToken;
}
 
function isTimeBooked($date,$starttime,$endtime,$cal){
        global $APIKEY;
        $start = $date . 'T' . $starttime . ':00-03%3A30';
        $end = $date . 'T' . $endtime . ':00-03%3A30';
        $token = getAccessToken();
        $result = sendGetRequest($token, 'https://www.googleapis.com/calendar/v3/calendars/' . $cal . '/events?timeMax=' . $end . '&timeMin=' . $start . '&fields=items(end%2Cstart%2Csummary)&pp=1&key=' . $APIKEY);
        if(strlen($result) > 5){
                return true; 
        }
        else{
                return false;
        }
}
   
function checkCourtRegistrations($startdate,$starttime,$enddate,$endtime,$cal){
        global $APIKEY;
        $start = $startdate . 'T' . $starttime . ':00-03%3A30';
        $end = $enddate . 'T' . $endtime . ':00-03%3A30';
        $token = getAccessToken();
        $result = sendGetRequest($token, 'https://www.googleapis.com/calendar/v3/calendars/' . $cal . '/events?timeMax=' . $end . '&timeMin=' . $start . '&fields=items(end%2Cstart%2Csummary)%2Csummary&pp=1&key=' . $APIKEY);
        if(strlen($result) > 5){
            $result = json_decode($result,true);
            //return array($result['summary'] => $result['items']);
            return array('items' => $result['items'], 'court' => $result['summary']);
        }
        else{
            return '';
        }
}
/* 
 * End Core Calendar Functions (contents of the corecal.php file above)
 */
 
$thecal = 'court1';
if(isset($_GET['cal'])){
        $thecal = addslashes($_GET['cal']);
}
 
/*
 * Advance is the amount of time in the future someone can book something.
 * days
 * weeks
 * months
 * If it is 0, it will allow unlimited future booking
 */
 
$courts = array(
        'court1' => array('cid' => 'court1', 'name' => 'Court 1', 'id' => '{YOUR CAL}@group.calendar.google.com', 'starttime' => '08:00:00', 'endtime' => '23:00:00', 'advance' => '1 week'),
        'court2' => array('cid' => 'court2', 'name' => 'Court 2', 'id' => '{YOUR CAL}@group.calendar.google.com', 'starttime' => '08:00:00', 'endtime' => '23:00:00', 'advance' => '1 week'),
        'court3' => array('cid' => 'court3', 'name' => 'Court 3', 'id' => '{YOUR CAL}@group.calendar.google.com', 'starttime' => '08:00:00', 'endtime' => '23:00:00', 'advance' => '1 week'),
        'court4' => array('cid' => 'court4', 'name' => 'Court 4', 'id' => '{YOUR CAL}@group.calendar.google.com', 'starttime' => '08:00:00', 'endtime' => '23:00:00', 'advance' => '1 week'),
        'court5' => array('cid' => 'court5', 'name' => 'Court 5', 'id' => '{YOUR CAL}@group.calendar.google.com', 'starttime' => '08:00:00', 'endtime' => '23:00:00', 'advance' => '1 week'),
        'court6' => array('cid' => 'court6', 'name' => 'Court 6', 'id' => '{YOUR CAL}@group.calendar.google.com', 'starttime' => '08:00:00', 'endtime' => '23:00:00', 'advance' => '1 week'),
);
 
$APIKEY = '{YOUR API KEY}';
 
$message = "";
 
if(isset($_POST['submit']) && $_POST['submit'] == 'Book Court'){
        /*
         * Check to see if everything was filled out properly.
         */
        //echo 'start submit' . date('Hms', strtotime($_POST['starttime'] . ':00'));
        //echo 'start default' . date('Hms', strtotime($courts[$_POST['calendar']]['starttime']));
        //echo 'end submit' . date('Hms', strtotime($_POST['endtime'] . ':00'));
        //echo 'end default' . date('Hms', strtotime($courts[$_POST['calendar']]['endtime']));
        if(date('Ymd') > date('Ymd',strtotime($_POST['startdate']))){
                $message = 'You cannot make a booking in the past.  Please check your date.';
        }
        elseif($_POST['starttime'] == ''){
                $message = 'You must enter a start time.';
        }
        elseif($_POST['endtime'] == ''){
                $message = 'You must enter an end time.';
        }
        /*
         * Check to see if booking is available for this time.
         */
        elseif(date('Hms', strtotime($_POST['starttime'] . ':00')) < date('Hms', strtotime($courts[$_POST['calendar']]['starttime'])) || date('Hms', strtotime($_POST['endtime'] . ':00')) > date('Hms', strtotime($courts[$_POST['calendar']]['endtime']))){
                $message = 'Booking not available during this time.  Please select another time.';
        }
        /*
         * Check to see if we are alowed to book this far in advance.
         */
 
        elseif(date('Ymd',strtotime($_POST['startdate'])) > date('Ymd',strtotime('+' . $courts[$_POST['calendar']]['advance'],strtotime($_POST['startdate'])))){
                $message = 'You cannot book that far into the future.  You can only book ' . $courts[$_POST['calendar']]['advance'] . ' in the future.  Please try again.';
                //$message .= date('Ymd',strtotime($_POST['startdate'])) . ' > ' . date('Ymd',strtotime('+' . $courts[$_POST['calendar']]['advance'],strtotime($_POST['startdate'])));
        }
        /*
         * Check and see if a booking already exists.
         */
        elseif(isTimeBooked($_POST['startdate'],$_POST['starttime'],$_POST['endtime'],$courts[$_POST['calendar']]['id'])){
                $message = 'Time already booked.  Please select another time.';
        }
        /*
         * Everything is good, submit the event.
         */
        else{
                $postargs = createPostArgsJSON($_POST['startdate'],$_POST['starttime'],$_POST['endtime'],$_POST['title']);
                $token = getAccessToken();
                $result = sendPostRequest($postargs,$token,$courts[$_POST['calendar']]['id']);
                //echo '<pre>' . $result . '</pre>';
        }
}
?>
<html>
<head>
    <!-- The below JS library is from home.jongsma.org/software/js/datepicker -->
        <script language="javascript" src="../backend/libs/picker/js/prototype-1.6.0.2.js"></script>
        <script language="javascript" src="../backend/libs/picker/js/prototype-base-extensions.js"></script>
        <script language="javascript" src="../backend/libs/picker/js/prototype-date-extensions.js"></script>
        <script language="javascript" src="../backend/libs/picker/js/datepicker.js"></script>
        <link rel="stylesheet" href="../backend/libs/picker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="../backend/styles/default.css" />
        <script type="text/javascript">
                function showHideCourt(){
                        if(document.getElementById('courtref').style.display == 'block'){
                                document.getElementById('courtref').style.display = 'none';
                                document.getElementById('showHideToggle').innerHTML = "Show Court Reference";
                        }
                        else{
                                document.getElementById('courtref').style.display = 'block';
                                document.getElementById('showHideToggle').innerHTML = "Hide Court Reference";
                        }
                }
        </script>
</head>
<body>
<div class="notes">
        <h2>Instructions</h2>
        <ul>
                <li>Use the links below to view existing bookings for each of the courts.</li>
                <li>Once you have selected a time you would like to book, scroll to the bottom of the page and fill out the booking form.</li>
 
        </ul>
</div>
<div class="courtlist">
<?php
        foreach($courts as $court){
                echo '<a href="bookings.php?cal=' . $court['cid'] . '">' . $court['name'] . '</a> | ';
        }
?>
        <a href="#" id="showHideToggle" onclick="showHideCourt()">Show Court Reference</a>
</div>
<div id="courtref" class="courtref">
        <img src="<?php echo SITE_ROOT . 'images/courts.png'; ?>" />
</div>
 
<?php
        if(strlen($message) > 1){
                echo '<div class="message">';
                echo $message;
                echo '</div>';
        }
?>
 
<iframe src="https://www.google.com/calendar/embed?mode=WEEK&amp;showTitle=1&amp;showCalendars=0&amp;height=1000&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=<?php echo $courts[$thecal]['id']; ?>&amp;color=%232952A3&amp;ctz=America%2FSt_Johns" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no" id="califrame" onload="document.getElementById('califrame').contentWindow.scrollTo(0,document.getElementById('califrame').contentWindow.document.body.scrollHeight)"></iframe>
<h2>Book a Court</h2>
<form action="bookings.php?cal=<?php echo $thecal; ?>" method="post" name="booking">
        <input type="hidden" readonly="true" value="<?php echo $thecal; ?>" name="calendar"></input>
        Court: <input type="text" readonly="true" value="<?php echo $courts[$thecal]['name']; ?>" name="calendarname"></input><br />
        Title of Booking: <input type="text" value="Booking for: <?php echo substr($_SESSION['fname'],0,1) . '. ' . $_SESSION['lname'];  ?>" name="title"></input><br />
        Date: <input type="text" readonly="true" value="<?php echo date('Y-m-d'); ?>" id="startdate" name="startdate"></input><br />
        Start Time: <input type="text" readonly="true" value="" id="starttime" name="starttime"></input><br />
        End Time: <input type="text" readonly="true" value="" id="endtime" name="endtime"></input><br />
        <input type="submit" name="submit" value="Book Court"></input>
</form>
<div class="notes">
        <h2>Notes</h2>
        <ul>
                <li>If you need to change your booking, please call the club house.</li>
                <li>You can only book one session per day, and up to one week in advance.</li>
        </ul>
</div>
<script language="javascript">
        new Control.DatePicker('startdate', { icon: '../backend/libs/picker/images/calendar.png', datePicker: true, timePicker: false, dateFormat: 'yyyy-MM-dd' });
        new Control.DatePicker('starttime', { icon: '../backend/libs/picker/images/clock.png', datePicker: false, timePicker: true });
        new Control.DatePicker('endtime', { icon: '../backend/libs/picker/images/clock.png', datePicker: false, timePicker: true });
</script>
</body>
</html>