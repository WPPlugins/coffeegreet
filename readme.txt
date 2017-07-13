=== Plugin Name ===
Contributors: lockzackary,zyramae
Donate link: http://adodcespresso.com/
Tags: coffee, greeting
Requires at least: 2.0.2
Tested up to: 3.0.2
Stable tag: 4.3

CoffeeGreet WP Plug-in
Greet your visitors with coffee.
 
== Description ==
 
CoffeeGreet is a WordPress plug-in that will greet your visitors with coffee depending on the hour of the day, by displaying images using the Flickr API. The plug-in will fetch images from Flickr by tags you provide. By default, the plug-in will fetch 10 images (this can be set by the 'shuffle' field on the settings menu). After fetching the images, it would randomly take 1 out of the 10 images to serve to your visitors so that there is variety of servings each page reload. You can also set a default greeting message for your site visitors. Having this plug-in on your blog helps increase your blog's exposure and loyal readership. Best of all, this plug-in is compatible with various WordPress cache plug-ins so you do not have to sacrifice speed.  
 
FEATURES:
 
* Show a different greeting message to your visitor with a coffee image. You can add/edit/delete greeting messages as well as the tags for coffee to be served depending on the hour of the day.
* You can set display options (size of the Flickr image) and can set the number of possible random images that will be displayed on your page.
* When installed, CoffeeGreet becomes available on the widget panel of the Wordpress dash board.
* Ultra customizable greeting message box (with CSS) allowing you to prepend/append HTML around the greeting message box.

== Changelog ==
ver 0.1: Initial release. (Plan for next version: eliminate the need for settings, and just fetch images from CoffeeGroup at flickr. Need to ask for group author's permissions first)

== Installation ==
 
1. Download the plug-in.
2. Extract and upload the entire folder to wp-content/plugins/ directory of your WordPress installation.
3. Activate the plug-in on the Options | Plugins Management page of your WordPress admin site.
4. Click the widgets panel then drag CoffeeGreet on your sidebar.
5. You can tweak the settings by clicking the dropdown arrow on the CoffeeGreet Widget or directly through the Settings | CoffeeGreet    Widget link.
 
TUTORIAL:
 
1. After successfully installing the CoffeGreet plug-in, you can now customize your “Coffee Menu” by clicking the dropdown arrow on the CoffeeGreet Widget or directly through the Settings | CoffeeGreet Widget link.
2. We then enter the tags (usually the name of the coffee) to be served depending on the hour of the day on each text area. Example: We should type in "espresso" as a tag for the morning coffee.   By doing this, we limit the fetched images from Flickr by using the tags that we enter on the boxes; meaning, if someone visits your blog/site in the morning, the image accompanying the morning greeting will only be those tagged with the text "espresso" on Flickr.
3. Optionally we can set display options for the coffee images like the size and the shuffle amount.Setting a value for shuffle will tell the plugin how many images will be fetched from Flickr. You can enter any number but be careful when inputting a very large value (e.g. 100 or more) as it can affect the loading time of your blog. On the other hand entering a very little value such as 1 will display only From the flickr API we can set valid size labels as follows:  
 s  - small square 75x75  
 t  - thumbnail, 100 on longest side  
 m  - small, 240 on longest side   
 -  - medium, 500 on longest side   
 z  - medium 640, 640 on longest side
 
4. Click the "Save Changes" button

== Frequently Asked Questions ==
1. I installed the plugin but I don't see CoffeeGreet on my pages.
  A: After installing the plugin, go to widgets and drag coffeegreet to the section where you want to see it.
2. This plugin sucks.
  A: Yes I know.