<?php
session_start();

// variable declaration
$username = "";
$email    = "";
$errors = array();
$_SESSION['success'] = "";

#################################################
############  Connect to database  ##############
#################################################

function connect_to_database()
{
	$db = mysqli_connect('localhost', 'root', '"K*d0e=A', 'wakoky');
	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}
	return ($db);
}

$db = connect_to_database();

#################################################
############  Functions utils      ##############
#################################################

function exec_query($query, $db)
{
	return (mysqli_query($db, $query));
}

#################################################
############     Register User     ##############
#################################################

if (isset($_POST['reg_user'])) {
	// receive all input values from the form
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username))
		array_push($errors, "Username is required");
	if (empty($email))
		array_push($errors, "Email is required");
	if (empty($password_1))
		array_push($errors, "Password is required");

	$result = exec_query("SELECT * FROM users WHERE username='$username'", $db);
	if (mysqli_num_rows($result) == 1)
		array_push($errors, "Username used");

	$result = exec_query("SELECT * FROM users WHERE email='$email'", $db);
	if (mysqli_num_rows($result) == 1)
		array_push($errors, "Email used");

	if ($password_1 != $password_2)
		array_push($errors, "The two passwords do not match");

	if (count($errors) == 0) {
		$password = md5($password_1); //encrypt the password before saving in the database
		$result = exec_query("INSERT INTO users (username, email, password) 
					  VALUES('$username', '$email', '$password')", $db);
		$result = exec_query("SELECT id FROM users WHERE username='$username'", $db);
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['user_id'] = $row["id"];
		}
		$_SESSION['username'] = $username;
		$_SESSION['success'] = "You are now logged in";
		$_SESSION['actual_playlist'] = [];
		header('location: index');
	}
}

#################################################
############       Login User      ##############
#################################################

if (isset($_POST['login_user'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (empty($username))
		array_push($errors, "Username is required");
	if (empty($password))
		array_push($errors, "Password is required");

	if (count($errors) == 0) {
		$password = md5($password);
		$result = exec_query("SELECT * FROM users WHERE username='$username' AND password='$password'", $db);
		if (mysqli_num_rows($result) == 1) {
			$_SESSION['username'] = $username;
			$row = mysqli_fetch_assoc($result);
			$_SESSION['user_id'] = $row["id"];
			$_SESSION['success'] = "You are now logged in";
			$_SESSION['actual_playlist'] = [];
			header('location: index');
		} else
			array_push($errors, "Wrong username/password combination");
	}
}
