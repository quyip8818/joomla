<?php
/**
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

jimport('joomla.image.image');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class HgShortcodesHelper
{
	public static function createThumb($path, $width = 100, $height = 100, $crop = 2, $cachefolder = 'hgimages', $external = 0)
	{
		$myImage = new JImage(); 
		if(!$external) {
			$myImage->loadFile(JPATH_SITE . DS . $path);
		} else {
			$myImage->loadFile($path);
		}
		
		if ($myImage->isLoaded()) { 
			// $filename = end(explode('/', $path));
			$filename = JFile::getName($path);
			
			$filefolder = substr(md5(self::getFolderPath($path)),1,10);
			
			$newfilename = $width.'x'.$height.'x'.$crop.'_'.$filefolder.'_'.JFile::makeSafe($filename);
			
			$hgimages = JPATH_CACHE .'/'.$cachefolder.'/';

			if(!JFolder::exists($hgimages)) {
				JFolder::create($hgimages);
			}
			$fileExists = JFile::exists($hgimages.$newfilename);
			
			if(!$fileExists) {
				switch ($crop)
				{
					// Case for self::CROP
					case 4:
						$resizedImage = $myImage->crop($width, $height, null, null, true);
						break;
					// Case for self::CROP_RESIZE
					case 5:
						$resizedImage = $myImage->cropResize($width, $height, true);
						break;

					default:
						$resizedImage = $myImage->resize($width, $height, true, $crop);
						break;
				}
				$properties = $myImage->getImageFileProperties($path);
				
				$mime = $properties->mime;
				if ($mime == 'image/jpeg') {
					$type = IMAGETYPE_JPEG;
				} elseif ($mime = 'image/png') {
					$type = IMAGETYPE_PNG;
				} elseif ($mime = 'image/gif') {
					$type = IMAGETYPE_GIF;
				}
				
				$resizedImage->toFile($hgimages.$newfilename, $type);
			}
			return $newfilename;
		} else { 
			return "My file is not loaded"; 
		} 
	}
	
	public static function getFolderPath($path) {
		$rootPath = $_SERVER['DOCUMENT_ROOT'];
		$thisPath = dirname($path);
		$onlyPath = str_replace($rootPath, '', $thisPath);
		return $onlyPath;	
	}
	
	public static function maketabid($name) {
		return substr(md5($name),1,10);
	}
	
}
