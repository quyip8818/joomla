<?php defined('_JEXEC') or die('Restricted access');

$product = $viewData['product'];

if ($viewData['showRating']) {
	$maxrating = VmConfig::get('vm_maximum_rating_scale', 5);
	$rating = round($product->rating);
	$ratingbox_title = empty($product->rating) ? vmText::_('COM_VIRTUEMART_UNRATED') : vmText::_("COM_VIRTUEMART_RATING_TITLE") . $rating . '/' . $maxrating;
?>
<div class="rating_block">
	<strong>Rating:  5/5</strong>
	<div title=" <?php echo $ratingbox_title ?>" class="ratingbox" >
<?php
for ($i = 1; $i <= $maxrating; $i++){
	$israted = $i <= $rating ? 'israted':'';
	echo '<span class="'.$israted.'">☆</span>';
}
?>
	</div>
</div>
<?php

}