<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$cart_show = $data->cart_show;
?>

<div class="vmHeaderCart vmCartModule vmCartModule<?php echo $module->id; ?>" id="vmCartModule<?php echo $module->id; ?>">
	<p class="cart_details">
		<span class="total_products"><?php echo  $data->totalProductTxt ?></span>&nbsp;/&nbsp;
		<span class="total"><?php if ($data->totalProduct and $show_price) echo  $data->billTotal; ?></span>
		<?php
		if(preg_match_all("|<a.*(?=href=\"([^\"]*)\")[^>]*>([^<]*)</a>|i", $cart_show, $matches)) {
			echo '<a class="checkout" href="'.$matches[1][0].'"><span class="icon-shopping-cart"></span> '.$matches[2][0].'</a>';
		}
		?>
	</p>
</div><!-- end vmcartmodule -->
