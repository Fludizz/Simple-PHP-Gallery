A simple PHP Gallery
====================

There are tons and tons of different gallery tools available online, however
most of those galleries are very complex in nature and design. This very simple
PHP Gallery has been created to have very pure simplicity. It can also be light
on your webserver as image-generation can be done offline rather then on the 
fly, everything can be done before even uploading the gallery!

Ofcourse, it can generate the images automatically if you don't feel like
pre-generating everything ;)


Requirements
============
* A linux box
* A webserver able to use PHP
* imagemagick locally or GDlib on the server.
* (optional) Shell access to your (linux) webserver


Setup & Install
===============
There are two ways to get your gallery online:
* Local Imagemagick generation 
  Your machine runs linux and has imagemagick (preferred). This method prevents
  loading your webservers CPU. After generating everything locally, you simply
  upload the result to publish it.
  
* Remote GDlib generation
  The webserver generates all the required images on-demand. It writes each
  generated image to disk and will never generate the same image twice.
  This method will cause any first request for an image to take a little longer
  as it generates the images on the fly!

Local Imagemagick generation:
1. Create a folder and copy all PHP and CSS files and 'genimg.sh' into it
2. Edit config.php to match your desired directory structure and set the title
3. Create the subfolder containing the fullsize images (default 'full')
4. Copy all fullsize images to this subfolder
5. Edit 'genimg.sh' to match the variables in config.php
6. Mark 'genimg.sh' as executable ('chmod +x genimg.sh')
7. Execute '/.genimg.sh'
8. Sit back and relax.
9. Move the folder created at step 1 to your webspace.
10. Browse to http://yourdomain/yourfolder/index.php and browse the pictures!

Remote GDlib generation:
1. Edit config.php to match the desired directory structure
2. Upload all the PHP and CSS files to the desired webfolder
3. Create the fullsize folder as configured in config.php
4. Copy all fullsize images to this subfolder.
5. Browse to http://yourdomain/yourfolder/index.php and watch the magic!


Updating images
===============
If you add new images to your fullsize images folder, you can simply generate
new small-sized images by rerunning the 'genimg.sh' script. This can be done as
follows:

When running locally using genimg.sh:
1. Add the new images to your fullsize folder (default 'full')
2. Rerun the 'genimg.sh' script to update your gallery.
3. Upload the folder to your webserver (Replace existing).

When using the GDlib method:
1. Upload the new images to your fullsize folder (default 'full').

Note:
If you are updating/replacing files, delete the corresponding small/thumb files!
