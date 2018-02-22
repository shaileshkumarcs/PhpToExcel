<?php
	$servername= "localhost"; //your MySQL Server
	$username = "root"; //your MySQL User Name
	$password = "root"; //your MySQL Password
	$dbname = "api_db";
	//your MySQL Database Name of which database to use this 
	$tablename = "products"; //your MySQL Table Name which one you have to create excel file 
	// your mysql query here , we can edit this for your requirement
	$setSql = "Select * from $tablename "; 
	//create  code for connecting to mysql

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	} 

	$setRec = $conn->query($setSql);
		$setCounter = 0;

		$setExcelName = "download_excal_file";

		//$setSql = "YOUR SQL QUERY GOES HERE";

		//$setRec = mysql_query($setSql);
		//print_r($setRec);exit;
		$setCounter = mysqli_num_fields($setRec);
		//echo $setCounter; exit;

		for ($i = 0; $i < $setCounter; $i++) {

		    //$setMainHeader .= mysql_field_name($setRec, $i)."t";
		    $setMainHeader.= mysqli_fetch_field_direct($setRec, $i)->name . "\t";

		}

		while($rec = mysqli_fetch_row($setRec))  {

		  $rowLine = '';

		  foreach($rec as $value)       {

		    if(!isset($value) || $value == "")  {

		      $value = "\t";

		    }   else  {

		//It escape all the special charactor, quotes from the data.

		      $value = strip_tags(str_replace('"', '""', $value));

		      $value = '"' . $value . '"' . "\t";

		    }

		    $rowLine .= $value;

		  }

		  $setData .= trim($rowLine)."\n";

		}

		  $setData = str_replace("\r", "", $setData);

		 

		if ($setData == "") {

		  $setData = "nno matching records foundn";

		}


		$setCounter = mysqli_num_fields($setRec);


		//This Header is used to make data download instead of display the data

		 header("Content-type: application/octet-stream");

		header("Content-Disposition: attachment; filename=".$setExcelName."_Reoprt.xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		//It will print all the Table row as Excel file row with selected column name as header.

		echo ucwords($setMainHeader)."\n".$setData."\n";


?>