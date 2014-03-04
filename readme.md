# JSON Cache Plugin

A Wordpress plugin to generate JSON file from a wordpress database.

### How to use
#### Installation
1. clone the repo in your plugin folder
2. go to wp-admin>plugins and activate the plugin
3. go to JSON CACHE and click Generate Cached Content (make sure your data folder is writeable)


#### Getting the datas
```
$json_cache = new JSONCache();
$jsonposts = $json_cache->getJsonData('posts');
```