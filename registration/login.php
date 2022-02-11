<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<meta charset="utf-8">
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
		<link rel="stylesheet" type="text/css" href="../index.css">
		<script src="form.js"></script>
	</head>
	<style type="text/css">
		a:hover, a:active {
		  background-color: #00000000;
		  color: white;
		}

		.main-section 
		{
		  margin:0 auto;
		  margin-top: 50px;
		  padding:0;
		}

		.modal-dialog
		{
		  text-align: center;
		}

		.modal-content
		{
		  background-image: linear-gradient(#07b377, #f9ff3d);
		  padding:0 18px;
		  border-radius: 20px;
		}
		.user-img
		{
		  margin-top: -40px;
		  margin-bottom: 20px;
		}

		.form-group1 input
		{
		  margin-bottom: 10px;
		}

		.form-input button
		{
		  width: 30%;
		  margin: 5px 0 25px;
		}
	</style>
	<body>
	<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: ../index.php");
    exit;
}
include_once "../config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


	if(empty($err))
	{
		$sql = "SELECT id, username, password FROM users WHERE username = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "s", $param_username);
		$param_username = $username;
		
		
		// Try to execute this statement
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) == 1)
			{
				mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
				if(mysqli_stmt_fetch($stmt))
				{
					if(password_verify($password, $hashed_password))
					{
						// this means the password is correct. Allow user to login
						session_start();
						$_SESSION["username"] = $username;
						$_SESSION["id"] = $id;
						$_SESSION["loggedin"] = true;

						//Redirect user to home page
						header("location: ../index.php");
						
					}
				}

			}

		}
	}    
}
	?>


		<div class="container-fluid p-0">
			<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #17A2B8;">
				<img class="rounded-circle" src="../logo.jpg" alt="Logo" style="width: 30px;">
				<a class="navbar-brand ml-2" href="../index.php">Music Website</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav ml-auto">
			<!-- <li class="nav-item mx-3">
				<a class="nav-link" href="addSong.php">Add a Song <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item mx-3">
				<a class="nav-link" href="allSongs.php">Show All Songs</a>
			</li>
			<li class="nav-item mx-3">
				<a class="nav-link text-warning" href="registration/login.php">Login</a>
			</li>
			<li class="nav-item mx-3">
				<a class="nav-link text-warning" href="registration/signup.php">Register</a>
			</li> -->
			<?php

					// if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
					// {
					// 	header("location: registration/login.php");
					// }

					if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
						echo "<li class=\"nav-item mx-3\">
								<a class=\"nav-link active text-warning\" href=\"login.php\">Login</a>
							</li>
							<li class=\"nav-item mx-3\">
								<a class=\"nav-link text-warning\" href=\"signup.php\">Register</a>
							</li>
								";
					} else {
						echo "<li class=\"nav-item mx-3\">
							<a class=\"nav-link\" href=\"addSong.php\">Add a Song <span class=\"sr-only\">(current)</span></a>
						</li>
						<li class=\"nav-item mx-3\">
							<a class=\"nav-link\" href=\"allSongs.php\">Show All Songs</a>
						</li>
						<li class=\"nav-item mx-2\">
							<a href=\"registration/logout.php\"><button class=\"btn btn-warning\" type=\"submit\">Logout</button></a>
						</li>
					";
					}
					?>
			</ul>
				</div>
			</nav><br><br>
	</div>
	<div>
		<div class="modal-dialog">
			<div class="main-section">
				<div class="modal-content">
					<div class="user-img">
						<img src="../logo.jpg" class="rounded-circle" style="height: 120px; width: 120px;">
					</div>
					<div class="form-input" align="center">
						<h3 style="color: black">LOG IN</h3>
						<form action="login.php" method="POST">
							<div class="form-group">
								<input type="Username" name="username" class="form-control" placeholder="Username" required>
							</div>
							<div class="form-group">
								<input type="Password" name="password" class="form-control" placeholder="Password" required>
							</div>
							<div class="form-group">
								<a style="color: blue" href="#">Forgot Password ?</a>
							</div>
							<br><button type="submit" name="login" class="btn btn-success btn-lg">Log In <i class="bi bi-box-arrow-in-right"></i></button>
							<div class="form-group">
								<p>Don't Have An Account ? <a style="color: blue" href="signup.php">Register Here</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<article>
			<h3 style="text-align: center;"><b><i>ABOUT US</i></b></h3></div>
		<aside>
			<div style="display:inline-block;vertical-align:top;">
			    <img src="../logo.jpg" class="rounded-circle" style="height: 50px;width: 50px;">
			</div>
			<div style="display:inline-block;">
			    <div>MUSIC WEBSITE</div>
			    <div>AUTHOR : <em>ANSH M KHATRI</em></div>
			</div>
		</aside>
		<section>We are a team of 2 members who are trying to provide users with their favourite songs available online.</section>
		<p>Users can listen to any song they like as well create playlists of their favourite songs.</p>
		</article>
	</div>
	<div class="footer" align="center">
		<h4>Follow Us On </h4>
		<button type="button" class="btn btn-primary btn-lg"><i class="bi bi-facebook"></i></button>
		<button type="button" class="btn btn-primary btn-lg"><i class="bi bi-instagram"></i></button>
		<button type="button" class="btn btn-primary btn-lg"><i class="bi bi-twitter"></i></button>		
	</div>
	</body>
</html>
