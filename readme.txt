=== JSON Cache Plugin ===
Contributors: thibautdelille
Donate link: http://www.thibautdelille.com/
Tags: cache, json, performance
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: v0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


A Wordpress plugin to generate JSON file from a wordpress database.

== Description ==

Wordpress can be sometimes slow and make a lot of call to the database when you want to display a lot of posts with featured images in on beautifull long scrolling page. I a case like that you need to hit the database to get the featured image of every post. 

JSON Cache fix this issue. it allow you to generate a json file that content all the informations of a post so the user when visiting your site just need to open the json file.   

== Screenshots ==
1. Menu Setting of JSON Cache to generate the cache. assets/screenshot-1.png

== Installation ==
1. Upload `json-cache` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. go to JSON CACHE and click Generate Cached Content (make sure your data folder is writeable)

= Getting all posts = 
$json_cache = new JSONCache();
$jsonposts = $json_cache->getJsonData('posts');


=  Getting all pages = 
$json_cache = new JSONCache();
$jsonpages = $json_cache->getJsonData('pages');

= Getting a specific post = 
$json_cache = new JSONCache();
$jsonpost = $json_cache->getJsonData('post_1');

= Settings =  
you can also add a custom image size:
$json_cache = new JSONCache();
$json_cache->add_image_size( 'thibautdelille-full-width');

== Changelog ==

= 0.1 =
* save all pages, all posts and each individuals post in json file
* retrieve json data in the templates
* add custom images sizes