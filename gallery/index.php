<?php
// Load the config file.
include('config.php');

header("Cache-Controle: public");
header('Expires: 65535');
header('Pragma: cache');

// Define the array with all image file names from defined text file.
$allpics = file($imglist, FILE_SKIP_EMPTY_LINES);

// An array starts counting at 0, humans at 1. Shift the first image from
// position 0 to position 1:
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
?>
<html>
<head>
  <title><?= $title ?></title>
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
<body bgcolor="#FFFFFF"><font face="Verdana" size='1' color="#000000">
<h1 align="center"><?=$title?></h1>
<p align="center">
<a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$previmg?>">Previous</a> - Picture <?=$curimg?> of <?=$lastpic?> - <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$nextimg?>">Next</a>
<br><i>Hint: Use the arrowkeys!</i>
<br><a href="<?=$fullpath?>/<?=$allpics[$curimg]?>" target="_blank"><img src="<?=$smallpath?>/<?=$allpics[$curimg]?>" border="0"></a>
<br><i>Filename: <?=$allpics[$curimg]?></i><br>
<?php if (isset($thumbpath)) {
  if ($previmg == 1) { ?>
    <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$lastpic?>"><img src="<?=$thumbpath?>/<?=$allpics[$lastpic]?>" border="0"></a>
<?php } else { ?>
    <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$previmg-1?>"><img src="<?=$thumbpath?>/<?=$allpics[$previmg-1]?>" border="0"></a>
<?php } ?>
  <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$previmg?>"><img src="<?=$thumbpath?>/<?=$allpics[$previmg]?>" alt="Previous" border="0"></a>
  &nbsp;<img src="<?=$thumbpath?>/<?=$allpics[$curimg]?>" alt="Current" style="border: 3px #00FF00 solid;">&nbsp;
  <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$nextimg?>"><img src="<?=$thumbpath?>/<?=$allpics[$nextimg]?>" alt="Next" border="0"></a>
<?php if ($nextimg == $lastpic) { ?>
    <a href="<?=$_SERVER['PHP_SELF']?>?pic=1"><img src="<?=$thumbpath?>/<?=$allpics[1]?>" border="0"></a>
<?php } else { ?>
    <a href="<?=$_SERVER['PHP_SELF']?>?pic=<?=$nextimg+1?>"><img src="<?=$thumbpath?>/<?=$allpics[$nextimg+1]?>" border="0"></a>
<?php } 
} ?>
</p>
</body>
</html>
