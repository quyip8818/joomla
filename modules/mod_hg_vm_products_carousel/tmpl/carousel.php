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

// TODO: add option
$showRating = 1;

$checkcarouFredSel = false;
$header = $document->getHeadData();
foreach($header['scripts'] as $scriptName => $scriptData)
	if(substr_count($scriptName,'/jquery.carouFredSel'))
		$checkcarouFredSel = true;

if(!$checkcarouFredSel)
$document->addScript('modules/mod_hg_vm_products_carousel/assets/jquery.carouFredSel.js');

$js = '
;(function($) {
	$(document).ready(function(){
		var _t = $("#hgvm_carousel'.$module->id.'");
		_t.carouFredSel({
			responsive: true,
			scroll: 1,
			auto: false,
			height: 385,
			items: {width:300, visible: { min: 1, max: 4 } },
			prev	: {	button : _t.parent().find("a.prev"), key : "left" },
			next	: { button : _t.parent().find("a.next"), key : "right" }
		});
	});
})(jQuery);';
$document->addScriptDeclaration($js);
?>
<div class="shop-latest-carousel <?php echo $params->get ('moduleclass_sfx') ?>">

	<ul id="hgvm_carousel<?php echo $module->id; ?>">
		<?php foreach ($products as $product) :


	$days = 10;
	$created = $product->created_on;

	$date = JFactory::getDate (time () - (60 * 60 * 24 * $days));

	$newprod = ($created > $date) ? 'promo-new':'';
	// $link = empty($product->link)? $product->canonical:$product->link;
	$link = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id);

		?>
		<li>
			<div class="product-list-item <?php if($product->prices['discountAmount']) echo 'promo-sale'; ?> <?php echo $newprod; ?>">
				<span class="hover"></span>
				<?php
				$image = (!empty($product->images[0])) ? $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE):'';
				echo '<div class="image">'.JHTML::_ ('link', $link.$itemid, $image, array('title' => $product->product_name)).'</div>';
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

				<div class="clear"></div>

			</div><!-- end prod item -->
		</li>
	<?php endforeach; ?>
	</ul>
	<div class="controls">
		<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
		<a href="#" class="next"><span class="icon-chevron-right"></span></a>
	</div>
	<div class="clear"></div>

</div>