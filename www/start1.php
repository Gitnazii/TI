<?php
require_once '/vendor/autoload.php';
session_start();

    $client = new Google_Client();
    $client->setApplicationName("Google Calendar PHP Starter Application");
    $client->setClientId('###');
    $client->setClientSecret('###');
    $client->setRedirectUri('http://test.mydomain.com/index.php'); //redirect works now! =)
    $client->setDeveloperKey('###');
    $cal = new Google_CalendarService($client);

if (isset($_GET['logout'])) {
    unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
	echo "got the code"; //Gets here 2nd
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
	echo "got the token"; 
    $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()){
		echo "get the token";
        $event = new Google_Event();
        $event->setSummary('Halloween');
        $event->setLocation('The Neighbourhood');
        $start = new Google_EventDateTime();
        $start->setDateTime('2013-9-29T10:00:00.000-05:00');
        $event->setStart($start);
        $end = new Google_EventDateTime();
        $end->setDateTime('2013-9-29T10:25:00.000-05:00');
        $event->setEnd($end);
        $createdEvent = $cal->events->insert('###', $event);
}

else {
		echo "else<br />"; //gets here first
        $authURL = $client->createAuthURL();
        echo $authURL;
}

?>