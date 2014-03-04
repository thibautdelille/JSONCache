<?php
/**
 * Plugin Name: JSON Cache
 * Plugin URI: http://www.thibautdelille.com
 * Description: JSON Cache is a Wordpress plugin that generates a cache at every publish
 * Author: Thibaut Delille
 *
 * Copyright thibautdelille 2014
 *
 */
$JSONCACHE_IMAGES_SIZE = array(
		"thumbnail",
		"medium",
		"large",
		"full"
	);

class JSONCache
{
  private $json_page_file = 'pages.json',
    $json_post_file = 'posts.json',
		$json_dir = '/data/',
		$jsoncache_logo = '',
		$DEBUG = false;

	function __construct()
	{

	}

	/**
	 *
	 * @param array $pData
	 */
	public function saveJson($pData)
	{
		// Check file
		if(!file_exists($this->_getHomeFilePath()) && $pData != '' && $pData != null && count($pData) > 0){
			$fh = fopen($this->_getHomeFilePath(), 'w') or die("Error opening output file");
			fwrite($fh, json_encode($pData));
			fclose($fh);
			return true;
		}
		return false;
	}

	/**
	 *
	 * @param array $pData
	 */
	public function eraseAndSaveJson($p_file, $p_data)
	{
		// Check file
		if($p_data != '' && $p_data != null && count($p_data) > 0){
			// File exists
			if($p_file != ''){
				// File permissions
				@chmod($p_file, 0777);
				$fh = fopen($p_file, 'w') or die("Error opening output file");
				fwrite($fh, json_encode($p_data));
				fclose($fh);
				return $p_data;
			}
			return false;
		}
		return false;
	}
  /**
	 * @function	getJsonData
	 * @role		check if a JSON file exists and returns its contents
	 *
	 * @return 		mixed|boolean
	 */
	public function getJsonData($p_content_id)
	{
		$_file = $this->_getSimpleFilePath($p_content_id);

		// Check file
		if(file_exists($_file) === true){
			$str_data = file_get_contents($_file);
			$data = json_decode($str_data,true);
			return $data;
		} else {
			return false;
		}
	}

	/**
	 *
	 */
	private function _getSimpleFilePath($p_file_name)
	{

		if($p_file_name != '')
			return __DIR__ . $this->json_dir . $this->json_simple_dir . $p_file_name . '.json';
		return false;
	}

  /**
	 *
	 */
	function setupAdmin(){
		$this->jsoncache_logo = plugins_url( 'cache_icon.png' , __FILE__ );
		add_action('admin_menu', array(&$this, 'setUpAdminMenu'));
	}


	/**
	 *
	 */
	function setUpAdminMenu(){
		add_menu_page(__('JSON CACHE','JSON CACHE'), __('JSON CACHE','JSON CACHE'), 'manage_options', 'jsoncache', array(&$this, 'add_options_page'), $this->jsoncache_logo);
	}


	/**
	* @function	generatePagesContent
	* @role		generate content for the pages
	*
	* @param unknown_type $post_type
	*/
	public function generatePagesContent()
	{

	 global $wpdb;
	 
	 $aContent = get_pages();

	 // START JVST CACHE
	 $file_written = $this->eraseAndSaveJson($this->_getSimpleFilePath('pages'), $aContent);

	 return $file_written;
	}


	/**
	 * @function	generatePostsContent
	 * @role		generate content for the posts
	 *
	 * @param unknown_type $post_type
	 */
	public function generatePostsContent()
	{

	  global $wpdb;

    $args = array(
      'posts_per_page' => -1
    );
    $myposts = get_posts($args);
    $result = array() ;
		foreach( $myposts as $post ) :  setup_postdata($post); 
			$post->thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));
			$post->medium = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
			$post->large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
			$post->full = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
	  	$file_written = $this->eraseAndSaveJson($this->_getSimpleFilePath('post_'.$post->ID), $post);
			array_push($result, $post);
		endforeach;
	  // START JVST CACHE
	  $file_written = $this->eraseAndSaveJson($this->_getSimpleFilePath('posts'), $result);

	  return $file_written;
	}

	/**
	 *
	 */
	function add_options_page()
  	{
		// Debug
		$this->setDebug(true);

		$b_post_content_is_saved = false;
		$b_page_content_is_saved = false;

		if(count($_POST) > 1 && isset($_POST['generate']) && $_POST['generate'] == 'oui'){
      // Generate all content
      if(isset($_POST['page']) && $_POST['page'] == '1')
        if($this->generatePagesContent() !== false)
          $b_page_content_is_saved = true;

      // Generate all content
      if(isset($_POST['post']) && $_POST['post'] == '1')
        if($this->generatePostsContent() !== false)
          $b_post_content_is_saved = true;

		}

		?>
		<style type="text/css">
		.important_notice { width:900px;padding:10px;font-size:14px;color:#000;border:5px #e52020 solid;height:100px;margin-top:10px; }
		.important_notice p { line-height:20px;float:left;width:840px; }
		.important_notice img { float:left;margin-right:10px;margin-top:15px; }
		.result img, .result h3 { float:left; }
		.result h3 { margin-top:6px;margin-left:12px;font-size:16px; }
		p.submit span { font-size:14px; }
		.results_message { clear:both;width:400px; }
		</style>
		<div class="wrap">
			<h2>JSON CACHE SYSTEM</h2>
			<div class="important_notice">
				<img src="../wp-content/plugins/json-cache/warning.png" />
				<p>
				This plugin handles the cached content on the site.<br/>
				When you click on the button <b><i>Generate Cached Content</i></b>, all the site content will be generated in a server-cache format (JSON).<br/>
				This improves the general loading of the site.<br/>
				</p>
			</div>
			<form action="" method="post">
				<input type="hidden" name="generate" value="oui"/>
				<p class="submit">
					<input type="checkbox" name="page" value="1" checked="checked"/> <span>Generate page content</span><br/><br/>
          <input type="checkbox" name="post" value="1" checked="checked"/> <span>Generate post content</span><br/><br/>
					<input type="submit" name="submit" style="font-size:16px !important;" id="submit" class="button-primary" value="Generate Cached Content" />
				</p>
			</form>
			<div class="result">
				<?php if($b_post_content_is_saved){?>
				<div class="results_message">
					<img src="../wp-content/plugins/json-cache/check-icon.png"/>
					<h3>Page cache generated</h3>
				</div>
				<?php }?>
				<?php if($b_page_content_is_saved){?>
				<div class="results_message">
					<img src="../wp-content/plugins/json-cache/check-icon.png"/>
					<h3>Post cache generated</h3>
				</div>
				<?php }?>
			</div>
		</div>
		<?php
	}

	/**
	 *
	 * @param unknown_type $p_debug
	 */
	function addImageSize($p_size)
	{
		$bExist = false;
		foreach ($JSONCACHE_IMAGES_SIZE as $i => $size) {
			if($size === $p_size){
				$bExist = true;
			}
		}
		if(!$bExist){
			array_push($JSONCACHE_IMAGES_SIZE, $p_size);
		}
	}


	/**
	 *
	 * @param unknown_type $p_debug
	 */
	function setDebug($p_debug)
	{
		$this->DEBUG = $p_debug;
	}


	/**
	 *
	 * @param unknown_type $t
	 */
	private function _log($t)
	{
		if($this->DEBUG) echo 'JSONCache :: ' . $t . '<br/>';
	}
}

$json_cache_admin = new JSONCache();
$json_cache_admin->setupAdmin();
