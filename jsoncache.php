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
		$this->jsoncache_logo = plugins_url( 'cache_icon.gif' , __FILE__ );
		add_action('admin_menu', array(&$this, 'setUpAdminMenu'));
	}


	/**
	 *
	 */
	function setUpAdminMenu(){
		add_menu_page(__('JSON CACHE','JSON CACHE'), __('JSON CACHE','JSON CACHE'), 'manage_options', 'jsoncache', array(&$this, 'add_options_page'), $this->jsoncache_logo);
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
