<?php

if (isset($_POST['name']) || isset($_POST['pass'])) {
    // form submitted
    // check for required values
    if (empty($_POST['name'])) {
        die ("ERROR: Please enter username!");
    }
    if (empty($_POST['pass'])) {
        die ("ERROR: Please enter password!");
    }

	// set server access variables
	$host = "localhost";
	$user = "gr16";
	$pass = "K9e7Gs6j";
	$db = "dbgr16";

    // open connection
    $connection = mysqli_connect($host, $user, $pass,$db) or die ("Unable to connect!");
    
    // select database
    //mysqli_select_db($db) or die ("Unable to select database!");
    
    // create query
    $query = "SELECT * FROM users_test WHERE user = '" . $_POST['name'] . "' AND pass = '" . $_POST['pass'] . "'";
    
    // execute query
    $result = mysqli_query($connection,$query) or die ("Error in query: $query. " . mysqli_error($connection));
    
    // see if any rows were returned
    if (mysqli_num_rows($result) == 1) {
        // if a row was returned
        // authentication was successful
        // create session and set cookie with username
        session_start();
        $_SESSION['auth'] = 1;
        setcookie("username", $_POST['name'], time()+(84600*30));
	echo '<a href = "getpdf.php"> click here to get our lab journal<br> </a><b>';
	echo '<a href = "logout.php"> click here to logout<br></a><b>';
    }
    else {
        // no result
        // authentication failed
        echo "ERROR: Incorrect username or password!";
    }
    
    // free result set memory
    mysqli_free_result($result);
    
    // close connection
    mysqli_close($connection);
}
else {
    // no submission
    // display login form
?>
    <html>
    <head></head>
    <body>
    <center>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Username <input type="text" name="name" value="<?php echo $_COOKIE['username']; ?>">
    <p />
    Password <input type="password" name="pass">
    <p />
    <input type="submit" name="submit" value="Log In">
    </center>
    </body>
    </html>
<?php
}

?> 
