<?php
require_once 'smppclient.class.php';
require_once 'gsmencoder.class.php';
require_once 'sockettransport.class.php';

// Construct transport and client
$transport = new SocketTransport(array('35.228.92.35'),2775);
//$transport = new SocketTransport(array('184.172.171.235'),10002);
$transport->setRecvTimeout(10000);
$transport->setSendTimeout(10000);
$smpp = new SmppClient($transport);

// Activate binary hex-output of server interaction
$smpp->debug = true;
$transport->debug = true;

// Open the connection
$transport->open();
/**
 * TODO Replace username, password and sender with your assigned details
 */
$username = "yourusername"; //replace with your assigned username
$password = "yourpassword"; //replace with your assigned password
$sender = "yoursenderid"; //replace with your sender id
$phone = "2547XXXXXXXX"; //replace with your test msisdn


$smpp->bindTransmitter($username,$password);

// Optional connection specific overrides
//SmppClient::$sms_null_terminate_octetstrings = false;
//SmppClient::$csms_method = SmppClient::CSMS_PAYLOAD;
//SmppClient::$sms_registered_delivery_flag = SMPP::REG_DELIVERY_SMSC_BOTH;

// Prepare message
$message = 'Test Message';
$encodedMessage = GsmEncoder::utf8_to_gsm0338($message);
$from = new SmppAddress($sender,SMPP::TON_ALPHANUMERIC);
$to = new SmppAddress($phone,SMPP::TON_INTERNATIONAL,SMPP::NPI_E164);

// Send
$smpp->sendSMS($from,$to,$encodedMessage,$tags);

// Close connection
$smpp->close();