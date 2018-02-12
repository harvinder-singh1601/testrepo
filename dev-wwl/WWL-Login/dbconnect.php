<?php

	 $DBhost = "localhost";
     $DBuser = "root";
     $DBpass = "goEDU2018!!";
     $DBname = "winwinlabs_database";



 
	 $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR1 : -> ".$DBcon->connect_error);
     }


