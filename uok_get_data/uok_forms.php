<?php
/**
 * Created by PhpStorm.
 * User: hm
 * Date: 4/14/2020
 * Time: 6:35 AM
 */

require_once "../essentials/db_connect.php";

@$last_save_uid = mysqli_query($conn, "SELECT * FROM batch2016 WHERE islast = 1;");
$num_rows = $last_save_uid->num_rows;
//if no record was found use uid = 0
if($num_rows == 0) {
    $uid = 0;
}
else {
    for($i=0;$i<$num_rows;$i++) {
        $rows = $last_save_uid->fetch_assoc();
        $lstuid = $rows['uid'];
        $islast = $rows['islast'];
        $isLoading = $rows['isloading'];

        if ($isLoading) //record is being downloaded
            continue;
        if(!$isLoading && $islast == 1) {   //this is the last downloaded record
            $uid = $lstuid; //last uid is here
            break; //stop the loop because from now no result is downloaded
        }
    }   //so the uid = above uid, the last one, otherwise it is 0
}

$batch = 2016;

//now start loop to download the files
for($i=0;$i<30;$i++){ //this will run the loop for 10 records max
    $uid = $uid + 1;   //set the new uid everytime the loop repeats
    $filelink = "http://egov.uok.edu.in/CollegeAdm/AdmDetails/showreports.aspx?rrid=" . "$batch" . "1&courseyear=1&UID=" . "$uid" . "&reportid=101";
    //echo $filelink . "<br />";
    //convert file data to mysql compitable
    //$file_data = mysqli_real_escape_string($conn,file_get_contents($filelink));

    @$check = mysqli_query($conn, "SELECT * FROM batch2016 WHERE islast = 1;");
    $num_rows = $check->num_rows;
    for($i=0;$i<$num_rows;$i++) {
        $rows = $check->fetch_assoc();
        $isLoading = $rows['isloading'];
        if ($isLoading) //record is being downloaded
            break;
    }
    if($isLoading)
        continue;

    //set isLoading to true
    @$insert_data = mysqli_query($conn, "INSERT INTO batch2016 VALUES ($uid, TRUE, 0)");

//now if data is insert successfully set the downloaded flag to 1 and change the isloading flag to false
    if ($insert_data) {
        //set last record islast flag to 0 as there will be new last downloaded one
        $lstuid = $uid - 1;
        @$lst_record_update = mysqli_query($conn, "UPDATE batch2016 SET islast = 0, isloading = FALSE WHERE uid=$lstuid;");
        //set new last record downloaded
        @$update = mysqli_query($conn,"UPDATE batch2016 SET islast = 1, isloading = FALSE WHERE uid=$uid;");
        if(!$update) {
            echo "File IsLast Flag Failed To Set <br/>";
            @mysqli_query($conn, "UPDATE batch2016 SET islast = 1, isloading = FALSE WHERE uid=$lstuid;");
            continue;
        }
        else {
            //save the file
            $file_data = file_get_contents($filelink);
            $loc = "tmp/Form No. " . $uid . ".pdf";
            $fp = fopen($loc, "wb");
            file_put_contents("$loc","$file_data");
            echo "Form No. = " . $uid . " Downloaded <br/>";
        }
    }
    else {
        //echo $uid;
        //echo "<br/> Data Insertion Failed ! Because " . mysqli_error($conn);
        //@mysqli_query($conn,"UPDATE batch2016 SET islast = 0, isloading = FALSE WHERE uid=$uid;");
        continue;
    }
    //unset the $file_data variable
    unset($file_data);
    //timeout problem solution


    if($i==29) {
        header("location:uok_forms.php");
    }



}
