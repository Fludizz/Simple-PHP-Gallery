A simple PHP Gallery
====================

There are tons and tons of different gallery tools available online, however
most of those galleries are very complex in nature and design. This very simple
PHP Gallery has been created to have very pure simplicity. It is also very light
on your webserver as no image-generation is done on the fly, everything can be
done before even uploading the gallery!


Requirements
============
* A linux box
* A webserver able to use PHP
* imagemagick
* (optional) Shell access to your (linux) webserver


Setup & Install
===============
There are two ways to get your gallery online:
* Local generation 
  Your machine runs linux and has imagemagick (preferred). This method prevents
  loading your webservers CPU. After generating everything locally, you simply
  upload the result to publish it. This method also doesn't require shell access
  to the webserver.
  
* Remote generation
  Use the webserver which runs linux and has imagemagick. Caution: This method
  can generate a considerable load on your webserver during generation.

Either way, both use the same procedure:

1. Create a folder and copy 'index.php', 'config.php' and 'genimg.sh' into it
2. Edit config.php to match your desired directory structure and set the title
3. Create the subfolder containing the fullsize images (default 'full')
4. Copy all fullsize images to this subfolder
5. Edit 'genimg.sh' to match the variables in config.php
6. Mark 'genimg.sh' as executable ('chmod +x genimg.sh')
7. Execute '/.genimg.sh'
8. Sit back and relax.
9. Move the folder created at step 1 to your webspace.
10. Browse to http://yourdomain/yourfolder/index.php and browse the pictures!


Updating images
===============
If you add new images to your fullsize images folder, you can simply generate
new small-sized images by rerunning the 'genimg.sh' script. This can be done as
follows:

1. Delete the image list file (default 'pics.txt')
2. Add the new images to your fullsize folder ('full')
   Note: If you are replacing files, delete the corresponding small/thumb files!
3. Rerun the 'genimg.sh' script to update your gallery.
4. If run locally, upload the folder to your webserver (Replace existing).
