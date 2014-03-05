# JSON Cache Plugin

A Wordpress plugin to generate JSON file from a wordpress database.

Wordpress can be sometimes slow and make a lot of call to the database when you want to display a lot of posts with featured images in on beautifull long scrolling page. I a case like that you need to hit the database to get the featured image of every post. 

JSON Cache fix this issue. it allow you to generate a json file that content all the informations of a post so the user when visiting your site just need to open the json file.  

![screenshot](https://raw.github.com/thibautdelille/JSONCache/master/assets/screenshot-1.png?raw=true "screenshot") 

## How to use
#### Installation
1. clone the repo in your plugin folder
2. go to wp-admin>plugins and activate the plugin
3. go to JSON CACHE and click Generate Cached Content (make sure your data folder is writeable)


#### Getting the datas
**Getting all posts**
```
$json_cache = new JSONCache();
$jsonposts = $json_cache->getJsonData('posts');
```

**Getting all pages**
```
$json_cache = new JSONCache();
$jsonpages = $json_cache->getJsonData('pages');
```

**Getting a specific post**
```
$json_cache = new JSONCache();
$jsonpost = $json_cache->getJsonData('post_1');
```

#### Settings 
you can also add a custom image size:
```
$json_cache = new JSONCache();
$json_cache->add_image_size( 'thibautdelille-full-width');
```	

## Copyright and license

Copyright (C) 2014  Thibaut Delille

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
