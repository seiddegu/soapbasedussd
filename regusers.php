<?php

$reg_replay_msg = "You have registered successfully: ";
//get keyword

$keyword = urldecode($_GET["keyword"]);
$sender = $_GET["sender"];

//check keyword for correction 
//echo $keyword;
if (preg_match("/^([a-zA-Z]{3})\*([a-zA-Z]{3})\*([0-9]{1,2})$/", $keyword, $match))
{

$job_cat = strtoupper($match[1]);
$job_lev = strtoupper($match[2]);
$job_exp = strtoupper($match[3]);


//echo $match[0];
//register to user profile

//send replay 
$reg_replay_msg .= "<br>" . " Category: $job_cat <br> Level: $job_lev <br> Experiance: $job_exp years<br> you can get job posts by sending A to 8801.";
echo $reg_replay_msg;
}
else
{

	echo "Invalid Registration format , please send using correct format: Category*Level*Experiance <br>E.g For accounting with BA degree and Experiance 0 year send: <br>ACC*BA*0";
}
?>