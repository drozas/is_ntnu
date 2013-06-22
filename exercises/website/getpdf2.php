<?php
// start session
session_start(); 
if (!$_SESSION['auth'] == 1) {
    // check if authentication was performed
    // else die with error
    die ("ERROR: Unauthorized access!");
}
else { 
		// We'll be outputting a PDF
		header('Content-type: application/pdf');

		// It will be called downloaded.pdf
		header('Content-Disposition: attachment; filename="downloaded.pdf"');

		// The PDF source is in original.pdf
		readfile($_ENV["HOME"]. '/lab_journal/temporal_lab_journal.pdf');
}
?>
