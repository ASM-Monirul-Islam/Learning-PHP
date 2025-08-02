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
	$name = $email = $gender = $password = $confirmPassword = "";
	$nameErr = $emailErr = $genderErr = $passwordErr = $confirmPasswordErr = $finalMessage = "";
	if($_SERVER["REQUEST_METHOD"]=="POST") {
		$name = test_input($_POST["name"]);
		$email = test_input($_POST["email"]);
		$password = test_input($_POST["password"]);
		$confirmPassword = test_input($_POST["confirmPassword"]);
		$gender = isset($_POST["gender"]) ? test_input($_POST["gender"]) : "";

		$isValid = true;

		// Name validation

		if(empty($name)) {
			$nameErr = "Name is required!";
			$isValid = false;
		} else if(strlen($name)<3) {
			$nameErr = "Name should contain at least 3 characters!";
			$isValid = false;
		} else {
			$nameErr = "";
		}

		// Email Validation

		if(empty($email)) {
			$emailErr = "Email is required!";
			$isValid = false;
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format!";
			$isValid = false;
		} else {
			$emailErr = "";
		}

		// Gender Validation

		if(empty($gender)) {
			$genderErr = "Please select your gender!";
			$isValid = false;
		} else {
			$genderErr = "";
		}

		// Password Validation

		if(empty($password)) {
			$passwordErr = "Enter your Password!";
			$isValid = false;
		} else if(!preg_match("/[A-Z]/", $password)) {
			$passwordErr = "Password must contain one upper class character!";
			$isValid = false;
		} else if(!preg_match("/[a-z]/", $password)) {
			$passwordErr = "Password must contain one lower class character!";
			$isValid = false;
		} else if(!preg_match("/[!@#$%^&*]/", $password)) {
			$passwordErr = "Password must contain one special character!";
			$isValid = false;
		} else if(!preg_match("/[0-9]/", $password)) {
			$passwordErr = "Password must contain one number!";
			$isValid = false;
		} else {
			$passwordErr = "";
		}

		// Confirm Password Validation

		if($password !== $confirmPassword) {
			$confirmPasswordErr = "Passwords do not match!";
			$isValid = false;
		} else {
			$confirmPasswordErr = "";
		}

		// Final Message
		if($isValid) {
			$finalMessage = "Submitted Successfully!";
			$FinalMessageStatus = "success";
		} else {
			$finalMessage = "Please check your inputs!!!";
			$FinalMessageStatus = "error";
		}

	}

	function test_input($data){
		return htmlspecialchars(stripslashes(trim($data)));
	}



	?>
	


	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method = "post">
		Name: <input type="text" name="name" class="input" value="<?php echo $name ?>">
		<span class="error"><?php echo $nameErr ?></span>
		Email: <input type="email" name="email" class="input" value="<?php echo $email ?>">
		<span class="error"><?php echo $emailErr ?></span>
		<div class="gender-section">
			Gender:
			<input type="radio" name="gender" class="gender" value="Male" <?php if($gender == "Male") echo "checked" ?>>Male
			<input type="radio" name="gender" class="gender" value="Female" <?php if($gender == "Female") echo "checked" ?>>Female
			<input type="radio" name="gender" class="gender" value="Other" <?php if($gender == "Other") echo "checked" ?>>Other
		</div>
		<span class="error"><?php echo $genderErr ?></span>
		Password: <input type="password" name="password" class="input" value="<?php echo $password ?>">
		<span class="error"><?php echo $passwordErr ?></span>
		Confirm Password: <input type="password" name="confirmPassword" class="input" value="<?php echo $confirmPassword ?>">
		<span class="error"><?php echo $confirmPasswordErr ?></span>
		<button type="submit">Submit</button>
		<span class="<?php echo $FinalMessageStatus ?>"><?php echo $finalMessage ?></span>
	</form>
</body>
</html>