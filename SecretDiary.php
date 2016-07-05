<?php
if($_POST['submit']){
	if(!$_POST['email']){
	$error.="<br />Please enter your email";
	}
	else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	$error.="<br />Please enter a valid email address"; 
	} 

	if(!$_POST['password']){
	$error.="<br />Please enter your password";
	}
	else{
	if(strlen($_POST['password'])<8) $error.="<br />Please enter password of length more than 8";
	if(!preg-match('`[A-Z]`',$_POST['password'])) $error.="<br />Please include at least one capital letter in your password";
	}
	if($error){ echo "<br />There were error(s) in your signup details:".$error;}
	else{
	$link = mysqli_connect("localhost", "cl60-example-ai3", "f-rdz^r9h", "cl60-example-ai3");
	$query = "SELECT * FROM users WHERE email="'.mysqli_real_escape_string($link, $_POST['email']).'"";
	$result=mysqli_query($link, $query);
	echo $results=mysqli_num_rows($result);
	
	if($results){
	echo "That email is already registered. Do you want to log in?";
	}
	else{
	$query = "INSERT INTO `users` (`email`, `password`) VALUES('".mysqli_real_escape_string($link, $_POST['email'])."', md5(md5($_POST['email']).$_POST['password'])"')";
	mysqli_query($link, $query);
	echo "You have been signed up!";
	}
	}
	

?>

<form method="post">
	<input type="email" name="email" placeholder="Email" />
	<input type="password" name="password" placeholder="Password"/>
	<input type="submit" value="sign Up" name="submit" />
</form>