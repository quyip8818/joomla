<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 8508 2014-10-22 18:57:14Z Milbo $
 */

defined ('_JEXEC') or die('Restricted access');
JHtml::_ ('behavior.modal');

$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
";

vmJsApi::addJScript('vm.hover',$js);

if (empty($this->keyword) and !empty($this->category)) {
	?>
<div class="category_description">
	<?php echo $this->category->category_description; ?>
</div>
<?php
}

// Show child categories
if (VmConfig::get ('showCategory', 1) and empty($this->keyword)) {
	if (!empty($this->category->haschildren)) {

		echo ShopFunctionsF::renderVmSubLayout('categories',array('categories'=>$this->category->children));

	}
}

if($this->showproducts){
?>
<div class="browse-view">
<?php

if (!empty($this->keyword)) {?>
	<h3><?php echo $this->keyword; ?></h3>

	<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=category&limitstart=0', FALSE); ?>" method="get">

		<!--BEGIN Search Box -->
		<div class="virtuemart_search">
			<p><?php if(isset($this->searchcustom)) echo $this->searchcustom; ?></p>
			<p><?php if(isset($this->searchcustomvalues)) echo $this->searchcustomvalues; ?></p>
			<div class="input-append">
				<input name="keyword" class="inputbox" type="text" size="20" value="<?php echo $this->keyword ?>"/>
				<input type="submit" value="<?php echo JText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="button btn" onclick="this.form.keyword.focus();"/>
			</div>
		</div>
		<input type="hidden" name="search" value="true"/>
		<input type="hidden" name="view" value="category"/>
		<input type="hidden" name="option" value="com_virtuemart"/>
		<input type="hidden" name="virtuemart_category_id" value="<?php echo $this->categoryId; ?>"/>

	</form>
	<!-- End Search Box -->
<?php  } ?>

<?php // Show child categories ?>
<div class="orderby-displaynumber">
	<div class="row-fluid">
		<div class="span12"><hr /></div>
	</div>
	<div class="row-fluid">
		<div class="span8">
			<?php echo $this->orderByList['orderby']; ?>
			<?php echo $this->orderByList['manufacturer']; ?>
		</div>
		<div class="span4 display-number dropdown-select"><?php echo $this->vmPagination->getResultsCounter ();?><br/><?php echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?></div>
	</div>
	<div class="row-fluid">
		<div class="span12"><hr /></div>
	</div>
</div> <!-- end of orderby-displaynumber -->

<h2 class="m_title"><?php echo $this->category->category_name; ?></h2>

	<?php
	if (!empty($this->products)) {
	$products = array();
	$products[0] = $this->products;
	echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating));
	?>
<div class="vm-pagination"><?php echo $this->vmPagination->getPagesLinks (); ?><span class="vm-page-counter"><?php echo $this->vmPagination->getPagesCounter (); ?></span></div>

	<?php
} elseif (!empty($this->keyword)) {
	echo vmText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div>

<?php } ?>

<!-- end browse-view -->