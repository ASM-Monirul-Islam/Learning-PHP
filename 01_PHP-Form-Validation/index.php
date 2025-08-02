<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<?php
	$name = $email = $pass = $confirmPass = $gender = "";
	$nameErr = $emailErr = $passErr = $finalErr = $confirmPassErr = $genderErr = "";


	if($_SERVER["REQUEST_METHOD"]=="POST") {
		$isValid = true;
		$name = test_input($_POST["name"]);
		$email = test_input($_POST["email"]);
		$pass = test_input($_POST["pass"]);
		$confirmPass = test_input($_POST["confirmPass"]);
		if(isset($_POST["gender"])) {
			$gender = test_input($_POST["gender"]);
		} else {
			$gender = "";
		}

		// Name validation

		if(empty($name)) {
			$nameErr = "Name is required!";
			$isValid = false;
		} else if(strlen($name)<3) {
			$nameErr = "Name should be at least 3 characters!";
			$isValid = false;
		}
		else {
			$nameErr = "";
		}

		// email validation
		if(empty($email)) {
			$emailErr = "Email is required!";
			$isValid = false;
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr ="Invalid email format";
			$isValid = false;
		} else {
			$emailErr = "";
		}

		// gender validation

		if(empty($gender)) {
			$genderErr = "Please select your gender!";
			$isValid = false;
		} else {
			$genderErr = "";
		}

		// pass validation

		if(empty($pass)) {
			$passErr = "Password is required!";
			$isValid = false;
		} else if(strlen($pass)<6) {
			$isValid = false;
			$passErr = "Password should contain at least 6 characters!";
		} else if(!preg_match("/[A-Z]/", $pass)) {
			$isValid = false;
			$passErr = "Password must contain at least one UpperCase character!";
		} else if(!preg_match("/[a-z]/", $pass)) {
			$isValid = false;
			$passErr = "Password should contain at least one LowerCase character!";
		} else if(!preg_match("/[!@#$%^&*]/", $pass)) {
			$isValid = false;
			$passErr = "Password should contain at least one special character!";
		} else if(!preg_match("/[0-9]/", $pass)) {
			$isValid = false;
			$passErr = "Password should contain at least one number!";
		} else {
			$passErr = "";
		}

		// Confirm Pass validation

		if($confirmPass !== $pass) {
			$isValid = false;
			$confirmPassErr = "Passwords do not match!";
		} else {
			$confirmPassErr = "";
		}

		// Final msg
		if($isValid) {
			$finalErr = "Submitted Successfully!";
			$finalStatus = "success";
		} else {
			$finalErr = "Invalid Input!";
			$finalStatus = "error";
		}

	}
	function test_input($data) {
		return htmlspecialchars(stripslashes(trim($data)));
	}
	?>

	<form action="<?php echo htmlspecialchars ($_SERVER["PHP_SELF"])?>" method="post">
		Name: <input type="text" name="name" class="input">
		<span class="error"><?php echo $nameErr ?></span>
		Email: <input type="email" name="email" class="input">
		<span class="error"><?php echo $emailErr ?></span>
		<div class="gender-section">
			Gender: 
			<input type="radio" name="gender" class="radio-input" value="Male">Male
			<input type="radio" name="gender" class="radio-input" value="Female">Female
			<input type="radio" name="gender" class="radio-input" value="Other">Other
		</div>
		<span class="error"><?php echo $genderErr ?></span>
		Password: <input type="password" name="pass" class="input">
		<span class="error"><?php echo $passErr ?></span>
		Confirm Password: <input type="password" name="confirmPass" class="input">
		<span class="error"><?php echo $confirmPassErr ?></span>
		<button type="submit">Submit</button>
		<span class="<?php echo $finalStatus ?>"><?php echo $finalErr ?></span>
	</form>
</body>
</html>