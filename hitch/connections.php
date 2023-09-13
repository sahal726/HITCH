<?php
    
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="";
    $dbname="hitch";

    if(!$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
    {
        die("Cannot connect to database");
    }
   