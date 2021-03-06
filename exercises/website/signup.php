<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>signup.php</title>
<?php

//If insert resquested, then perform the insertion
function checkInsertRequest($connection)
{
	$result_description = "";

	//Adding or deleting users
	if(isset($_POST['user_added']) && isset($_POST['pass_added']) && $_POST['user_added']!="" && $_POST['pass_added']!="")
	{
		$encrypt_pass = md5($_POST['pass_added']);
		$result_description .= "- Adding user " . $_POST['user_added'] . "...";
		//Adding an user to the database
		$query = 'INSERT INTO users_test VALUES ("' . $_POST['user_added'] . '","' . $encrypt_pass . '")';
		if (mysqli_query($connection, $query))
		{
			$result_description .= "OK<br>";
		}else{
			$result_description .= "Error in query: $query. ".mysqli_error($connection) . "<br>";
		} 
	}

	return $result_description;

}

//If delete resquested, then perform the deletion
function checkDeleteRequest($connection)
{
	$result_description = "";

	if(isset($_POST["user_deleted"]) && $_POST["user_deleted"]!="")
	{

		$result_description .= " - Deleting user " . $_POST['user_deleted'] . "...";
		//Deleting an user to the database
		$query = 'DELETE FROM users_test WHERE user = "'. $_POST["user_deleted"] .'"';

		//It returns 1 even if there was not any record deleted
		if (mysqli_query($connection, $query))
		{
			//But we check now how many rows where deleted
			if(mysqli_affected_rows($connection)>0)
			{
				$result_description .= "OK<br>";
			}else{
				$result_description .= "there was not user with this username<br>";
			}
		}else{
			$result_description .= "Error in query: $query. ".mysqli_error($connection) . "<br>";
		}
	}

	return $result_description;

}

//Create an HTML table with user values
function showTable($connection)
{

	// create query
	$query = "SELECT * FROM users_test";

	// execute query
	$result = mysqli_query($connection, $query) or die ("Error in query: $query. ".mysqli_error($connection));

	// see if any rows were returned
	if (mysqli_num_rows($result) > 0) {
	    //print current users
	    echo 'List of users<br>';
	    echo "<table cellpadding=10 border=1>";
	    while($row = mysqli_fetch_row($result)) {
		echo "<tr>";
		echo "<td>".$row[0]."</td>";
		echo "<td>".$row[1]."</td>";
		echo "</tr>";
	    }
	    echo "</table>";
	}
	else {
	    // no users registered
	    return " - The user table is empty<br>";
	}

	//free result set memory
	mysqli_free_result($result);
}						


function getForms()
{

	$aux .= 'Insert new username and password<br><form method="post" action="signup.php" name="add_user">User:&nbsp;<input name="user_added"><br>Password: <input name="pass_added" type="password"><br><input type="submit" value="Add user"></form><br><br>';


	$aux .='Insert username you want to delete<br><form method="post" action="signup.php" name="delete_user">User:&nbsp;<input name="user_deleted"><br><input type="submit" value="Delete user"></form><br><br>';

	return $aux;
}
?>

</head><body>
<br>
<?php 

	if( isset($_SERVER["SSL_CLIENT_S_DN_O"]) && isset($_SERVER["SSL_SERVER_S_DN_O"]) && isset($_SERVER["SSL_CLIENT_I_DN_O"]))
	{
		//Checking if it is an NTNU certificate
		if( ($_SERVER["SSL_CLIENT_S_DN_O"]== $_SERVER["SSL_SERVER_S_DN_O"])&& ($_SERVER["SSL_CLIENT_I_DN_O"] == $_SERVER["SSL_SERVER_S_DN_O"]) )
		{
			if(	isset($_SERVER["SSL_CLIENT_S_DN_OU"]) && isset($_SERVER["SSL_SERVER_S_DN_OU"]) 
				&& isset($_SERVER["SSL_CLIENT_I_DN_CN"]) && isset($_SERVER["SSL_CLIENT_S_DN_CN"]) )
			{
				//Checking if it is from telematics
				if($_SERVER["SSL_CLIENT_S_DN_OU"]==$_SERVER["SSL_SERVER_S_DN_OU"])
				{
					//Checking if is part of gr16 or from the staff
					if( ($_SERVER["SSL_CLIENT_I_DN_CN"]== "Staff CA")|| 
						( $_SERVER["SSL_CLIENT_S_DN_CN"]== "masse@stud.ntnu.no") ||$_SERVER["SSL_CLIENT_S_DN_CN"]== "davidro@stud.ntnu.no" )
					{
						echo getForms();

						$operations_status = "";
						//Set database server access variables
						//TODO: is it possible to put it in another file with different privileges?
						$host = "localhost";
						$user = "gr16";
						$pass = "K9e7Gs6j";
						$db = "dbgr16";

						// open connection
						$connection = mysqli_connect($host, $user, $pass, $db) or die ("Unable to connect!");


						$operations_status .= checkInsertRequest($connection);
						$operations_status .= checkDeleteRequest($connection);
						$operations_status .= showTable($connection);
						
						//Showing the status of the operations executed
						echo '<br><br><b>Status: <br>' . $operations_status .'</b>';

						// close connection
						mysqli_close($connection);

					}else{
						echo 'You do not have the right privileges, you do not belong to group 16 or staff<br>';
					}

				}else{
					echo 'You do not have the right privileges, you do not belong to telematics<br>';
				}
			}

		}
	}else {
		echo 'You do not have a ntnu certificate'; 
	}



?>

</body></html>
