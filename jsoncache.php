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

}
