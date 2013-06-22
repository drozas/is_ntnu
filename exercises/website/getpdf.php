<?php
	// start session
	session_save_path("/home/gr16/tmp");
	session_name("GR16");
	session_start(); 

	if (!$_SESSION['auth'] == 1) {
	    	// check if authentication was performed
		// else die with error
	 	die ("ERROR: Unauthorized access!");
	}else { 
		//if he has been already authenticated
		// We'll be outputting a PDF
		header('Content-type: application/pdf');

		// It will be called labReport.pdf
		header('Content-Disposition: attachment; filename="labReport.pdf"');

		// The PDF source is in original.pdf
		readfile($_ENV["HOME"]. '/lab_journal/temporal_lab_journal.pdf');
	}
?>
