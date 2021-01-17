<!DOCTYPE HTML>
<head>
    <title>Student Details - BadTool</title>
    <link rel="stylesheet" href="../styles/gen_styles.css"/>
</head>
<body>
    <section id="main">
        <?php
        /**
         * Created by PhpStorm.
         * User: hm
         * Date: 4/16/2020
         * Time: 5:58 AM
         */
        //get the form page back here
        require_once "std-details-form.php";

        $api = "http://kashmiruniversity.net/MobileAPIWrapper/api/";
        $basicDetails = "Student/GetStudentDetail/";
        $examDetails = "Student/GetStudentExamDetail/";
        $apiKey = "BBA4089E-40ED-4245-9F71-D0476501A580";
        $param = "?regno=";
        //now create url
        $base_url = $api . $basicDetails . $apiKey . $param;
        //take the form data
        @$regno = $_POST['regno'];
        //create final url
        $url = $base_url . $regno;
        //echo $url . "<br />";
        //create studentExamDetailsUrl
        $studentExamDetailsUrl = $api . $examDetails . $apiKey . $param . $regno;
        //echo $studentExamDetailsUrl;

        @$raw_std_dtls = file_get_contents($url);
        //echo $std_dtls . "<br />";
        //convert the json object returned from server to php object
        $std_dtls = json_decode($raw_std_dtls);
        /*  check if convert
        echo $std_dtls->RegistrationNo;
        echo $std_dtls->Name;
        echo $std_dtls->Parentage;
        echo $std_dtls->DOB;
        */


        ?>
        <br />
        <section id="std_dtls">
            <section id="label">
                <strong class="std_dtls_label">Registration No.:</strong>
                <strong class="std_dtls_out"><?php echo $std_dtls->RegistrationNo; ?>
            </section>
            <section id="label">
                <strong class="std_dtls_label">Name:</strong>
                <strong class="std_dtls_out"><?php echo $std_dtls->Name; ?>
            </section>
            <section id="label">
                <strong class="std_dtls_label">Parentage:</strong>
                <strong class="std_dtls_out"><?php echo $std_dtls->Parentage; ?>
            </section>
        </section>
        <br />
        <?php
        //student exam details
        $stdExamDetails_raw = file_get_contents($studentExamDetailsUrl);
        $stdExamDetails = json_decode($stdExamDetails_raw, true);
        echo "<section id='stdExamDtls'><table border='1' class='std_table_dtls'>";
        echo "<tr><td style='text-align: center' colspan='2'>Reg. No.</td><td style='text-align: center' colspan='2'>Reg/Pvt</td><td style='text-align: center' colspan='2'>Stream</td><td style='text-align: center' colspan='2'>Univ/Board</td><td style='text-align: center' colspan='2'>Session</td>";
        echo "<td style='text-align: center' colspan='2'>Roll No.</td><td style='text-align: center' colspan='2'>Result</td><td style='text-align: center' colspan='2'>Result Details</td></tr>";
        foreach ($stdExamDetails as $row){
            echo "<tr>";
            foreach ($row as $item) {
                echo "<td style='text-align: center' colspan='2'>" . $item . "</td>";
            }
            echo "</tr>";
        }
        echo "</table></section>";
        ?>
    </section>
</body>
