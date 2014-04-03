<?php
	//create connection to mysql
	$con = mysqli_connect("localhost", "root", "")or die(mysqli_error($con));
	mysqli_select_db($con, "longpoll")or die(mysqli_error($con));
	
	
	//create response array
	$response = array();
	//by default set to error
	$response['success'] = 1;
	
	if(mysqli_query($con, "insert into message (`user`, `text`) VALUES('".$_POST['user']."', '".$_POST['text']."')")){
		$response['success'] = 0;
	}

	//close connection
	mysqli_close($con);
	
	//print response
	echo json_encode($response);
?>