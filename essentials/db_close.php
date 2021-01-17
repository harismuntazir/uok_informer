<?php
/**
 * Created by PhpStorm.
 * User: hm
 * Date: 4/14/2020
 * Time: 6:43 AM
 */
//close the connection to database

require_once "db_connect.php";

mysqli_close($conn); //$conn is from db_connect.php