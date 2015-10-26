<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz, Max Galt
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 8610 2014-12-02 18:53:19Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/* Let's see if we found the product */
if (empty($this->product)) {
	echo vmText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

//echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));

vmJsApi::jDynUpdate();
vmJsApi::addJScript('updDynamicListeners',"
jQuery(document).ready(function() { // GALT: Start listening for dynamic content update.
	// If template is aware of dynamic update and provided a variable let's
	// set-up the event listeners.
	if (Virtuemart.container)
		Virtuemart.updateDynamicUpdateListeners();

}); ");

if(vRequest::getInt('print',false)){ ?>
<body onload="javascript:print();">
<?php } ?>

<div class="row-fluid product-page mb3x">

	<div class="span5">
		<?php echo $this->loadTemplate('images'); ?>
	</div>

	<div class="span7">
		<div class="main-data">

			<?php
			// PDF - Print - Email Icon
			if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_button_enable')) {
			?>
			<ul class="actions">
			<?php
				$link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
				$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

			if (VmConfig::get('pdf_icon', 1) == 1)
			echo '<li class="pdf-icon"><a rel="prettyPhoto" data-rel="tooltip" data-original-title="'. vmText::_('COM_VIRTUEMART_PDF').'" title="'. vmText::_('COM_VIRTUEMART_PDF').'" href="'.JRoute::_($link . '&format=pdf').'&amp;iframe=true&amp;width=800&amp;height=550"><span class="icon-file icon-white"></span></a></li>';
			echo '<li class="print-icon"><a rel="prettyPhoto" data-rel="tooltip" data-original-title="'. vmText::_('COM_VIRTUEMART_PRINT').'" title="'. vmText::_('COM_VIRTUEMART_PRINT').'" href="'.JRoute::_($link . '&print=1').'&amp;iframe=true&amp;width=800&amp;height=550"><span class="icon-print icon-white"></span></a></li>';
			echo '<li class="email-icon"><a rel="prettyPhoto" data-rel="tooltip" data-original-title="'. vmText::_('COM_VIRTUEMART_EMAIL').'" title="'. vmText::_('COM_VIRTUEMART_EMAIL').'" href="'.JRoute::_($MailLink).'&amp;iframe=true&amp;width=800&amp;height=550"><span class="icon-envelope icon-white"></span></a></li>';
			?>
			</ul>
			<?php } // PDF - Print - Email Icon END ?>

			<h1 class="name"><?php echo $this->product->product_name ?></h1>

			<p class="first-details">
			<?php
			$sep = '&nbsp; / &nbsp;';
			if (!empty($this->product->product_sku))
				echo '<strong>'.vmText::_('COM_VIRTUEMART_CART_SKU').':</strong> '. $this->product->product_sku.$sep;

			if (!($this->product->product_in_stock - $this->product->product_ordered) < 1)
				echo '<strong>'.vmText::_('COM_VIRTUEMART_PRODUCT_AVAILABILITY').':</strong> '. vmText::_('JYES').$sep ;

			if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id))
				echo $this->loadTemplate('manufacturer');
			?>
			</p>

			<?php echo shopFunctionsF::renderVmSubLayout('kl_rating_products',array('showRating'=>$this->showRating,'product'=>$this->product)); ?>

		    <?php // afterDisplayTitle Event
		    echo $this->product->event->afterDisplayTitle ?>

		    <?php
		    echo $this->edit_link; ?>

		    <?php
		    // Product Short Description
		    if (!empty($this->product->product_s_desc)) {
			?>
		        <p class="small_desc"><?php
			    /** @todo Test if content plugins modify the product description */
			    echo nl2br($this->product->product_s_desc); ?>
			    </p>
			<?php
		    } // Product Short Description END

		    if (!empty($this->product->customfieldsSorted['ontop'])) {
				$this->position = 'ontop';
				echo $this->loadTemplate('customfields');
		    } // Product Custom ontop end
		    ?>

		</div><!-- /.main-data -->

		<div class="spacer-buy-area">

			<?php
			if (is_array($this->productDisplayShipments)) {
			    foreach ($this->productDisplayShipments as $productDisplayShipment) {
				echo $productDisplayShipment . '<br />';
				}
			}
			if (is_array($this->productDisplayPayments)) {
			    foreach ($this->productDisplayPayments as $productDisplayPayment) {
				echo $productDisplayPayment . '<br />';
				}
			}

			//In case you are not happy using everywhere the same price display fromat, just create your own layout
			//in override /html/fields and use as first parameter the name of your file
			echo shopFunctionsF::renderVmSubLayout('kl_prices_basic',array('product'=>$this->product,'currency'=>$this->currency));
			echo shopFunctionsF::renderVmSubLayout('kl_addtocart_productpage',array('product'=>$this->product));

			echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$this->product));

			// Ask a question about this product
			if (VmConfig::get('ask_question', 1) == 1) {
				$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
				?>
	    		<div class="ask-a-question">
					<a class="ask-a-question btn btn-info" href="<?php echo $askquestion_url; ?>&amp;iframe=true&amp;width=700&amp;height=550" rel="prettyPhoto" ><span class="icon-question-sign icon-white"></span> &nbsp;&nbsp;<?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
	    		</div>
			<?php }	?>

		</div><!-- spacer-buy-area -->

	</div><!-- /.span7 -->

</div>

<div class="row-fluid">
	<div class="span12">

		<?php // event onContentBeforeDisplay
		echo $this->product->event->beforeDisplayContent;
		?>

		<div class="tabbable tabs_style4 mb3x">
			<ul class="nav fixclear">
				<li class="active"><a href="#shop-desc" data-toggle="tab"><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></a></li>
				<li><a href="#shop-rating" data-toggle="tab"><?php echo vmText::_('COM_VIRTUEMART_RATING'); ?></a></li>
				<?php if ($this->product->product_box): ?>
				<li><a href="#shop-tab3" data-toggle="tab"><?php echo vmText::_('COM_VIRTUEMART_SEARCH_ORDER_PRODUCT_PACKAGING'); ?></a></li>
				<?php endif; ?>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="shop-desc">
				<?php
				// Product Description
				if (!empty($this->product->product_desc)) {
					?>
					<div class="product-description">
						<?php echo $this->product->product_desc; ?>
					</div>
				<?php
				} // Product Description END
				?>
				</div>
				<div class="tab-pane specialBehavior" id="shop-rating">
					<?php echo $this->loadTemplate('reviews'); ?>
				</div>
				<?php if ($this->product->product_box): ?>
				<div class="tab-pane" id="shop-tab3">
					<?php
					// Product Packaging
					$product_packaging = '';
					if ($this->product->product_box) {
					?>
						<div class="product-box">
						<?php
						echo vmText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
						?>
						</div>
					<?php } // Product Packaging END ?>
				</div><!-- /.tab-pane -->
				<?php endif; ?>

			</div><!-- /.tab-content -->
		</div><!-- /.tabbable -->

<?php

	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'normal'));

	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'onbot'));

    echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'related_products','class'=> 'product-related-products','customTitle' => true ));

	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'related_categories','class'=> 'product-related-categories'));

?>


	<?php // onContentAfterDisplay event
	echo $this->product->event->afterDisplayContent; ?>

	</div><!-- /.span12 -->
</div>

<div class="row-fluid">
	<?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
	?>
	<div class="span12">
		<div class="product-neighbours mb3x">
	    <?php
	    if (!empty($this->product->neighbours ['previous'][0])) {
			$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
			echo JHTML::_('link', $prev_link, '<span class="icon-chevron-left"></span>'.$this->product->neighbours ['previous'][0]['product_name'], array('class' => 'previous-page'));
	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
			$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
			echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'].'<span class="icon-chevron-right"></span>', array('class' => 'next-page'));
	    }
	    ?>
    	<div class="clear"></div>
    	</div><!-- /.product-neighbours -->
	</div>
    <?php } // Product Navigation END ?>
</div>

	<?php // Show child categories
    if (VmConfig::get('showCategory', 1)) {
		echo $this->loadTemplate('showcategory');
    }?>

<div class="row-fluid">
	<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id, FALSE);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = vmText::_('COM_VIRTUEMART_SHOP_HOME') ;
	}
	?>
	<div class="span12">
		<div class="back-to-category mb2x">
    		<a href="<?php echo $catURL ?>" class="product-details" title="<?php echo $categoryName ?>"><?php echo vmText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
    	</div>
	</div>

</div>


	<?php
	echo vmJsApi::writeJS();
	?>

<script>
	// GALT
	/*
	 * Notice for Template Developers!
	 * Templates must set a Virtuemart.container variable as it takes part in
	 * dynamic content update.
	 * This variable points to a topmost element that holds other content.
	 */
	// If this <script> block goes right after the element itself there is no
	// need in ready() handler, which is much better.
	//jQuery(document).ready(function() {
	Virtuemart.container = jQuery('.productdetails-view');
	Virtuemart.containerSelector = '.productdetails-view';
	//Virtuemart.container = jQuery('.main');
	//Virtuemart.containerSelector = '.main';
	//});
</script>

