# JSON Cache Plugin

A Wordpress plugin to generate JSON file from a wordpress database.

Wordpress can be sometimes slow and make a lot of call to the database when you want to display a lot of posts with featured images in on beautifull long scrolling page. I a case like that you need to hit the database to get the featured image of every post. 

JSON Cache fix this issue. it allow you to generate a json file that content all the informations of a post so the user when visiting your site just need to open the json file.   

### How to use
#### Installation
1. clone the repo in your plugin folder
2. go to wp-admin>plugins and activate the plugin
3. go to JSON CACHE and click Generate Cached Content (make sure your data folder is writeable)


#### Getting the datas
*Getting all posts*
```
$json_cache = new JSONCache();
$jsonposts = $json_cache->getJsonData('posts');
```

*Getting all pages*
```
$json_cache = new JSONCache();
$jsonpages = $json_cache->getJsonData('pages');
```

*Getting a specific post*
```
$json_cache = new JSONCache();
$jsonpost = $json_cache->getJsonData('[post_1]');
```