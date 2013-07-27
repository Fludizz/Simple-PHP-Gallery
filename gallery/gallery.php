<?php
// Resize function to dynamically create the small sized images.
function generateResizedImage($src, $dest, $desired_height) {
	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_width = floor($width * ($desired_height / $height));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $dest, 90);
}

// Read all JPG files from "Fullsize" dir into array.
if ($handle = opendir($fullpath)) {
  while (false !== ($file = readdir($handle)))
  {
    if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'jpg')
    {
        $allpics[] = $file;
    }
  }
  closedir($handle);
}
// Make sure array key 0 is unused:
array_unshift($allpics, "dummy.png");
unset($allpics[0]);

// Get the total number of pictures
$lastpic = count($allpics);

// Set default starting position at first image.
$curimg = 1;
$nextimg = 2;
$previmg = $lastpic;

// Check if there is something in the get for 'pic'. Adjust the
// 'position' in the array as required: This statement checks the
// positions in the array and adjust the next and previous image files
// according to the current.
// if the pic variable is invalid, defaults are assumed.
if (isset($_GET['pic'])) {
  $key = intval(htmlspecialchars($_GET['pic']));
  if ($key > 1 && $key < $lastpic) {
    $curimg = $key;
    $previmg = $key - 1;
    $nextimg = $key + 1;
  } else if ($key == $lastpic) {
    $curimg = $key;
    $nextimg = 1;
    $previmg = $key - 1;
  }
}

// Test if the required Small & Thumb folder exists and create it if needed:
if (!file_exists($smallpath)) {
    mkdir($smallpath, 0775, true);
}
if (!file_exists($thumbpath)) {
    mkdir($thumbpath, 0775, true);
}
// Test if the small-sized image requested exists and create if needed:
if (!file_exists($smallpath . '/' . $allpics[$curimg])) {
    generateResizedImage($fullpath . '/' . $allpics[$curimg], 
                         $smallpath . '/' . $allpics[$curimg], 640);
}
// Test if the required Thumbnails exist and create them if needed:
if (!file_exists($thumbpath . '/' . $allpics[$curimg])) {
    generateResizedImage($fullpath . '/' . $allpics[$curimg], 
                         $thumbpath . '/' . $allpics[$curimg], 96);
}
if (!file_exists($thumbpath . '/' . $allpics[$previmg])) {
    generateResizedImage($fullpath . '/' . $allpics[$previmg], 
                         $thumbpath . '/' . $allpics[$previmg], 96);
}
if (!file_exists($thumbpath . '/' . $allpics[$nextimg])) {
    generateResizedImage($fullpath . '/' . $allpics[$nextimg], 
                         $thumbpath . '/' . $allpics[$nextimg], 96);
}
if ($nextimg == $lastpic) {
  if (!file_exists($thumbpath . '/' . $allpics[1])) {
      generateResizedImage($fullpath . '/' . $allpics[1], 
                         $thumbpath . '/' . $allpics[1], 96);
  }
} else  {
  if (!file_exists($thumbpath . '/' . $allpics[$nextimg + 1])) {
    generateResizedImage($fullpath . '/' . $allpics[$nextimg + 1], 
                         $thumbpath . '/' . $allpics[$nextimg + 1], 96);
  }
}
if ($previmg == 1) {
  if (!file_exists($thumbpath . '/' . $allpics[$lastpic])) {
    generateResizedImage($fullpath . '/' . $allpics[$lastpic], 
                         $thumbpath . '/' . $allpics[$lastpic], 96);
  }
} else {
  if (!file_exists($thumbpath . '/' . $allpics[$previmg - 1])) {
    generateResizedImage($fullpath . '/' . $allpics[$previmg - 1], 
                         $thumbpath . '/' . $allpics[$previmg - 1], 96);
  }
}

?>
<html>
<head>
  <title><?=$title?></title>
  <link rel="stylesheet" type="text/css" href="<?=$stylesheet?>"> 
  <!-- Small bit of Javascript to enable arrowkey navigation -->
  <script type="text/javascript">
    function leftArrowPressed() {
        document.location.href = '<?=$_SERVER['PHP_SELF']?>?pic=<?=$previmg?>'
    }
    
    function rightArrowPressed() {
        document.location.href = '<?=$_SERVER['PHP_SELF']?>?pic=<?=$nextimg?>'
    }
    
    document.onkeydown = function(evt) {
      evt = evt || window.event;
      switch (evt.keyCode) {
        case 37:
          leftArrowPressed();
          break;
        case 39:
          rightArrowPressed();
          break;
    }
};
  </script>
</head>
<body>
<h1 class="gallery"><?=$title?></h1>
<p class="gallery">
<a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$previmg?>">Previous</a> - Picture <?=$curimg?> of <?=$lastpic?> - <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$nextimg?>">Next</a>
<br><i>Hint: Use the arrowkeys!</i>
<br><a href="<?=$fullpath?>/<?=$allpics[$curimg]?>" target="_blank"><img src="<?=$smallpath?>/<?=$allpics[$curimg]?>"></a>
<br><i>Filename: <?=$allpics[$curimg]?></i><br>
<?php if (isset($thumbpath)) {
  if ($previmg == 1) { ?>
    <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$lastpic?>"><img src="<?=$thumbpath?>/<?=$allpics[$lastpic]?>"></a>
<?php } else { ?>
    <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$previmg-1?>"><img src="<?=$thumbpath?>/<?=$allpics[$previmg-1]?>"></a>
<?php } ?>
  <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$previmg?>"><img src="<?=$thumbpath?>/<?=$allpics[$previmg]?>" alt="Previous"></a>
  &nbsp;<img class="selected" src="<?=$thumbpath?>/<?=$allpics[$curimg]?>" alt="Current">&nbsp;
  <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$nextimg?>"><img src="<?=$thumbpath?>/<?=$allpics[$nextimg]?>" alt="Next"></a>
<?php if ($nextimg == $lastpic) { ?>
    <a href="<?=$_SERVER['PHP_SELF']?>?pic=1"><img src="<?=$thumbpath?>/<?=$allpics[1]?>"></a>
<?php } else { ?>
    <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$nextimg+1?>"><img src="<?=$thumbpath?>/<?=$allpics[$nextimg+1]?>"></a>
<?php } 
} ?>
</p>
</body>
</html>
