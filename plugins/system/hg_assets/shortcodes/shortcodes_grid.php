<?php
/**
 * Grid Shortcodes for HG Assets
 *
 * @package		Joomla
 * @subpackage	Grid Shortcodes
 * @version 	1.3
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$plugin = JPluginHelper::getPlugin('system', 'hg_assets');
$params = new JRegistry($plugin->params);
$bversion = $params->get('bversion', 3 );
$GLOBALS['bcol'] = ($bversion == 3) ? 'col-sm-' : 'span';

/*
* ------------------------------------------------- *
*		GRIDS
* ------------------------------------------------- *
*/

function hg_grid( $atts, $content = null ) {
 	//[grid 1-2-3-4-5-6-7-8-9-10-11-12]...[/grid]

	//columns
	$col = 1;
	if (isset($atts[0]) && trim($atts[0])){
		$col = trim($atts[0]);
	}

	//fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

	$grid  = '<div class="'.$GLOBALS['bcol'].$col.'">';
	$grid .= $content;
	$grid .= '</div>';

	return $grid;
}
add_shortcode('grid', 'hg_grid');

function hg_grid1( $atts, $content = null ) {
 	//[grid1][/grid1]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}

	//fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'1">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid1', 'hg_grid1');

function hg_grid2( $atts, $content = null ) {
 	//[grid2][/grid2]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'2">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid2', 'hg_grid2');

function hg_grid3( $atts, $content = null ) {
 	//[grid3][/grid3]
	//[grid3 first][/grid3]
	//[grid3 last][/grid3]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'3">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid3', 'hg_grid3');

function hg_grid4( $atts, $content = null ) {
 	//[grid4][/grid4]
	//[grid4 first][/grid4]
	//[grid4 last][/grid4]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'4">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid4', 'hg_grid4');

function hg_grid5( $atts, $content = null ) {
 	//[grid5][/grid5]
	//[grid5 first][/grid5]
	//[grid5 last][/grid5]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'5">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid5', 'hg_grid5');

function hg_grid6( $atts, $content = null ) {
 	//[grid6][/grid6]
	//[grid6 first][/grid6]
	//[grid6 last][/grid6]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'6">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid6', 'hg_grid6');

function hg_grid7( $atts, $content = null ) {
 	//[grid7][/grid7]
	//[grid7 first][/grid7]
	//[grid7 last][/grid7]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'7">'.$content.'</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid7', 'hg_grid7');

function hg_grid8( $atts, $content = null ) {
 	//[grid8][/grid8]
	//[grid8 first][/grid8]
	//[grid8 last][/grid8]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'8">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid8', 'hg_grid8');

function hg_grid9( $atts, $content = null ) {
 	//[grid9][/grid9]
	//[grid9 first][/grid9]
	//[grid9 last][/grid9]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'9">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid9', 'hg_grid9');

function hg_grid10( $atts, $content = null ) {
 	//[grid10][/grid10]
	//[grid10 first][/grid10]
	//[grid10 last][/grid10]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'10">';
	$grid .= $content;
	$grid .= '</div>';
	if($order == "last") $grid .= '</div>';

return $grid;
}
add_shortcode('grid10', 'hg_grid10');

function hg_grid11( $atts, $content = null ) {
 	//[grid11][/grid11]
	//[grid11 first][/grid11]
	//[grid11 last][/grid11]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'11">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('grid11', 'hg_grid11');

function hg_grid12( $atts, $content = null ) {
 	//[grid12][/grid12]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);
	}

	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row" data-grid="'.$order.'">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'12">';
	$grid .= $content;
	$grid .= '</div>';

	if (isset($atts[1]) && trim($atts[1])){
		$grid .= '</div>';
	} else if($order == "last") {
		$grid .= '</div>';
	}

	return $grid;
}
add_shortcode('grid12', 'hg_grid12');

function hg_onethird( $atts, $content = null ) {
 	//[onethird][/onethird]
	//[onethird first][/onethird]
	//[onethird last][/onethird]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order=trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'4">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('onethird', 'hg_onethird');

function hg_twothirds( $atts, $content = null ) {
 	//[twothirds][/twothirds]
	//[twothirds first][/twothirds]
	//[twothirds last][/twothirds]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order=trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="'.$GLOBALS['bcol'].'8">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('twothirds', 'hg_twothirds');

function hg_half( $atts, $content = null ) {
 	//[half][/half]
	//[half first][/half]
	//[half last][/half]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order=trim($atts[0]);
	}
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid .= '<div class="'.$GLOBALS['bcol'].'6">';
	$grid .= $content;
	$grid .= '</div>';

	if($order == "last") $grid .= '</div>';

	return $grid;
}
add_shortcode('half', 'hg_half');

function hg_row( $atts, $content = null ) {
 	//[row class="" fluid="no" container="no"][/row]

	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

	extract(shortcode_atts(array(
    	"class" => '',
    	"container" => 'no',
    	"fluid" => 'no'
	), $atts));

	$overlayToggle = '';
	$ovScript = '';
	if(strpos($class, 'show_id')){
		$overlayToggle = '<div class="'.$GLOBALS['bcol'].'12"><a href="#" id="hideOverlayModules" class="btn btn-primary" style="margin-bottom:30px;">Hide the modules overlay with ID</a></div>';
		$ovScript = '
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#hideOverlayModules").toggle(function(e) {
				jQuery(".'.($fluid == 'yes' ? 'row-fluid':'row').'.all_modules").removeClass("show_id");
				jQuery(this).text("SHOW the modules overlay with ID.");
				jQuery(this).removeClass("btn-primary");
			}, function() {
				jQuery(".'.($fluid == 'yes' ? 'row-fluid':'row').'.all_modules").addClass("show_id");
				jQuery(this).text("HIDE the modules overlay with ID.");
				jQuery(this).addClass("btn-primary");
			});
		});
		</script>
		';
	}
	$html = ($container == 'yes' ? '<div class="container">' : '');
	$html .= '<div class="'.($fluid == 'yes' ? 'row-fluid':'row').' '.$class.'">'.$overlayToggle.' '.$content.'</div>'.$ovScript;
	$html .= ($container == 'yes' ? '</div>' : '');

	return $html;
}
add_shortcode('row', 'hg_row');
?>
