<?php

function downloadSong($songPath) {
    // $file_url = 'trendingsongs\Hawayein.mp3';  
    header('Content-Type: application/octet-stream');  
    header("Content-Transfer-Encoding: utf-8");   
    header("Content-disposition: attachment; filename=\"" . basename($songPath) . "\"");   
    readfile($songPath);
    header("location: allSongs.php");
}

?>  