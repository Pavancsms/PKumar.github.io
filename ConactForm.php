<?php
	
if($_POST["submit"]){
	
	if(!$_POST['name']){
	$error.="<br />Please enter your name";
	}
	
	if(!$_POST['email']){
	$error.="<br />Please enter your email address";
	}
	
	if(!$_POST['comment']){
	$error.="<br />Please enter comment";
	}
	
	if ($_POST['email']!="" AND !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { 
    $error.="<br />Please enter a valid address"; 
	} 
	
	if($error){
	
	$result='<div class="alert alert-danger"><strong>There were error(s) in your form:</strong>'.$error.'</div>';
	}
	else
	{
	if(mail("pavancsms@gmail.com", "Test Mail!", "Name: ".$_POST['name']."
	
	Email: ".$_POST['email']."
	
	Comment: ".$_POST['comment'])){
	
	$result='<div class="alert alert-success"><strong>Thank you!</strong> I\'ll be in touch.</div>';
	}else{
	$result='<div class="alert alert-danger">Sorry, there was an error sending your message. Please try again later.</div>';
		}
	}
}	
?>

<!doctype html>
<html>
<head>
    <title>My First Webpage</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

	
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<style>
.emailForm {
border:1px solid grey;
border-radius:10px;
margin-top:20px;
}

form {
padding-bottom:20px;
}

</style>

</head>

<div class="container">

<div class="row">

<div class="col-md-6 col-md-offset-3 emailForm">
	<h1>My Email Form</h1>
	<br /><br />
	<?php echo $result; ?>
	<form method="post">
	<div class="form-group">
	<label for="name"><br /><br />Your Name: </label>
	<input name="name" type="text" class="form-control" value="<?php echo $_POST['name']?>" placeholder="Your Name" /><br /><br />
	</div>
	<div class="form-group">
	<label for="email">Email: </label>
	<input name="email" class="form-control" type="email" value="<?php echo $_POST['email']?>" placeholder="Email" /><br /><br />
	</div>
	<div class="form-group">
	<label for="comment">Comment: </label>
	<textarea class="form-control" name="comment"></textarea><br /><br />
	</div>
	<input name="submit" type="submit" class="btn btn-success btn-lg" value="Submit" />
	
	</form>
</div>
</div>
</div>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</html>