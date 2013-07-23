<?php
// Config file for the simple gallery script

// Define the title for the page:
$title = "Your gallery title";

// The file containing a list of filenames.
// Either relative path from current dir or full path from webroot.
// Create it using 'ls | grep -i .jpg | sort > pics.txt' in the fullsize folder
// or let the 'genimg.sh' generate it for you.
$imglist = "pics.txt";

// Define the path for the fullsize files directories
// Either relative path from current dir or full path from webroot.
$fullpath = "full";

// Define the path for the fullsize files directories
// Either relative path from current dir or full path from webroot.
// Small size images can be created using the following command in fullsize dir:
// 'for i in $(ls *.JPG); do convert -resize x768 $i ../small/$i; done'
// Or allow the 'genimg.sh' script generate them.
$smallpath = "small";

// Thumbnail directory. If you are not using thumbnails, comment out $thumbpath
// Either relative path from current dir or full path from webroot.
// Thumbnails can be created using the following command in full/small size dir:
// 'for i in $(ls *.JPG); do convert -resize x100 $i ../thumb/$i; done'
// Or allow the 'genimg.sh' script generate them.
$thumbpath = "thumb";

?>
