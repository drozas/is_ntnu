<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>signup.php</title>
<?php
function isValidUser($connection, $user, $password)
{

	// create query
	$query = 'SELECT * FROM users_test WHERE user="' . $user . '"';

	// execute query
	$result = mysqli_query($connection, $query) or die (mysqli_error($connection));

	//get password value
	if (mysqli_num_rows($result) == 1) 
	{
		$row = mysqli_fetch_row($result);

		return $row[1]==$password;

	}
	else{
		return false;
	}

	//free result set memory
	mysqli_free_result($result);


}
?>
</head><body>
<br>
<?php 
	if(isset($_POST['user']) && isset($_POST['pass']))
	{
		if($_POST['user']=="" || $_POST['pass']=="")
		{
			//echo 'Missing username or password<br>';
		}else{
			//TODO: is it possible to put it in another file with different privileges?
			$host = "localhost";
			$user = "gr16";
			$pass = "K9e7Gs6j";
			$db = "dbgr16";


			// open connection
			$connection = mysqli_connect($host, $user, $pass, $db) or die ("Unable to connect!");

			if (isValidUser($connection,$_POST['user'],$_POST['pass']) )
			{

				// create session and set cookie with username
				session_start();
				$_SESSION['auth'] = 1;
				setcookie("user", $_POST['user'], time()+(84600*30));

				echo '<a href = "getpdf.php"> "click here to get our lab journal" </a><b>';

			}else{
				echo 'where do you think you are going?!<b>';
			}

			// close connection
			mysqli_close($connection);
		}
		
	}	
?>
</body></html>
