<?php

include 'function.php';
$phone = $_GET['phone'];
$otp = $_GET['otp'];

$message = "Dear Member, OTP for Mobile App Registration is " + otp + " - Thrift Society";
$url = "http://login.smsindiahub.in/api/mt/SendSMS?user=vspthriftsociety&password=Thrift@1918&senderid=THRIFT&channel=trans&DCS=0&flashsms=0&number=" + phone + "&text=" + message + "&route=5&PEId=1001109379533529747";
sms($message, $phone);
echo 'sms sent';
