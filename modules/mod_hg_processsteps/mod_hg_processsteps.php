<?php
// no direct access
defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_hg_processsteps', $params->get('layout', 'default'));
