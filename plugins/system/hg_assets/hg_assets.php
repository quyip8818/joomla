<?php
/**
 * @version		$Id$
 * @author		Hogash Studio (hogash.themeforest@gmail.com)
 * @package		Joomla.Site
 * @subpakage	Hogash.HGAssets
 * @copyright	Copyright (c) 2014 Hogash Studio (http://www.hogash.com/). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('JPATH_BASE') or die;

jimport('joomla.event.plugin');
jimport('joomla.plugin.plugin');
jimport('zauan.shortcodes.shortcodes');
jimport ('joomla.filesystem.file');
jimport('joomla.filesystem.path');

/**
 * System - HG Assets
 *
 * @package		Joomla.Plugin
 * @subpakage	Hogash.HGAssets
 */
class plgSystemHG_Assets extends JPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct($subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}

	//onAfterRoute hook.
	public function onAfterRoute() {
		$app	= JFactory::getApplication();

		if ($app->isAdmin()) {
			if($this->params->get('hidemenu',1)) {
				// check to see if the user is admin
				$user = JFactory::getUser();
				if(!$user->authorise('manage', 'com_banners'))
					return;
			}
			$option = JRequest::getWord('option');
       		$layout = JRequest::getWord('layout');

			if ((($option == 'com_content' || $option == 'com_modules' || $option == 'com_templates' || $option == 'com_menus') && $layout == 'edit')) {
				JFactory::getDocument()->addStyleSheet(JURI::root(true) . '/plugins/system/hg_assets/assets/css/hgassets.css');
			}
		}
	}
	public function onAfterDispatch() {
		if($this->params->get('hidemenu',1))
	        JRequest::setVar('hidemainmenu', 0);

		$app = JFactory::getApplication();
        if (!$app->isAdmin()) return;
		$option = JRequest::getWord('option');
        $layout = JRequest::getWord('layout');

		if (($option == 'com_content' || $option == 'com_modules' || $option == 'com_menus') && $layout == 'edit'){
			JFactory::getDocument()->addScript(JURI::root(true) . '/plugins/system/hg_assets/assets/js/hgassets.js');
        }

    }

	//Add the forms from the template path
	public function onContentPrepareForm($form, $data) {

		$app = JFactory::getApplication();
        if (!$app->isAdmin()) return;

        $option = JRequest::getWord('option');
        $layout = JRequest::getWord('layout');
		$view = JRequest::getWord('view');

		// Get template folder by checking the default template db.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName('template'))
			->from($db->quoteName('#__template_styles'))
			->where($db->quoteName('client_id'). ' = "0" AND ' . $db->quoteName('home').' = "1"');
		$db->setQuery($query);
		$frontend_template = $db->loadResult();

		// Load custom article params
		if($this->params->get('load_article_params',1)):
			if ( $option == 'com_content' && $layout == 'edit' ):
				$article_params = JPath::clean(JPATH_ROOT . '/templates/' . $frontend_template . '/custom/forms/article.xml');
				if (JFile::exists($article_params))
					$form->loadFile($article_params, true);
				else
					JFactory::getApplication()->enqueueMessage(JText::_('XML params file not found! Please check if the xml file exists in templates/default_template_folder/custom/forms/ called article.xml . Make sure the file is in the default template folder.'), 'Warning');
			endif;
		endif;

        // Load custom module params
		if($this->params->get('load_module_params',0)):
			if ($option == 'com_modules' && ($layout == 'edit' || $layout == 'modal')):
				$module_params = JPath::clean(JPATH_ROOT . '/templates/' . $frontend_template . '/custom/forms/module.xml');
				if (JFile::exists($module_params))
					$form->loadFile($module_params, true);
				else
					JFactory::getApplication()->enqueueMessage(JText::_('XML params file not found! Please check if the xml file exists in templates/default_template_folder/custom/forms/ called module.xml . Make sure the file is in the default template folder.'), 'Warning');
			endif;
		endif;

		// Load custom menuitem params
		if($this->params->get('load_menuitems_params',1)):
			if ($option == 'com_menus' && $layout == 'edit'):
				$menuitem_params = JPath::clean(JPATH_ROOT . '/templates/' . $frontend_template . '/custom/forms/menuitem_params.xml');
				if (JFile::exists($menuitem_params))
					$form->loadFile($menuitem_params, true);
				else
					JFactory::getApplication()->enqueueMessage(JText::_('XML params file not found! Please check if the xml file exists in templates/default_template_folder/custom/forms/ called menuitem_params.xml . Make sure the file is in the default template folder.'), 'Warning');
			endif;
		endif;
	}

	// Do BBCode replacements on the whole page
	public function onContentPrepare($context, $article, $params, $limitstart)
    {
    	JHtml::_('jquery.framework');

		if($this->params->get('shortcodes',1)) {
			//error_reporting (E_ALL ^ E_NOTICE);
			$article->text = wpautop($article->text);
			$article->text = shortcode_unautop($article->text);
			$article->text = do_shortcode($article->text);
		}
    }


}