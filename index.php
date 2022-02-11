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
<body>
	<?php
		//including the database connection file
		include_once("config.php");

		session_start();

		if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
		{
			header("location: registration/login.php");
		}

		//fetching data in descending order (lastest entry first)
		//$result = mysql_query("SELECT * FROM users ORDER BY id DESC"); // mysql_query is deprecated
		$songOftheDay = mysqli_query($mysqli, "SELECT * FROM songs WHERE id=1"); // using mysqli_query instead
		$trendingSongsQuery = mysqli_query($mysqli, "SELECT * FROM songs WHERE is_trending=true"); // using mysqli_query instead
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

					// session_start();

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
	
	<!-- <div class="container">
		<ul class="nav nav-pills nav-justified">
	    	<li class="nav-item">
	    		<a class="nav-link btn-info" href="#"><img class="rounded-circle" src="logo.jpg" alt="Logo" style="width: 30px;"> Music Website</a>
	    	</li>
	    	<li class="nav-item">
	    		<a class="nav-link btn-info" href="addSong.php">ADD A NEW SONG</a>
	    	</li>
	    	<li class="nav-item">
	    		<a class="nav-link btn-info" href="registration/login.php">LOGIN</a>
	    	</li>
	    	<li class="nav-item">
	    		<a class="nav-link btn-info" href="registration/signup.php">REGISTER</a>
	    	</li>
			<li class="nav-item">
	    		<a class="nav-link btn-info" href="allSongs.php">SHOW ALL SONGS</a>
	    	</li>

	 	</ul>
	</div> -->
	<!-- <div class="second-nav" id="second-nav">
		<ul class="nav nav-tabs">
			<li class="nav-item">
		    	<a class="nav-link" href="#">Home</a>
			</li>
		 	<li class="nav-item dropdown">
		    	<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Song Library</a>
			    <ul class="dropdown-menu">
			    	<li>
			    		<a class="dropdown-item" href="#">Language &raquo</a>
			    		<ul class="submenu">
			    			<a class="dropdown-item" href="#">Hindi</a>
			    			<a class="dropdown-item" href="#">English</a>
			    			<a class="dropdown-item" href="#">Punjabi</a>
			    			<a class="dropdown-item" href="#">Gujarati</a>
			    		</ul>
			    	</li>
			    	<li>
			    		<a class="dropdown-item" href="#">Genre &raquo</a>
			    		<ul class="submenu">
			    			<a class="dropdown-item" href="#">Indie</a>
			    			<a class="dropdown-item" href="#">Romance</a>
			    			<a class="dropdown-item" href="#">Party</a>
			    			<a class="dropdown-item" href="#">Classical</a>
			    			<a class="dropdown-item" href="#">Instrumental</a>
			    		</ul>
			    	</li>
			    </ul>
		 	</li>
			<li class="nav-item dropdown">
		    	<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Artists</a>
				<ul class="dropdown-menu">
					 <a class="dropdown-item" id="male" href="artists/male.html">Male</a>
					<a class="dropdown-item" id="female" href="artists/female.html">Female</a> 

				</ul>
			</li>	 
		</ul>
	</div> -->
	<div class="row mt-5">
		<div class="col-lg-3" style="text-align: center;">
			<h3><b><i>SONG OF THE DAY</i></b></h3>
			<img src="songoftheday.jpg" class="img-thumbnail" style="height: 300px; width: 300px;">
			<p> </p>
			<?php 
				$songOftheDay = mysqli_fetch_array($songOftheDay);
				
				$str = "
					<audio controls>
					<source src='".$songOftheDay['audio_path']."' type='audio/mpeg'>
					Your browser does not support the audio element.
					</audio>
					<h2>Singer: ". $songOftheDay['singer']. "</h2>
					<h4>Released: ". $songOftheDay['release_date']. "</h4>
				";

				echo $str;
			?>
			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">See Lyrics</button>
		</div>
			<div class="column">
				<div id="demo" class="collapse" style="text-align: center;">
					<p><em>LYRICS</em></p>
					Arre abhi abhi pyara sa chehra dikha hai<br> 
					Jaane kya kahun uspe kya likha hai<br> 
					Gehra samunder dil dooba jismein<br>
					Ghayal hua main uss pal se ismein<br>
					<br>
					Naina da kya kasoor, ve kasoor, ve kasoor<br>
					Naina da kya kasoor, ve kasoor, ve kasoor<br> 
					Naina da kya kasoor, ve kasoor, ve kasoor<br> 
					Ae dil tu bata re<br>
					<br>
					Naina da kya kasoor, ve kasoor, ve kasoor<br> 
					Naina da kya kasoor, ve kasoor, ve kasoor<br>
					Naina da kya kasoor, ve kasoor, ve kasoor<br> 
					Ae dil tu bata re<br> 
					<br> 
					Dil ko hazaron baandhe the dhaage<br> 
					Par paaji nikla yeh humse aage<br>  
					Hua kya hai, hua kya hai humko<br>   
				</div>
			</div>
			<div class="column">
				<div id="demo" class="collapse" style="text-align: center;"> 
					<br>
					<br>
					Ek pal yeh daude, ek pal yeh bhaage<br>  
					Bhor ho jaaye tab naina jaage <br> 
					Hua yeh hai, hua hai yeh samjho <br> 
					<br> 
					Dil dil ke milte sanche aur khanche <br> 
					Jo hai banata upar se jaake <br> 
					Batti hai na hai dhoop na kasoor, na kasoor <br> 
					<br> 
					Naina da kya kasoor, ve kasoor, ve kasoor <br> 
					Naina da kya kasoor, ve kasoor, ve kasoor <br> 
					Ae dil tu bata re<br> 
					<br> 
					Naina da kya kasoor, ve kasoor, ve kasoor<br>  
					Naina da kya kasoor, ve kasoor, ve kasoor <br> 
					Naina da kya kasoor, ve kasoor, ve kasoor <br> 
					Ae dil tu bata re<br> 
				</div>
			</div>
		<div class="col">
			<h3 style="text-align: center;"><b><i>UPCOMING RELEASES</i></b></h3>
			<div class="row">
				<div class="col-lg-6">
					<h6>1.Udi Udi Jaye</h6>
					<p>Singer: <em>Bhoomi Trivedi</em></p>
				</div>
				<div class="col-lg-6">
					<h6>2.Te Amo</h6>
					<p>Singer: <em>Mohit Chauhan</em></p>
				</div>
				<div class="col-lg-6">
					<h6>3.Udd gaye</h6>
					<p>Singer: <em>Ritviz</em></p>
				</div>
				<div class="col-lg-6">
					<h6>4.Tere Bina</h6>
					<p>Singer: <em>KK</em></p>
				</div>
				<div class="col-lg-6">
					<h6>5.Sau Aasman</h6>
					<p>Singer: <em>Neeti Mohan</em></p>
				</div>
			</div>
		</div>
		<div class="col">
			<h3 style="text-align: center;"><b><i>TRENDING SONGS</i></b></h3>
			<?php
				// $trendingSongs = mysqli_fetch_array($trendingSongsQuery);
				while ($trendingSongs = mysqli_fetch_array($trendingSongsQuery)) {
					echo "
					<div class=\"row\">
					<div class=\"col\">
						<h6>".$trendingSongs['song_name']."</h6>
						<p>Singer: ".$trendingSongs['singer']."</p>
					</div>
					<div class=\"col\">
						<audio controls>
						<source src='".$trendingSongs['audio_path']."' type='audio/mpeg'>
						Your browser does not support the audio element.
						</audio>
					</div>
				</div>
					";
				}
			?>
			</div>			
		</div>
	</div>
	<div><h3 style="text-align: center;"><b><i>TOP ARTISTS</i></b></h3></div>
	<div class="row">
		<div class="col">
			<div class="container">
				<img src="topsingers/ARRahman.jpg" class="img-thumbnail" style="height: 200px; width: 300px;">
				<h6 class="text-block"><b><i><mark>AR Rahman</mark></i></b></h6>	
			</div>		
		</div>
		<div class="col">
			<div class="container">
				<img src="topsingers/SelenaGomez.jpg" class="img-thumbnail" style="height: 200px; width: 300px;">
				<h6 class="text-block"><b><i><mark>Selena Gomez</mark></i></b></h6>	
			</div>		
		</div>
		<div class="col">
			<div class="container">
				<img src="topsingers/ArijitSingh.jpg" class="img-thumbnail" style="height: 200px; width: 300px;">
				<h6 class="text-block"><b><i><mark>Arijit Singh</mark></i></b></h6>	
			</div>		
		</div>
		<div class="col">
			<div class="container">
				<img src="topsingers/ShreyaGhoshal.jpg" class="img-thumbnail" style="height: 200px; width: 300px;">
				<h6 class="text-block"><b><i><mark>Shreya Ghoshal</mark></i></b></h6>	
			</div>		
		</div>
		<div class="col">
			<div class="container">
				<img src="topsingers/VishalDadlani.jpg" class="img-thumbnail" style="height: 200px; width: 300px;">
				<h6 class="text-block"><b><i><mark>Vishal Dadlani</mark></i></b></h6>	
			</div>		
		</div>
		<div class="col">
			<div class="container">
				<img src="topsingers/NehaKakkar.jpg" class="img-thumbnail" style="height: 200px; width: 300px;">
				<h6 class="text-block"><b><i><mark>Neha Kakkar</mark></i></b></h6>	
			</div>		
		</div>
	</div>
	<div>
		<article>
			<h3 style="text-align: center;"><b><i>ABOUT US</i></b></h3></div>
		<aside>
			<div style="display:inline-block;vertical-align:top;">
			    <img src="logo.jpg" class="rounded-circle" style="height: 50px;width: 50px;">
			</div>
			<div style="display:inline-block;">
			    <div>MUSIC WEBSITE</div>
			    <div>AUTHOR : <em>ANSH and SIDDHESH</em></div>
			</div>
		</aside>
		<section>We are a team of 2 members who are trying to provide users with their favourite songs available online.</section>
		<p>Users can listen to any song they like as well create playlists of their favourite songs.</p>
		</article>
	</div>
	<div class="footer" align="center">
		<h4>Follow Us On </h4>
		<button type="button" class="btn btn-primary btn-lg">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
			  	<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
			</svg>
		</button>
		<button type="button" class="btn btn-primary btn-lg">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
  			<path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
			</svg>
		</button>
		<button type="button" class="btn btn-primary btn-lg">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
  			<path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
			</svg>
		</button>		
	</div>
</body>
</html>

<script type="text/javascript">
	$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
	});

// make it as accordion for smaller screens
  $('.dropdown-menu a').click(function(e){
    e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
     $(this).find('.submenu').hide();
  })
  });
  
  $(document).on('change', '.dropdown-menu', function (e) {
  e.stopPropagation();
  });
</script>