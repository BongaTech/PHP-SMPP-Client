<?php
require_once 'smppclient.class.php';
require_once 'sockettransport.class.php';

// Construct transport and client
$transport = new SocketTransport(array('35.228.92.35'),2775);
$transport->setRecvTimeout(10000); // for this example wait up to 60 seconds for data
$smpp = new SmppClient($transport);

// Activate binary hex-output of server interaction
$smpp->debug = true;
$transport->debug = true;

// Open the connection
$transport->open();

/**
 * TODO Replace username, password  assigned details
 */
$username = "yourusername"; //replace with your assigned username
$password = "yourpassword"; //replace with your assigned password

$smpp->bindReceiver($username,$password);

// Read SMS and output
echo "reading......";
$sms = $smpp->readSMS();
var_dump($sms);

// Close connection
$smpp->close();