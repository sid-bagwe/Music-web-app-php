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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@800&family=Montserrat:ital,wght@1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
	<?php
		//including the database connection file
		include_once("config.php");
		include_once("download.php");
        $result = mysqli_query($mysqli, "SELECT * FROM songs ORDER BY id DESC");
	?>

<?php
	  if(isset($_GET['songPath'])) {
		  downloadSong($_GET['songPath']);
	  }
  ?>
    
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #17A2B8;white-space: nowrap;">
		<img class="rounded-circle" src="logo.jpg" alt="Logo" style="width: 30px;">
		<a class="navbar-brand ml-2" href="index.php">Music Website</a>
		<div class="input-group">
			<div class="form-outline">
			<input type="search" id="myInput" class="form-control ml-4" onkeyup="myFunction()" placeholder="Search a Song..." />
			</div>
		</div>
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
							<a class=\"nav-link\" href=\"addSong.php\">Add a Song <span class=\"sr-only\">(current)</span></a>
						</li>
						<li class=\"nav-item mx-3\">
							<a class=\"nav-link active\" href=\"allSongs.php\">Show All Songs</a>
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


    <table class="table mt-5 font-weight-bold text-center text-dark" style="font-family: 'Montserrat', sans-serif;" id="myTable">
        <thead class="text-white" style="background-color: #17A2B8;">
            <tr>
                <!-- <th scope="col">Id</th> -->
                <th scope="col">Name</th>
                <th scope="col">Singer</th>
                <th scope="col">Release Date</th>
                <th scope="col">Play Song</th>
                <th scope="col">Add to Playlist</th>
                <th scope="col">Download</th>
            </tr>
        </thead>
        <tbody>
		<?php
			$playlist_songs_query = mysqli_query($mysqli, "SELECT playlist_songs from users where id='${_SESSION['id']}'");
			$current_playlist = mysqli_fetch_array($playlist_songs_query);
			$current_playlist_array = explode(',',$current_playlist[0]);
			$song_added = null;
		?>
		<?php
		if (isset($_GET['songId'])) {
			// add song to playlist
			// while ($res) {
			// 	// echo $res['playlist_songs'];
			// }
			$updated_playlist = $current_playlist[0].",".$_GET['songId'];
			$update_query = mysqli_query($mysqli, "UPDATE users SET playlist_songs = '${updated_playlist}' WHERE id='${_SESSION['id']}'");
			if (mysqli_affected_rows($mysqli) > 0) {
				// show modal
				$song_added = $_GET['songId'];
				echo "
						<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
							The song<strong> ". $_GET['songName'] ."</strong> has been added to your playlist successfully!
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
							<span aria-hidden=\"true\">&times;</span>
							</button>
						</div>
						";
			}
		}

		?>
        <?php 
        //while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
        while($res = mysqli_fetch_array($result)) {
			// $current_song_id = $res['id'];         
            echo "<tr>";
            // echo "<td>".$res['id']."</td>";
            echo "<td>".$res['song_name']."</td>";
            echo "<td>".$res['singer']."</td>";
            echo "<td>".$res['release_date']."</td>";  
            echo "<td>"."
                <audio controls>
                <source src='".$res['audio_path']."' type='audio/mpeg'>
                Your browser does not support the audio element.
                </audio>
            " ."</td>";
			if (in_array("${res['id']}", $current_playlist_array) || $song_added==$res['id']) {
				echo "
				<td>
					<a class=\"btn btn-primary disabled\">Added</a>
				</td>
			";
			} else {
				echo "
				<td>
					<a class=\"btn btn-primary text-white\" href='allSongs.php?songId=${res['id']}&songName=${res['song_name']}'>Add<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"#FFFFFF\" class=\"bi bi-plus-circle ml-2 mb-1\" viewBox=\"0 0 16 16\">
					<path d=\"M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z\"/>
					<path d=\"M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z\"/>
				  </svg></a>
				</td>
			";
			}
			echo "<td>
					<a class=\"btn\" type=\"submit\" href='allSongs.php?songPath=${res['audio_path']}'>
					<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"25\" height=\"25\" class=\"bi bi-box-arrow-in-down mb-1\" viewBox=\"0 0 16 16\">
					<path fill-rule=\"evenodd\" d=\"M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1h-2z\"/>
					<path fill-rule=\"evenodd\" d=\"M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z\"/>
					</svg>
					</a>
				</td>";
        }
        ?>
        </tbody>
    </table>
	
	<script>
	function myFunction() {
		var input, filter, table, tr, td, i, txtValue;
		input = document.getElementById("myInput");
		filter = input.value.toUpperCase();
		table = document.getElementById("myTable");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[0];
			if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
			}       
		}
	}
	</script>
</body>
</html>
