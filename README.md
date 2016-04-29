# Like Widget
Like widget is a plugin for your personal wordpress site.
When you set up and activate this widget on your wordpress site, a  like button and a list of your liked posts appear. You can like the post you are reading and view the other posts you have liked and delete one if you dont want it.

In order to setup this widget you have to ;
  - Set up WordPress in to your site.(Can be downloaded from [here.](https://wordpress.org/))
  - Place the content of the files in this repository in to :            your_wordpress_name/wp-content/plugins
  - Activate the Plugin.
  - Set the widget to desired area
  - Done!
 
## __Setup__
### 1st Step`cloning from git`
>You have to clone this git from https://github.com/berkaay/like_widget.git
>
>or just download the zip file.

> Now when you extract the zip or clone the git
> you should have this structure.
```terminal
berkay$ tree like_widget-master
/like_widget-master
├── README.md
├── like.php
└── like_widget.php
```
### 2nd Step `placing the file into the right place`
>Now you'll move this `like_widget_master` file as `like_widget` into the plugins directory inside your wordpress directory.
```
mv /Users/user/Downloads/like_widget-master /Grandparent_of _your_wordpress_dir/Parent_of_your_wordpress_dir/
your_wordpress_dir/wp-content/plugins 
```
### 3rd Step `setting up wordpress `
>I made some screenshots on configuring wordpress so they can help you out in this one ! You can see the gif [here.](http://gph.is/1T9OjyT) 

>and the full size images are 
>[here.](https://drive.google.com/open?id=0By3e2H2M5mcVRUhKSHREYl81LXM)

### 4th Step `activating the plugin` 
 - You go into your dashboard in wordpress. 
 - go into Plugins>Installed Plugins
 - Find Like Widget 
 - Activate it 
    __Dont worry if it warns you after activation.__
    -   __IF Activate button has become deactivate if the Activate button does not change please contact me at__ bberkayozturk@gmail.com

### 5th Step `START USING !`
- And don't forget to [email](bberkayozturk@gmail.com) me if you ever face with a bug . 


#Notes
-See more you Liked and delete button is not working due to an erron on pagesLiked.php if you happen to find the error there please notify me I am still working on it. 

