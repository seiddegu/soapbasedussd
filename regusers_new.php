<?php

$reg_replay_msg = "You have registered successfully: ";
//get keyword

$keyword = $_REQUEST["keyword"];
$sender =  $_REQUEST["sender"];
//echo $sender;

//connect to a databse
$servername = "localhost";
$username = "eagles";
$password = "pass@2017";
$dbname = "eagles";

$jobs_per_sms = 3;
$total_rec = 0;

$jobLevel_list = {"BSC","BA","MSC","PHD","MD"};

if(strlen($sender)==12)
	{ 
		$sender = "+". $sender;
		//echo $sender; 
	}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//check keyword for correction 
//echo $keyword;
if (preg_match("/^([a-zA-Z]{3})\*([a-zA-Z]{3})\*([0-9]{1,2})$/", $keyword, $match))
{

$job_cat = strtoupper($match[1]);
$job_lev = strtoupper($match[2]);
$job_exp = strtoupper($match[3]);

$sql_chkjobCategory = "select code,Details from jobCategory where code = '$job_cat'";
$sql_chkjobLevel = "select code from jobLevel where code = '$job_lev'";
$sql_chkjobExp = "select code from jobExperiance where code = '$job_exp'";
 
$r_jc = $conn->query($sql_chkjobCategory);
//$r_jl = $conn->query($sql_chkjobLevel);
$r_jl = in_array($job_lev, $jobLevel_list);
//$r_je = $conn->query($sql_chkjobExp);
(intval($job_exp) < 30)? $r_je=True:$j_re=False;
 if ($r_jc->num_rows >0) {$chk_jobCate = True; echo "Valid jobCategory!!!"; $Details = $r_jc->fetch_assoc(); echo $Details["Details"];} else {echo "Invalid Job Category, for Help please send C to 8801";}
 if ($r_jl) {$chk_jobLevel = True; } else {echo "Invalid Job Level, for Help please send L to 8801";}
 if ($r_je) {$chk_jobExp = True; } else {echo "Invalid Job Experiance, for Help please send E to 8801";}


//echo $match[0];
//register to user profile

if ( $chk_jobCate && $chk_jobLevel && $chk_jobExp )
{
$sql_reg2profile = "INSERT INTO `userProfile` (`id`, `mobile`, `jobCategory`, `jobLevel`, `jobExperiance`, `remark`) VALUES (NULL, '$sender', '$job_cat', '$job_lev', '$job_exp', '$keyword')";

$reg2profile = $conn->query($sql_reg2profile);

if($reg2profile) { echo "Profile Registration successfully done.... !!!";}

//send replay 
$reg_replay_msg .= "<br>" . " Category: $job_cat <br> Level: $job_lev <br> Experiance: $job_exp years<br> you can get job posts by sending A to 8801.";
echo $reg_replay_msg;
}


}
else
{

	echo "Invalid Registration format , please send using correct format: Category*Level*Experiance <br>E.g For accounting with BA degree and Experiance 0 year send: <br>ACC*BA*0";
}
?>