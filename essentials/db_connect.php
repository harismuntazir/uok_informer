<html lang="en">
<meta charset="utf-8">
<head>
    <link rel="stylesheet" href="../styles/gen_styles.css"/>
</head>
<?php
/**
 * Created by PhpStorm.
 * User: hm
 * Date: 4/14/2020
 * Time: 6:36 AM
 */

//connect to the database

$host = "localhost";
$username = "root";
$password = "";
$db_name = "uok_forms";

$conn = mysqli_connect("$host","$username","$password","$db_name");

if(!$conn) {
    echo "<section id='msg'><strong class='error_msg'>Connection to database could not be established</strong></section>";
    exit;
}
