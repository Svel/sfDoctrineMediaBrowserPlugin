# This plugin is a work in progress.
For now, refer to the very-wonderful parent plugin [http://github.com/vinyll/sfMediaBrowserPlugin](http://github.com/vinyll/sfMediaBrowserPlugin)


# symfony 1.2/1.3/1.4 library upload assets manager


![](http://particul.es/blog/public/vince/sfmediabrowserplugin/.sfmediabrowserplugin-browser_m.jpg)


## What is it ?


sfMediaBrowser is a symfony 1.2, 1.3, 1.4 plugin that allows you to manage all your file uploads.  
It does NOT use any database as it works directly on file structure.

This plugin bundle an interface for managing folder and file under a configured folder. If you know sfMediaBrowser, you will most probably recognise its easy to understand interface.

The plugin also bundles a form widget and a form validator for replacing a html native file upload and therefore browser directly from the server.

The plugin is also ready for TinyMCE !  
That means you insert 2 line of javascript and you browser your images, videos and file from tinyMCE using the sfMediaBrowser.


## How to install ?

    cd plugins
    git clone git://github.com/vinyll/sfMediaBrowserPlugin.git

_If you don't have git install and don't want to install it, you can [download a sandbox version](http://github.com/vinyll/sfMediaBrowserPlugin/downloads)

edit /config/ProjectConfiguration.class.php :

    $this->enablePlugins('sfDoctrinePlugin', 'sfMediaBrowserPlugin');

run :

    symfony plugin:publish-assets


## How to run the media browser ?

edit /apps/_your\_app_/settings.yml :

    enabled_modules:        [sfMediaBrowser]

Open your browser, go to your app and run the url /sf\_media\_browser, and play around !


## How to enable moving and renaming ?

[Download ready to use jquery files](http://particul.es/blog/public/vince/sfmediabrowserplugin/js.zip).
Copy the /js files into you /web/js folder.

Now edit /apps/_your\_app_/app.yml :

    all:
      sf_media_browser:
        assets_list:                           
          js:  [/js/jquery.js, /js/jquery.dragndrop.js, /sfMediaBrowserPlugin/js/list.jquery.js]
          css: [/sfMediaBrowserPlugin/css/list.css]


You can now :

* drag and drop a file/folder into another folder to move it.
* doubleclick on a file/folder label to edit its name.


## How to enable thumbnails ?

You may automatically display a thumbnail instead of the default image icon
for files detected as images.

> This requires sfImageTransformPlugin to be installed.

Then, update you /apps/_your\_app_/app.yml :

all:
  sf_media_browser:
    thumbnails_enabled:     true
    …

You may also configure other options such as the thumbnail directory or 
thumbnail width and height (see the app.yml file for details).


## How to use the file upload widget ?

![](http://particul.es/blog/public/vince/sfmediabrowserplugin/sfmediabrowserplugin-widget.png)

Edit your form class :

_Here we use an "image" field as an example :_

    $this->setWidget('image', new sfWidgetFormInputMediaBrowser());
    $this->setValidator('image', new sfValidatorMediaBrowserFile());

> Refer to [the full example upload file widget](http://wiki.github.com/vinyll/sfMediaBrowserPlugin/file-upload-widget-example "File upload widget") for a fully working sample code.


## How to use with TinyMCE ?

*   Include this javascript in your template :
    

        /sfMediaBrowserPlugin/js/WindowManager.js

*   insert this javascript in your html :
    

        sfMediaBrowserWindowManager.init('');

*   Setup your tinyMCE.init with this option :
    

        ...,
        file_browser_callback: "sfMediaBrowserWindowManager.tinymceCallback"

*   Now, when selecting an image, video, link file from tinyMCE, it should pop up a sfMediaBrowser window.
    

> See the [full tinymce example page](http://wiki.github.com/vinyll/sfMediaBrowserPlugin/tinymce-example "File upload manager for TinyMCE") for a full working example


## How to use with sfAssetsManager ?

The plugin is ready for sfAssetsManager as it bundles and uses a assets_manager.yml file.

There is no specific configuration as it will detect automatically if the plugin is available
and use it by default.

This replaces the assets configuration in app.yml and makes it more flexible.

See [sfAssetsManagerPlugin](http://github.com/vinyll/sfAssetsManagerPlugin "symfony web assets manager") for details.


## How to configure ?

see the /plugins/sfMediaBrowserPlugin/config/app.yml file for configuration.

If you need further configuration, you should consider [extending the plugin][22]


## How to help ?

You can participate by many ways :

*   Spreading the link
*   Debugging, improving, testing, forking, adapting, patching the source code
*   Mailing me to let me know what you think of it
*   Going to http://www.symfony-project.org/plugins/sfMediaBrowserPlugin and add yourself as a user


## TODO
  
  - add another browsing view with folder tree and files seperated ?
  - add image edition functionalities (resize and maybe rotate ?)
  - finish the jquery optional version (dom's filepicker. ajax view ? crop image ?)


## About

The lead developer is Vincent Agnano <vincent.agnano@particul.es>.
You may contact me at the email address here above.