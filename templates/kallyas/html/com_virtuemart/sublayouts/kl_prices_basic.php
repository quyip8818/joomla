<?php
/**
 *
 * Show the product prices
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_showprices.php 8024 2014-06-12 15:08:59Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
$product = $viewData['product'];
$currency = $viewData['currency'];
// print_r($product->prices);
$discountSymbol = ($product->prices['basePrice'] > $product->prices['salesPrice']) ? '-':'';
?>
<div class="product-price price" id="productPrice<?php echo $product->virtuemart_product_id ?>">
	<?php
		if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($product->images[0]) and !$product->images[0]->file_is_downloadable) {
			echo '<span class="askpricenotice">'.JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE').'</span>';
		} else {

			echo '<span class="oldprice">';
			if ($product->prices['basePrice'] != $product->prices['salesPrice']) {
				echo '<span class="linethrough PricebasePriceVariant">'.$currency->createPriceDiv ('basePriceVariant', 'COM_VIRTUEMART_PRODUCT_BASEPRICE_VARIANT', $product->prices, true).'</span><span class="applieddiscount">('.$discountSymbol.$currency->createPriceDiv ('discountAmount', '', $product->prices, true) .')</span>';
			}
			echo '&nbsp;</span>';
			echo '<span class="PricesalesPrice salesprice">'.$currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices, true).'</span>';
		}
	?>
</div>
<div class="clear"></div>
