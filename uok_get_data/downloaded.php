<?php
/**
 * Created by PhpStorm.
 * User: hm
 * Date: 4/14/2020
 * Time: 6:35 AM
 */

require_once "../essentials/db_connect.php";

$out = @mysqli_query($conn, "SELECT * FROM batch2016");

echo $out->num_rows;