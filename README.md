SRV-Checker
===========

Enables you to easily resolve the actual address behind an SRV record for Minecraft servers.

Requirements
------------

This script requires PHP 5 or higher for Linux. For Windows, PHP 5.3 or higher is required.

Usage
-----

You can easily get the actual address behind an SRV record by using the following code:

  include 'SRV.php';

  //Server address you're checking.
  $address = "play.hosthorde.com"; 

  //Do the SRV record check. If no SRV record is found, it will return the same address.
  $checkSRV = new SRV_Checker;
  $check_address = $checkSRV->checkAddress($address);

  //Output the result. Do your uptime checks with this address. However, display the actual address as $address
  echo $check_address;
  
