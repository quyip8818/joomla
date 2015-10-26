<?php
/**
 * sublayout products
 *
 * @package	VirtueMart
 * @author Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL2, see LICENSE.php
 * @version $Id: cart.php 7682 2014-02-26 17:07:20Z Milbo $
 */

defined('_JEXEC') or die('Restricted access');
$products_per_row = $viewData['products_per_row'];
$currency = $viewData['currency'];
$showRating = $viewData['showRating'];
$verticalseparator = " vertical-separator";
echo shopFunctionsF::renderVmSubLayout('askrecomjs');

$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}

foreach ($viewData['products'] as $type => $products ) {

	$rowsHeight = shopFunctionsF::calculateProductRowsHeights($products,$currency,$products_per_row);

	if(!empty($type) and count($products)>0){
		$productTitle = vmText::_('COM_VIRTUEMART_'.strtoupper($type).'_PRODUCT'); ?>

<div class="<?php echo $type ?>-view">
  <h3 class="m_title upperCase"><?php echo $productTitle ?></h3>
		<?php // Start the Output
    }

	// Calculating Products Per Row
	$cellwidth = ' width'.floor ( 100 / $products_per_row );

	$BrowseTotalProducts = count($products);

	$col = 1;
	$nb = 1;
	$row = 1;

	foreach ( $products as $product ) {
/*
		// Show the horizontal seperator
		if ($col == 1 && $nb > $products_per_row) { ?>
	<div class="horizontal-separator"></div>
		<?php }
*/
		// this is an indicator wether a row needs to be opened or not
		if ($col == 1) { ?>
	<div class="row-fluid vmlisting">
		<?php }

		// Show the vertical seperator
		if ($nb == $products_per_row or $nb % $products_per_row == 0) {
			$show_vertical_separator = ' ';
		} else {
			$show_vertical_separator = $verticalseparator;
		}

		// Calculating Products Per Row
		$BrowseProducts_per_row = $products_per_row;
		$Browsecellwidth = ' span' . floor (12 / $BrowseProducts_per_row);

    // Show Products ?>
	<div class="product <?php echo $Browsecellwidth . $show_vertical_separator ?>">
		<div class="inner-item product-list-item uppercase">
			<span class="hover"></span>
			<div class="image">
				<a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">
					<?php echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false); ?>
				</a>
			</div>

			<div class="prod-details fixclear">

				<h3><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h3>
				<p class="desc"><?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 40, '...'); ?>&nbsp;</p>
				<?php echo shopFunctionsF::renderVmSubLayout('kl_prices_basic',array('product'=>$product,'currency'=>$currency)); ?>

				<div class="kl-extra-info">
					<?php echo shopFunctionsF::renderVmSubLayout('kl_rating',array('showRating'=>$showRating, 'product'=>$product)); ?>
					<?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<span class="klstock kl-vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
					<?php } ?>
				</div>
			</div><!-- /.prod-details -->

			<div class="prod-actions">
				<?php
					// More info button
					$link = empty($product->link)? $product->canonical:$product->link;
					echo JHtml::link ( $link.$ItemidStr, vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ), array ('title' => $product->product_name, 'class' => 'product-details' ) );

					// Add to cart button
					echo shopFunctionsF::renderVmSubLayout('kl_addtocart',array('product'=>$product,'rowHeights'=>$rowsHeight[$row]));
				?>
			</div><!-- /.actions -->

			<div class="clear"></div>


		</div>
	</div>

	<?php
    $nb ++;

      // Do we need to close the current row now?
      if ($col == $products_per_row || $nb>$BrowseTotalProducts) { ?>
    <div class="clear"></div>
  </div>
      <?php
      	$col = 1;
		$row++;
    } else {
      $col ++;
    }
  }

      if(!empty($type)and count($products)>0){
        // Do we need a final closing row tag?
        //if ($col != 1) {
      ?>
    <div class="clear"></div>
  </div>
    <?php
    // }
    }
  }
