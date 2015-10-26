<?php
/**
*
* Layout for the login
*
* @package	VirtueMart
* @subpackage User
* @author Max Milbers, George Kostopoulos
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: cart.php 4431 2011-10-17 grtrustme $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

//set variables, usually set by shopfunctionsf::getLoginForm in case this layout is differently used
if (!isset( $this->show )) $this->show = TRUE;
if (!isset( $this->from_cart )) $this->from_cart = FALSE;
if (!isset( $this->order )) $this->order = FALSE ;


if (empty($this->url)){
	$url = vmURI::getCleanUrl();
} else{
	$url = $this->url;
}

$user = JFactory::getUser();

if ($this->show and $user->id == 0  ) {
JHtml::_('behavior.formvalidation');
JHtml::_ ( 'behavior.modal' );


//$uri = JFactory::getURI();
//$url = $uri->toString(array('path', 'query', 'fragment'));


	//Extra login stuff, systems like openId and plugins HERE
    if (JPluginHelper::isEnabled('authentication', 'openid')) {
        $lang = JFactory::getLanguage();
        $lang->load('plg_authentication_openid', JPATH_ADMINISTRATOR);
        $langScript = '
//<![CDATA[
'.'var JLanguage = {};' .
                ' JLanguage.WHAT_IS_OPENID = \'' . vmText::_('WHAT_IS_OPENID') . '\';' .
                ' JLanguage.LOGIN_WITH_OPENID = \'' . vmText::_('LOGIN_WITH_OPENID') . '\';' .
                ' JLanguage.NORMAL_LOGIN = \'' . vmText::_('NORMAL_LOGIN') . '\';' .
                ' var comlogin = 1;
//]]>
                ';
		vmJsApi::addJScript('login_openid',$langScript);
        JHtml::_('script', 'openid.js');
    }

    $html = '';
    JPluginHelper::importPlugin('vmpayment');
    $dispatcher = JDispatcher::getInstance();
    $returnValues = $dispatcher->trigger('plgVmDisplayLogin', array($this, &$html, $this->from_cart));

    if (is_array($html)) {
		foreach ($html as $login) {
		    echo $login.'<br />';
		}
    }
    else {
		echo $html;
    }

    //end plugins section

    //anonymous order section
    if ($this->order  ) {
    	?>

	    <div class="order-view">

	    <h3 class="m_title"><?php echo vmText::_('COM_VIRTUEMART_ORDER_ANONYMOUS') ?></h3>

	    <form action="<?php echo JRoute::_( 'index.php', 1, $this->useSSL); ?>" method="post" name="com-login" class="form-inline styledform1">
            <div class="row">
            	<div class="span4" id="com-form-order-number">
            		<label for="order_number"><?php echo vmText::_('COM_VIRTUEMART_ORDER_NUMBER') ?></label>
            		<input type="text" id="order_number" name="order_number" class="inputbox span4" size="18" alt="order_number" />
            	</div>
            	<div class="span4" id="com-form-order-pass">
            		<label for="order_pass"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PASS') ?></label>
            		<input type="text" id="order_pass" name="order_pass" class="inputbox span4" size="18" alt="order_pass" value="p_"/>
            	</div>
            	<div class="span4" id="com-form-order-submit">
                <p style="height: 15px;"></p>
            		<input type="submit" name="Submitbuton" class="button btn btn-primary" value="<?php echo vmText::_('COM_VIRTUEMART_ORDER_BUTTON_VIEW') ?>" />
            	</div>
            </div>
	    	<div class="clr"></div>
	    	<input type="hidden" name="option" value="com_virtuemart" />
	    	<input type="hidden" name="view" value="orders" />
	    	<input type="hidden" name="layout" value="details" />
	    	<input type="hidden" name="return" value="" />

	    </form>

	    </div>

<?php   }


    // XXX style CSS id com-form-login ?>
    <form id="com-form-login" action="<?php echo JRoute::_('index.php', $this->useXHTML, $this->useSSL); ?>" method="post" name="com-login" class="form-inline styledform1" >
    <fieldset class="userdata">
	<?php if (!$this->from_cart ) { ?>
	<div>
		<h3 class="m_title"><?php echo vmText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM'); ?></h3>
	</div>
    <div class="clear"></div>
<?php } else { ?>
        <p><?php echo vmText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM'); ?></p>
<?php }   ?>

        <p class="vmlogin">
            <input type="text" name="username" class="inputbox" size="18" alt="<?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?>" onblur="if(this.value=='') this.value='<?php echo addslashes(vmText::_('COM_VIRTUEMART_USERNAME')); ?>';" onfocus="if(this.value=='<?php echo addslashes(vmText::_('COM_VIRTUEMART_USERNAME')); ?>') this.value='';" />
            <input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18" alt="<?php echo vmText::_('COM_VIRTUEMART_PASSWORD'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_PASSWORD'); ?>" onblur="if(this.value=='') this.value='<?php echo addslashes(vmText::_('COM_VIRTUEMART_PASSWORD')); ?>';" onfocus="if(this.value=='<?php echo addslashes(vmText::_('COM_VIRTUEMART_PASSWORD')); ?>') this.value='';" />
            <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <label for="remember" class="ml1x mr1x">
                <input type="checkbox" id="remember" name="remember" class="inputbox" value="yes" alt="Remember Me" />
                <?php echo $remember_me = vmText::_('JGLOBAL_REMEMBER_ME') ?>
            </label>
            <?php endif; ?>
            <input type="submit" name="Submit" class="default btn btn-primary" value="<?php echo vmText::_('COM_VIRTUEMART_LOGIN') ?>" />
        </p>
        </fieldset>
        <div class="clr"></div>

        <p>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>" rel="nofollow">
            <?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_USERNAME'); ?></a>
            <span> | </span>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" rel="nofollow">
            <?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD'); ?></a>
        </p>

        <div class="clr"></div>

		<input type="hidden" name="task" value="user.login" />
        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </form>

<?php  } else if ( $user->id ) { ?>

	<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="login" id="form-login">
        <div class="input-prepend input-append">
            <span class="add-on"><?php echo vmText::sprintf( 'COM_VIRTUEMART_HINAME', $user->name ); ?></span>
            <input type="submit" name="Submit" class="btn" value="<?php echo vmText::_( 'COM_VIRTUEMART_BUTTON_LOGOUT'); ?>" />
        </div>
        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="user.logout" />
        <?php echo JHtml::_('form.token'); ?>
    	<input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
    </form>

<?php }

?>

