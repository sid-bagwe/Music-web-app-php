<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<meta charset="utf-8">
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
		<link rel="stylesheet" type="text/css" href="../index.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	  	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
	  	
	</head>
	<style type="text/css">
		a:hover, a:active {
		  background-color: #00000000;
		  color: white;
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
		.blur
		{
            filter:blur(5px);
        }
	</style>
	<body onload="welcome()">
		<div class="container-fluid p-0">
			<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #17A2B8;">
				<img class="rounded-circle" src="../logo.jpg" alt="Logo" style="width: 30px;">
				<a class="navbar-brand ml-2" href="index.php">Music Website</a>
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
										<a class=\"nav-link text-warning\" href=\"login.php\">Login</a>
									</li>
									<li class=\"nav-item mx-3\">
										<a class=\"nav-link active text-warning\" href=\"signup.php\">Register</a>
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
			</nav>
		</div>
		<?php
		include_once("../config.php");
		$show_modal = false;
		$username_err = $name_err = $password_err = $dob_err = $confirm_password_err = "";
		if (isset($_POST['signup'])) {
			// Check if username is empty
			if(empty(trim($_POST["username"]))){
				$username_err = "Username cannot be blank";
			} else {
				// Check for password
				if(empty(trim($_POST['password']))){
					$password_err = "Password cannot be blank";
				}
				elseif(strlen(trim($_POST['password'])) < 5){
					$password_err = "Password cannot be less than 5 characters";
				}
				
				else{
					$password = trim($_POST['password']);
				}

				// Check for name
				if(empty(trim($_POST['name']))){
					$name_err = "Name cannot be blank";
				}

				// Check for name
				if(empty(trim($_POST['date']))){
					$dob_err = "Date cannot be blank";
				}

				// Check for confirm password field
				if(trim($_POST['password']) !=  trim($_POST['confirm-password'])){
					$confirm_password_err = "Passwords should match";
				}

				// Check if Username already taken
				$sql = "SELECT id FROM users WHERE username = ?";
				$stmt = mysqli_prepare($mysqli, $sql);
				if($stmt)
				{
					mysqli_stmt_bind_param($stmt, "s", $param_username);

					// Set the value of param username
					$param_username = trim($_POST['username']);

					// Try to execute this statement
					if(mysqli_stmt_execute($stmt)){
						mysqli_stmt_store_result($stmt);
						if(mysqli_stmt_num_rows($stmt) == 1)
						{
							$username_err = "Username entered is already taken. Please enter a new username"; 
						}
						else{
							$username = trim($_POST['username']);
						}
					}
					else{
						echo "Something went wrong";
					}
				}

				if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
					$name = $_POST['name'];
					$email = $_POST['email'];
					$date = $_POST['date'];
					$genre = $_POST['genre'];
					$username = $_POST['username'];
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				// echo $name; 
				// echo $email; 
				// echo $phonenumber;
				if (isset($_POST["name"])) {
					$result = mysqli_query($mysqli, "INSERT INTO users(name, email, username, password, dob, genre) VALUES('$name', '$email', '$username', '$password', '$date', '$genre')");
					if (mysqli_affected_rows($mysqli) > 0) {
						echo "
						<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
							<strong>Hello ". $_POST["name"] ."!</strong> You have signed up successfully. Please login to access the website.
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
							<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						";
					}
				}
				} else {
					if (!empty($username_err)) {
						echo "
						<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
							<strong>". $username_err ."!</strong> Error Occured.
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
							<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						";
					} 
					if (!empty($confirm_password_err)) {
						echo "
						<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
							<strong>". $confirm_password_err ."!</strong> Error Occured.
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
							<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						";
					}
					if (!empty($password_err)) {
						echo "
						<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
							<strong>". $password_err ."!</strong> Error Occured.
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
							<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						";
					}
				}
			}
        }
	?>
	<div>
		<div class="modal-dialog">
			<div class="main-section">
				<div class="modal-content">
					<div class="user-img">
						<img src="../logo.jpg" class="rounded-circle" style="height: 120px; width: 120px;">
					</div>
					<div class="form-input">
						<h3 style="color: black">REGISTER</h3>
						<form id="signup" method="POST" action="signup.php" enctype="multipart/form-data">
							<div class="form-group">
								<input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
								<small></small>
							</div>
							<div class="form-group">
								<input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
								<small></small>
							</div>
							<!-- <div class="form-group">
								<input type="number" name="phonenumber" id="phonenumber" class="form-control" placeholder="Phone Number" required>
								<small></small>
							</div> -->
							<div class="form-group">
								<label for="date">Date Of Birth</label>
								<input type="date" name="date" id="date" class="form-control" value="2000-01-01" required>
							</div>
							<div class="form-group">
								<label for="genre">Select your Favourite Genre:</label>
								<select name="genre" id="genre" onchange="favgenre()">
									<option value="Indie">Indie</option>
									<option value="Romance">Romance</option>
									<option value="Party">Party</option>
									<option value="Classical">Classical</option>
									<option value="Instrumental">Instrumental</option>
								</select>
								<p id="demo"></p>
							</div>
							<div class="form-group">
								<input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
								<small></small>
								<p class="text-danger font-weight-bold"> <?php echo $username_err ?></p>
							</div>
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
								<small></small>
								<p class="text-danger font-weight-bold"> <?php echo $password_err ?></p>
							</div>
							<div class="form-group">
								<input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="Confirm Password" required>
								<small></small>
								<p class="text-danger font-weight-bold"> <?php echo $confirm_password_err ?></p>
							</div>	
							<br><button onmouseover="zoom(this)" onmouseout="out(this)" type="submit" name="signup" class="btn btn-success btn-lg">Sign Up <i class="bi bi-upload"></i></i></button>
							<button onmouseover="zoom(this)" onmouseout="out(this)" type="reset" name="reset" class="btn btn-warning btn-lg">Reset <i class="bi bi-trash"></i></i></button>
							<div class="form-group">
								<p>Already Have An Account ? <a style="color: blue" href="login.php">Login Here</a></p>
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
		<script>
			const blurbtn=document.querySelector('.blurred button')
            blurbtn.addEventListener('click',()=>{
                document.querySelector('body').classList.toggle('blur');
                console.log('Blurred Out Background')
            });
			const checkEmail = () => {
			let valid = false;
			const email = emailEl.value.trim();
			if (!isRequired(email)) {
				showError(emailEl, 'Email cannot be blank.');
			} else if (!isEmailValid(email)) {
				showError(emailEl, 'Email is not valid.')
			} else {
				showSuccess(emailEl);
				valid = true;
			}
			console.log("check email function");
			return valid;
		};
		const isEmailValid = (email) => {
			const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		};
		</script>
		<script src="form.js"></script>
	</body>
</html>
