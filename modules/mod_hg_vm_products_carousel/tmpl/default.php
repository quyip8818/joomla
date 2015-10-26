<?php // no direct access
defined ('_JEXEC') or die('Restricted access');

JLoader::register('JHtmlString', JPATH_LIBRARIES.'/joomla/html/html/string.php');
$document = JFactory::getDocument();

$col = 1;
$last = count ($products) - 1;
$customitemid = $params->get('customitemid');
$app = JApplication::getInstance('site');
$sep = $app->getCfg('sef') ? '?':'&';
$itemid = $customitemid ? $sep.'Itemid='.$customitemid : '';
?>
<div class="row shop-latest-products <?php echo $params->get ('moduleclass_sfx') ?>">

		<?php foreach ($products as $product) :
	$days = 10;
	$created = $product->created_on;
	$date = JFactory::getDate (time () - (60 * 60 * 24 * $days));
	$newprod = ($created > $date) ? 'promo-new':'';

		?>
		<div class="span3">
			<div class="product-list-item <?php if($product->prices['discountAmount']) echo 'promo-sale'; ?> <?php echo $newprod; ?>">
				<span class="hover"></span>
				<?php

				$image = (!empty($product->images[0])) ? $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE):'';

				echo '<div class="image">'.JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id).$itemid, $image, array('title' => $product->product_name)).'</div>';

				$link = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id).$itemid;
				?>
				<div class="prod-details fixclear">
					<h3><?php echo JHtml::link ($link.$itemid, $product->product_name); ?></h3>
					<p class="desc"><?php echo JHtmlString::truncate($product->product_desc, 80, true, false); ?>&nbsp;</p>
					<?php echo shopFunctionsF::renderVmSubLayout('kl_prices_basic',array('product'=>$product,'currency'=>$currency)); ?>
					<div class="kl-extra-info">
						<?php echo shopFunctionsF::renderVmSubLayout('kl_rating',array('showRating'=>$showRating, 'product'=>$product)); ?>
					</div>
				</div><!-- /.prod-details -->

				<div class="prod-actions">
					<?php
						// More info button
						echo JHtml::link ( $link.$itemid, vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ), array ('title' => $product->product_name, 'class' => 'product-details' ) );
						// Add to cart button
						// echo shopFunctionsF::renderVmSubLayout('kl_addtocart',array('product'=>$product));
						if ($show_addtocart) echo mod_virtuemart_product_hgcarousel::addtocart ($product, $params);
					?>
				</div><!-- /.actions -->

			</div><!-- end prod item -->
		</div>
	<?php endforeach; ?>
	<div class="clear"></div>
</div>