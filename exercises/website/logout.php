<?php
	session_save_path("/home/gr16/tmp");
	session_name("GR16");
	// initialize a session
	session_start();

	// then destroy it
	session_destroy();

?> 
<!--Automatic redirection to the main page-->
<HEAD>
<SCRIPT language="JavaScript">
<!--
window.location="index.html";
//-->
</SCRIPT>
</HEAD>
