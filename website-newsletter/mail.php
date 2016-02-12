<?php

if($_POST['email']) {

	echo $_POST['email'];
	die();

	header("Location: index.html");
} else {
	header("Location: confirmation.html");	
}
