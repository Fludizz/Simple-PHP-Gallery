#!/bin/sh
# Create directory structure as per default values in config.php.
# Adjust below values accordingly.
FULLPATH="full"
SMALLPATH="small"
THUMBPATH="thumb"
IMGLIST="pics.txt"

# No changes required beyond this point.
if [ ! -d $FULLPATH ]; then
  echo "Fullsize images directory ('$FULLPATH') not found - Exiting..."
  exit 1
fi

if [ ! -f $IMGLIST ]; then
  echo -n "Imagelist file ('$IMGLIST') not found - Creating ... "
  cd $FULLPATH
  ls | grep -i .jpg | sort > ../$IMGLIST
  cd ..
  echo "Done!"
fi

if [ ! -d $SMALLPATH ]; then
  echo -n "Smallsize images direcotry ('$SMALLPATH') not found - Creating ... "
  mkdir $SMALLPATH
  echo "Done!"
fi

echo "Generating Small files from '$FULLPATH' in '$SMALLPATH' using '$IMGLIST':"
while read LINE; do
  echo -n "Generating '$SMALLPATH/$LINE' ... "
  if [ ! -f $SMALLPATH/$LINE ]; then
    convert -resize x640 $FULLPATH/$LINE $SMALLPATH/$LINE
    echo "done!"
  else
    echo "File exists - Skipping."
  fi
done < $IMGLIST

if [ ! -d $THUMBPATH ]; then
  echo -n "Thumbnail directory ('$THUMBPATH') not found - Creating ... "
  mkdir $THUMBPATH
  echo "Done!"
fi

echo "Generating Thumbnails from '$FULLPATH' in '$THUMBPATH' using '$IMGLIST':"
while read LINE; do
  echo -n "Generating '$THUMBPATH/$LINE' ... "
  if [ ! -f $THUMBPATH/$LINE ]; then
    convert -resize x96 $FULLPATH/$LINE $THUMBPATH/$LINE
    echo "done!"
  else
    echo "File exists - Skipping."
  fi
done < $IMGLIST

echo "Completed."
