<!DOCTYPE html>
<html lang="en">
<head>
  <title>GarrettGrayLLC X VistaCom</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2 style="text-align: center;"><img src="logo.jpg" alt="Garrett Gray LLC Logo"/></h2>
  <p style="text-align:center">VistaCom - Video Text Transcriber</p>

  <form action="upload_file.php" method="post" enctype="multipart/form-data">
    <p style="font-weight: bold;">Video File to Transcribe</p>
    <div class="custom-file mb-3">
      <input type="file" class="custom-file-input" id="customFile" name="file">
      <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
    
    <!--
    <p>Default file:</p>
    <input type="file" id="myFile" name="filename2">
  -->

  <div class="mt-3">
      <button type="submit" class="btn btn-primary">Upload</button>
    </div>
  </form>
</div>
<br><br>

<!-- DOM command to grab the text area! 
var display = document.getElementById("textarea");
-->

<div class="container" style="text-align: center;">
<button style="text-align: center;" type="button" class="btn btn-warning" onclick="return location.reload();">Transcribe</button>

  <h2>Video-to-Text Transcription:</h2>
  <form>
    <div class="form-group">
      <label for="comment"></label>
      <textarea class="form-control" rows="10" id="textarea" name="textarea" readonly>The video transcription will go here...</textarea>
    </div>
  </form>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

</body>
</html>

<?php

$allowedExts = array("wav", "mp3", "mp4", "wma", "mov");
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

if ((($_FILES["file"]["type"] == "video/mp4")
|| ($_FILES["file"]["type"] == "video/mov")
|| ($_FILES["file"]["type"] == "audio/mp3")
|| ($_FILES["file"]["type"] == "audio/wav")
|| ($_FILES["file"]["type"] == "audio/wma"))

&& ($_FILES["file"]["size"] < 50000000)
&& in_array($extension, $allowedExts))

  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "uploads/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }
?>