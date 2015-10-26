<?php
/**
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

class modRapidContactHelper
{
	public static function doError($error, $type)
	{
		JFactory::getApplication()->enqueueMessage($error, $type);
	}
}