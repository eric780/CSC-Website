<?php
	
	//MYSQL connection details
	$servername = "cornellstrategiccons.ipagemysql.com";
	$username = "csc";
	$password = "Cornellcsc2016!";
	$dbname = "applicants_2015";

	$response_array;

	//file upload (resume)
	$upload_dir = "./uploads/";
	$uploadfile;
	if(empty($_FILES['resume']['name'])){
		$uploadfile = "No resume uploaded.";
		$response_array['file_upload_status'] = "success";
	}
	else{
		$uploadfile = $upload_dir . basename( $_FILES['resume']['name']);

		if(move_uploaded_file($_FILES['resume']['tmp_name'], $uploadfile)){
			$response_array['file_upload_status'] = "success";
		}
		else{
			$response_array['file_upload_status'] = "failed";
		}
	}
	

	//application vars
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$netid = $_POST["netid"];
	$year = $_POST["year"];
	$college = $_POST["college"];
	$major = $_POST["major"];
	$gpa = $_POST["gpa"];


	//create mysql connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//check connection
	if ($conn -> connect_error){
		die("Connection failed: " . $conn->connect_error);
		$response_array['applicant_status'] = "failed";
	}
	//insert entry
	$sql = "REPLACE LOW_PRIORITY INTO Applicants(FirstName, LastName, NetID, Year, College, Major, GPA, ResumeFile) VALUES (";
	$sql .= "'" . $firstname . "', ";
	$sql .= "'" . $lastname . "', ";
	$sql .= "'" . $netid . "', ";
	$sql .= "'" . $year . "', ";
	$sql .= "'" . $college . "', ";
	$sql .= "'" . $major . "', ";
	$sql .= "'" . $gpa . "', ";
	$sql .= "'" . $uploadfile . "');";

	if($conn -> query($sql) === TRUE){
		$response_array['applicant_status'] = "success";
	}	
	else{
		$response_array['applicant_status'] = "error: " . $sql . "<br>" . $conn->error;
	}
	$conn -> close();

	
	//send response to client
	header('Content-type: application/json');
	echo json_encode($response_array);


	//Send confirmation email to netid email address
	$confirmationaddress = $netid . "@cornell.edu";
	$message = "Dear " . $firstname . " " . $lastname . ", \r\n \r\n";
	$message .= "This message is to confirm that you have applied to Cornell Strategic Consulting. ";
	$message .= "We thank you for your application, and will get back to you soon! \r\n \r\n";
	$message .= "Best, \r\n \r\nCornell Strategic Consulting";

	mail($confirmationaddress, "CSC Application Confirmation", $message);

?>
