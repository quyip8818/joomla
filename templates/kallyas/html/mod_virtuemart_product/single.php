<?php // no direct access
defined('_JEXEC') or die('Restricted access');
vmJsApi::jPrice();

?>
<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php } ?>

<div class="mod_vm_product vmproduct<?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($products as $product) { ?>
	<div class="product-list-item">
		<span class="hover"></span>
<?php
 if (!empty($product->images[0]) )
 $image = $product->images[0]->displayMediaThumb('class="featuredProductImage" ',false) ;
 else $image = '';
 echo '<div class="image">'.JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id),$image,array('title' => $product->product_name) ).'</div>';

$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id); ?>

<div class="prod-details fixclear">
	<h3><a href="<?php echo $url ?>"><?php echo $product->product_name ?></a></h3>
	<p class="desc"><?php echo JHtmlString::truncate($product->product_desc, 100, true, false); ?></p>

	<div class="price">
	<?php
	if ($show_price and  isset($product->prices)) {
		echo '<span class="oldprice">';
		if ($product->prices['basePrice'] != $product->prices['salesPrice']) {
			echo '<span class="linethrough">'.$currency->createPriceDiv ('basePriceVariant', 'COM_VIRTUEMART_PRODUCT_BASEPRICE_VARIANT', $product->prices, true).'</span><span class="applieddiscount">('.$currency->createPriceDiv ('discountAmount', '', $product->prices, true) .')</span>';
		}
		echo '&nbsp;</span>';
		echo '<span class="salesprice">'.$currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices, true).'</span>';
	}
	?>
	</div>

	<div class="prod-actions">
		<a href="<?php echo $url ?>" class="product-details actionBtn"><?php echo vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ) ?></a>
		<div class="clear"></div>
		<?php
		if ($show_addtocart) echo mod_virtuemart_product::addtocart($product);
		?>
	</div>

</div><!-- end prod-details -->

	</div><!-- end product-list-item -->
	<?php } ?>
<?php if ($footerText) { ?>
	<p class="vmheader"><?php echo $footerText ?></p>
<?php } ?>
</div>
</div>