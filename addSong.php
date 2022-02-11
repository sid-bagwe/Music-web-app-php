<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="index.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<style type="text/css">
		.col-5
		{
		  background-image: linear-gradient(#07b377, #f9ff3d);
		  padding:0 18px;
		  border-radius: 20px;
		}
</style>
<body>
	<?php
		//including the database connection file
		include_once("config.php");

		//fetching data in descending order (lastest entry first)
		//$result = mysql_query("SELECT * FROM users ORDER BY id DESC"); // mysql_query is deprecated
	?>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #17A2B8;">
		<img class="rounded-circle" src="logo.jpg" alt="Logo" style="width: 30px;">
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

					session_start();

					// if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
					// {
					// 	header("location: registration/login.php");
					// }

					if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
						echo "<li class=\"nav-item mx-3\">
								<a class=\"nav-link text-warning\" href=\"registration/login.php\">Login</a>
							</li>
							<li class=\"nav-item mx-3\">
								<a class=\"nav-link text-warning\" href=\"registration/signup.php\">Register</a>
							</li>
								";
					} else {
						echo "<li class=\"nav-item mx-3\">
								<a class=\"nav-link\" href=\"myPlaylist.php\">My Playlist <span class=\"sr-only\">(current)</span></a>
							</li>
						<li class=\"nav-item mx-3\">
							<a class=\"nav-link active\" href=\"addSong.php\">Add a Song <span class=\"sr-only\">(current)</span></a>
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
	<?php
        if (isset($_POST["submit1"])) {
            $dir = 'trendingsongs/';
            $audioPath = $dir.basename($_FILES['songFile']['name']);
            $songName = $_POST['songName'];
            $singer = $_POST['songSinger'];
            $releaseYear = $_POST['releaseYear'];
			if (isset($songName) && isset($singer) && isset($releaseYear) && isset($_FILES['songFile']['name']) && ($songName != '' || $singer != '' || $releaseYear != '')) {
				// echo "Type : " . $_FILES["songFile"]["type"] ."<br>";
				if ($_FILES["songFile"]["type"] == "audio/mpeg") {
					if (move_uploaded_file($_FILES["songFile"]["tmp_name"], $audioPath)) {
						$result = mysqli_query($mysqli, "INSERT INTO songs(song_name,singer,release_date,lyrics,audio_path) VALUES('$songName','$singer','$releaseYear', '', '$audioPath')");
						if (mysqli_affected_rows($mysqli) > 0) {
							echo "
								<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
									Your song<strong> ". $songName ."</strong> has been added successfully!
									<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
									<span aria-hidden=\"true\">&times;</span>
									</button>
								</div>
								";
						}
					}
				} else {
					echo "
							<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
								Add Song Failed! <strong>File Type not Correct.</strong>
								<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
								<span aria-hidden=\"true\">&times;</span>
								</button>
							</div>
							";
				}
			} else {
				echo "
					<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
						Add Song Failed! <strong>All Fields not filled.</strong>
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
						<span aria-hidden=\"true\">&times;</span>
						</button>
					</div>
					";
			}
        }
    ?>
    <form action="addSong.php" method="POST" enctype="multipart/form-data">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-5 border border-dark p-5 rounded">
                    <h4 class="text-center">ADD A NEW SONG</h4>

                    <input class="form-control mt-3" placeholder="Song Name*" name="songName">
                    <input class="form-control mt-3" placeholder="Singer Name*" name="songSinger">
                    <input class="form-control mt-3" placeholder="Release year*" name="releaseYear">

                    <div class="form-group mt-3">
                        <label for="exampleFormControlFile1">Upload Song File*</label>
                        <input type="file" class="form-control-file" name="songFile" accept=".mp3,audio/*">
                    </div>

                    <button class="btn btn-success mt-3" type="submit" name="submit1">Submit</button>
                    
                </div>
            </div>
        </div>
    </form>
	
</body>
</html>
