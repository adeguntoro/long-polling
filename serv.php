<?php
	$con = mysqli_connect("localhost", "root", "")or die(mysqli_error($con));
	mysqli_select_db($con, "longpoll")or die(mysqli_error($con));
	
	
	//create response array
	$response = array();
	//by default set to error
	$response['success'] = 1;
	
	$iter = 0;
	do{
		//query for new rows
		$res = mysqli_query($con, "select * from message where `read`=0 and `user`!=".$_POST['user'])or die(mysqli_error($con));
		if(mysqli_num_rows($res) > 0){
			//mark them read
			mysqli_query($con, "update message set `read`=1 where `read`=0")or die(mysqli_error($con));
			
			//set to success
			$response['success'] = 0;
			$temp = array();
			for($i=0 ; $row = mysqli_fetch_assoc($res) ; ++$i){
				$temp[$i] = $row;
			}
			$response['feed'] = $temp;
			break;
		}
		//sleep for 5 secs to check for update
		sleep(5);
		++$iter;
	}while($iter < 3);//just check for 3 times, i.e 15 sec ... else respond with success=1

	mysqli_close($con);
	echo json_encode($response);
?>