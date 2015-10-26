<?php
/**
 * HG Assets Shortcodes
 *
 * @package		Joomla
 * @subpackage	Shortcodes
 * @version 	1.3
 */

  // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

require_once dirname(__FILE__).'/shortcodes_helper.php';
require_once dirname(__FILE__).'/shortcodes_grid.php';

if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);

$plugin = JPluginHelper::getPlugin('system', 'hg_assets');
$params = new JRegistry($plugin->params);
$bversion = $params->get('bversion', 3 );
$GLOBALS['bv'] = $bversion;

/*
* ------------------------------------------------- *
*		Module anywhere
* ------------------------------------------------- *
*/

function hg_module( $atts, $content = null ) {
	//[module id="" class="" style="" overrides=""]
	// override format: something=yyy|something_else=xxx

	extract(shortcode_atts(array(
    	"id" => '',
    	"class" => '',
		"style" => 'none',
		"overrides" => ''
	), $atts));

	$document = JFactory::getDocument();
	$renderer = $document->loadRenderer('module');

	$contents = '';

	//get module as an object
	$db = JFactory::getDbo();
    $query = $db->getQuery(true);

	$query->select('*');
	$query->from($db->quoteName('#__modules'));
	$query->where(array(
	        $db->quoteName('id') . '=\''.$id.'\'',
	        $db->quoteName('published') . '=\'1\''
	    ));
	$db->setQuery($query);

	$modules = $db->loadObjectList();
	// var_dump($db);die;
	$module = $modules[0];

	//just to get rid of that stupid php warning
	// $module->user = '';
	$params = $module->params;

	if(!empty($overrides)) {
		$attrs = explode('|',$overrides);
		$paramsDec = json_decode($params);
		foreach( $attrs as $key => $over ) {
			$attrs2 = explode(':',$over);
			$paramsDec->$attrs2[0] = $attrs2[1];
		}
		$params = json_encode($paramsDec);
	}

	$params_fin =  array('style' => $style, 'params' => $params);
	$contents = $renderer->render($module, $params_fin);

	return $contents;
}

add_shortcode('module', 'hg_module');


//Google Maps Shortcode
// [googlemap width="" height="" src=""] [/googlemap]
function am_googleMaps($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '320',
      "height" => '230',
      "src" => ''
   ), $atts));
   return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'"></iframe>';
}
add_shortcode("googlemap", "am_googleMaps");

/*
* ------------------------------------------------- *
*		Code
* ------------------------------------------------- *
*/
//code
function am_code( $atts, $content = null ) {
	//[code][/code]
	$am_code='<code>';
	$content = preg_replace('#^<\/p>|<p>$#', '', trim($content));
	$am_code .= do_shortcode($content);
	$am_code .='</code>';
	return $am_code;
}

add_shortcode('code', 'am_code');

//pre
function am_pre( $atts, $content = null ) {
	//[pre][/pre]
	$am_pre='<pre>';
	$content = preg_replace('#^<\/p>|<p>$#', '', trim($content));
	$am_pre .= do_shortcode($content);
	$am_pre .='</pre>';
	return $am_pre;
}

add_shortcode('pre', 'am_pre');

 /*
* ------------------------------------------------- *
*		Headings
* ------------------------------------------------- *
*/

//H1
function hg_h1( $atts, $content = null ) {
	//[h1 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));

	$style = 'style="'.$style.'; text-align:'.$textalign.';"';

	$hg_h1='<h1 class="'.$class.'"  '.$style.'>';
	$hg_h1 .= do_shortcode(strip_tags($content));
	$hg_h1.='</h1>';
	return $hg_h1;
}
add_shortcode('h1', 'hg_h1');
//---------------------------------------------------

//H2
function hg_h2( $atts, $content = null ) {
	//[h2 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));

	$style = 'style="'.$style.'; text-align:'.$textalign.';"';

	$hg_h2='<h2 class="'.$class.'"  '.$style.'>';
	$hg_h2 .= do_shortcode(strip_tags($content));
	$hg_h2.='</h2>';
	return $hg_h2;
}
add_shortcode('h2', 'hg_h2');
//---------------------------------------------------

//H3
function hg_h3( $atts, $content = null ) {
	//[h3 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));

	$style = 'style="'.$style.'; text-align:'.$textalign.';"';

	$hg_h3='<h3 class="'.$class.'" '.$style.'>';
	$hg_h3 .= do_shortcode(strip_tags($content));
	$hg_h3.='</h3>';
	return $hg_h3;
}

add_shortcode('h3', 'hg_h3');
//---------------------------------------------------

//H4
function hg_h4( $atts, $content = null ) {
	//[h4 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));

	$style = 'style="'.$style.'; text-align:'.$textalign.';"';

	$hg_h4='<h4 class="'.$class.'"  '.$style.'>';
	$hg_h4 .= do_shortcode(strip_tags($content));
	$hg_h4.='</h4>';
	return $hg_h4;
}
add_shortcode('h4', 'hg_h4');
//---------------------------------------------------

//H5
function hg_h5( $atts, $content = null ) {
	//[h5 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));

	$style = 'style="'.$style.'; text-align:'.$textalign.';"';

	$hg_h5='<h5 class="'.$class.'"  '.$style.'>';
	$hg_h5 .= do_shortcode(strip_tags($content));
	$hg_h5.='</h5>';
	return $hg_h5;
}
add_shortcode('h5', 'hg_h5');
//---------------------------------------------------

//H6
function hg_h6( $atts, $content = null ) {
	//[h6 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));

	$style = 'style="'.$style.'; text-align:'.$textalign.';"';

	$hg_h6='<h6 class="'.$class.'"  '.$style.'>';
	$hg_h6 .= do_shortcode(strip_tags($content));
	$hg_h6.='</h6>';
	return $hg_h6;
}
add_shortcode('h6', 'hg_h6');
//---------------------------------------------------

//Heading
function hg_heading( $atts, $content = null ) {
	//[heading size="" class="" style="" textalign=""][/heading]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left',
		"size" => 'h4'
	), $atts));

	$style = 'style="'.$style.'; text-align:'.$textalign.';"';

	$hg_heading='<'.$size.' class="'.$class.'"  '.$style.'>';
	$hg_heading .= do_shortcode(strip_tags($content));
	$hg_heading.='</'.$size.'>';
	return $hg_heading;
}
add_shortcode('heading', 'hg_heading');
//---------------------------------------------------


/*
* ------------------------------------------------- *
*		TYPOGRAPHY
* ------------------------------------------------- *
*/
//p
function hg_paragraph( $atts, $content = null ) {
	//[paragraph][/paragraph]
	$hg_paragraph='<p>';
	$hg_paragraph .= do_shortcode(strip_tags($content));
	$hg_paragraph.='</p>';
	return $hg_paragraph;
}
add_shortcode('paragraph', 'hg_paragraph');
//---------------------------------------------------

//blockquote
function hg_blockquote( $atts, $content = null ) {
	//[blockquote][/blockquote]
	$hg_blockquote='<blockquote>';
	$hg_blockquote .= do_shortcode(strip_tags($content));
	$hg_blockquote.='</blockquote>';
	return $hg_blockquote;
}
add_shortcode('blockquote', 'hg_blockquote');
//---------------------------------------------------

function hg_small($atts, $content = null ) {
	//[small][/small]
	return '<small>'.$content.'</small>';
}
add_shortcode('small', 'hg_small');


//image
function hg_image( $atts, $content = null ) {
	//[image path="" alt="" title="" class="" style=""]

	extract(shortcode_atts(array(
		"path" => '',
		"alt"=> '',
		"title"=> '',
		"class"=>'',
		"style"=> ''
	), $atts));

	return '<img src="'.$path.'" alt="'.$alt.'"  title="'.$title.'" class="'.$class.'" style="'.$style.'" />';
}
add_shortcode('image', 'hg_image');
//---------------------------------------------------

/*
* ------------------------------------------------- *
*		highlights
* ------------------------------------------------- *
*/
function hg_highlights( $atts, $content = null ) {
	// [hlight warning - success - info - inverse][/hlight]

	//class
	if (isset($atts[0]) && trim($atts[0]))
		$class=trim($atts[0]);
	else
		$class="info";

	//fix shortcode
	$content = fixshortcode($content);
	$content = '<span class="label label-'.$class.'">'.trim($content).'</span>';

	return $content;
}
add_shortcode('hlight', 'hg_highlights');
//---------------------------------------------------


/*
* ------------------------------------------------- *
*		lists
* ------------------------------------------------- *
*/
function hg_lined_list( $atts, $content = null ) {
	// [list 1 - 2 - 3 - 4 - 5 - 6 - 7 - 8 - 9 class="" style="" columns="" ][/list]

	extract(shortcode_atts(array(
		"columns" => '',
		"style"=> '',
		"class"=> ''
	), $atts));

	$columns = ($columns) ? 'cols-'.$columns.' clearfix' : 'cols-1 clearfix';
	//class
	$type = '';
	if (isset($atts[0]) && trim($atts[0])){
		$type=trim($atts[0]);
	}

	//fix shortcode
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	$content = preg_replace('#<ul>#', '<ul class="list-style'.$type.' '.$columns.' '.$class.'" '.(($style != '') ? 'style="'.$style.'"' : '').'>', trim($content));

	return $content;
}
add_shortcode('list', 'hg_lined_list');


/*
* ------------------------------------------------- *
*		BUTTONS
* ------------------------------------------------- *
*/
function hg_btn( $atts, $content = null ) {
/*[btn size="" type="" class="" class="" disabled="" link="" target="" icon="" icontheme=""][/btn]
type: primary / info / success / warning / danger / inverse / link / flat
size: normal / lg / sm / xs
disabled: yes / no
icon: add the icon type without the " icon- "
icontheme: white/black
*/
	extract(shortcode_atts(array(
		"disabled" => 'no',
		"size" => 'normal',
		"class" => '',
		"style" => '',
		"type" => 'primary',
		"link" => '#',
		"target" => '_self',
		"icon" => '',
		"icontheme" => 'white'
	), $atts));

	$disabled = ($disabled == 'yes') ? 'disabled' : '';

	$icon = ($icon ? '<span class="fa fa-'.$icon.' icon-'.$icontheme.'"></span>':'');

	return '<a href="'.$link.'" class="btn btn-'.$size.' btn-'.$type.' '.$class.' '.$disabled.'" style="'.$style.'" target="'.$target.'">'.$icon.$content.'</a>';
}
add_shortcode('btn', 'hg_btn');

//---------------------------------------------------

/*
* ------------------------------------------------- *
*		show shortcode :)
* ------------------------------------------------- *
*/

function hg_shortcode_show_shortcode( $atts, $content = null ) {

	//convert html [] spacial chars

	//fix shortcode
	$content = fixshortcode($content);
	$content = preg_replace('#<br \/>#', "\n",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	$content = preg_replace('#\[\/braket_close\]#', "[/show_shortcode]",trim($content));

	extract(shortcode_atts(array(
		"code" => ''
	), $atts));

	if($code == "html5") {
		return $content;
	} else {
		return '<pre>' . htmlspecialchars($content) . '</pre>';
	}
}
add_shortcode('show_shortcode', 'hg_shortcode_show_shortcode');


/*
* ------------------------------------------------- *
*		Accordions
* ------------------------------------------------- *
*/
function hg_accordion( $atts, $content = null ) {

 	// [accordion class="" id=""] ... [/accordion]

	extract(shortcode_atts(array(
		"class" => '',
		"id" => ''
	), $atts));

	//fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

	$html = '<div id="'.$id.'" class="accordion-group '.$class.'">'.$content.'</div><!-- end accordion-group -->';

	return $html;
}
add_shortcode('accordion', 'hg_accordion');
//---------------------------------------------------

function hg_acc( $atts, $content = null ) {

 	// [acc title="" style="" start_opened=" yes / no " striptags=" yes / no " parent=""] ... [/acc]

	extract(shortcode_atts(array(
		"title" => 'Title here',
		"style" => 'default-style',
		"start_opened" => 'no',
		"striptags" => 'no',
		"parent" => ''
	), $atts));

	//fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    if($striptags == 'yes') {
		$content = preg_replace('#<br \/>#', "",trim($content));
		$content = preg_replace('#<p>#', "",trim($content));
		$content = preg_replace('#<\/p>#', "",trim($content));
	}
	$random = mt_rand();
	$html = '
	<div class="acc-group '.$style.' '.($parent ? 'panel':'').'">
		<button data-toggle="collapse" '.($parent ? 'data-parent="#'.$parent.'"' : '').' data-target="#acc'.$random.'" class="'.($start_opened != 'no' ? '':'collapsed').' '.($style == 'style2' ? 'btn-link':'').'">'.$title.'</button>
		<div id="acc'.$random.'" class="acc_content collapse '.($start_opened == 'yes' ? 'in':'').'">
			<div class="content">
				'.$content.'
				<div class="clearfix"></div>
			</div><!-- end content -->
		</div>
	</div><!-- end acc group -->
	';

	return $html;
}
add_shortcode('acc', 'hg_acc');
//---------------------------------------------------


/* TABS shortcode*/
function hg_tabs( $atts, $content ){
	// [tabs class="" style="" first_tab="" icons_theme=""][/tabs]
	// style = vertical_tabs / tabs_style1 / tabs_style2 / tabs_style3 / tabs_style4
	// icons_theme = white / black

	if (isset($GLOBALS['tabs_count'])) $GLOBALS['tabs_count']++;
    else $GLOBALS['tabs_count'] = 0;

	extract(shortcode_atts(array(
		'class' => '',
		'style' => 'tabs_style1',
		'first_tab' => 1,
		'icons_theme' => 'white'
	), $atts));

	preg_match_all('/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);
	preg_match_all('/icon="([^\"]+)"/', $content, $imatches, PREG_OFFSET_CAPTURE);

	$tab_titles = array();
	$tab_icons = array();
	if (isset($matches[1])) {
		$tab_titles = $matches[1];
		$tab_icons = $imatches[1];
	}

	$output = '';

	$btv = $GLOBALS['bv'];

	if (count($tab_titles)) {
		$output .= '<div class=" '.($btv == 3 ? 'hg-tabs' : 'tabbable').' '.$style.' '.$class.'"><ul class="nav '.($btv == 3 ? 'nav-tabs' : '').' clearfix">';
		$i = 1;
		// print_r($tab_icons);
		foreach($tab_titles as $t => $tab) {
			if ($i == $first_tab) $output .= '<li class="active">';
			else $output .= '<li>';

			$output .= '<a href="#custom-tab-'.$GLOBALS['tabs_count'].'-'.HgShortcodesHelper::maketabid($tab[0]).'" data-toggle="tab">'.(isset($tab_icons[$t][0]) ? '<span><span class="'.($btv == 3 ? 'fa fa-' : '').$tab_icons[$t][0].' icon-'.$icons_theme.'"></span></span>':'').$tab[0].'</a></li>';
			$i++;
		}

		$output .= '</ul>';
		$output .= '<div class="tab-content">';
		$output .= do_shortcode($content);
		$output .= '</div></div>';
	} else {
		$output .= do_shortcode($content);
	}

	return $output;

}
add_shortcode( 'tabs', 'hg_tabs' );



function hg_tab( $atts, $content ){
	// [tab title="" icon=""] ... [/tab]
	// for full list of icons go here

	if (!isset($GLOBALS['current_tabs'])) {
		$GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
		$state = 'active';
	} else {
		if ($GLOBALS['current_tabs'] == $GLOBALS['tabs_count']) {
			$state = '';
		} else {
			$GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
			$state = 'active';
		}
	}

	$defaults = array('title' => 'Tab', 'icon' => '');
	extract(shortcode_atts($defaults, $atts));

	return '<div id="custom-tab-'.$GLOBALS['tabs_count'].'-'.HgShortcodesHelper::maketabid($title).'" class="tab-pane '.$state.'">'.do_shortcode($content).'</div>';

}
add_shortcode( 'tab', 'hg_tab' );

/*
* ------------------------------------------------- *
*		Info Box
* ------------------------------------------------- *
*/

function hg_shortcode_infobox( $atts, $content = null ) {
    //[infobox title="" class="" url="" url_text="" target=""] .. [/infobox]

    extract(shortcode_atts(array(
		"title" => '',
		"style" => '',
		"class" => '',
		"url" => '',
		"url_text" => '',
		"target" => '_self'
	), $atts));

	$class .= ($url ? 'infobox2' :'infobox1');

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    return '<div class="'.$class.'">'.
		($url ? '<a href="'.$url.'" target="'.$target.'" class="btn btn-large btn-inverse">'.$url_text.'</a>':'').
		($title ? '<h3 class="m_title">'.$title.'</h3>':'').
		($content ? '<div>'.$content.'</div>':'').'
	</div>';
}

add_shortcode('infobox', 'hg_shortcode_infobox');
//---------------------------------------------------


/*
* ------------------------------------------------- *
*		VIDEO Embedding
* ------------------------------------------------- *
*/


// vimeo video
function hg_vimeo( $atts, $content = null ) {
 	//[vimeo id="" width="" height="" autoplay="" color="" class="" embed_type=""]
	// embed type = flash / iframe
	extract(shortcode_atts(array(
		"id" => '',
		"width" => '475',
		"height" => '350',
		"autoplay" => '0',
		"color" => '00adef',
		"embed_type" => 'iframe',
		"class" => ''
	), $atts));

	$flash = '<object width="'.$width.'" height="'.$height.'"><param name="allowfullscreen" value="true" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color='.$color.'&amp;fullscreen=1&amp;autoplay='.$autoplay.'&amp;loop=0" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color='.$color.'&amp;fullscreen=1&amp;autoplay='.$autoplay.'&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" wmode="transparent" allowscriptaccess="always" width="'.$width.'" height="'.$height.'"></embed></object>';

	$iframe = '<iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay='.$autoplay.'" width="'.$width.'" height="'.$height.'" frameborder="0" class="'.$class.'" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

	if($embed_type == 'flash')
		$video = $flash;
	elseif($embed_type == 'iframe')
		$video = $iframe;

	return $video;
}
add_shortcode('vimeo', 'hg_vimeo');
//---------------------------------------------------

// youtube video
function hg_youtube( $atts, $content = null ) {
 	//[youtube id="" width="" height="" autoplay="" playhd="" controls="" wmode="" showinfo="" class="" ]
	extract(shortcode_atts(array(
		"id" => '',
		"width" => '475',
		"height" => '350',
		"autoplay" => '0',			// 0 = No, 1 = Yes
		"playhd" => '0',			// 0 = No, 1 = Yes
		"controls" => '1',			// 0 = No, 1 = Yes
		"wmode" => 'transparent',	// opaque / transparent
		"showinfo" => '1',			// 0 = No, 1 = Yes
		"class" => ''
	), $atts));

	return '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?&amp;autoplay='.$autoplay.'&amp;rel=0&amp;fs=0&amp;showinfo='.$showinfo.'&amp;controls='.$controls.'&amp;hd='.$playhd.'&amp;wmode='.$wmode.'" frameborder="0" allowfullscreen="" class="'.$class.'"></iframe>';
}
add_shortcode('youtube', 'hg_youtube');
//---------------------------------------------------



/*
* ------------------------------------------------- *
*		MISC
* ------------------------------------------------- *
*/

function hg_separator( $atts, $content = null ) {
 	//[separator class=""]
 	extract(shortcode_atts(array(
		"class" => ''
	), $atts));
	return '<div class="separator '.$class.'"></div>';
}
add_shortcode('separator', 'hg_separator');
//---------------------------------------------------

function hg_space( $atts, $content = null ) {
 	//[space height=""]

	extract(shortcode_atts(array(
		"height"=> ''
	), $atts));

	return '<div style="height:'.$height.'px;"></div>';
}
add_shortcode('space', 'hg_space');
//---------------------------------------------------


// big-quote
function hg_quotes( $atts, $content = null ) {
 	//[quotes name=""][/quotes]
	//fix shortcode
	extract(shortcode_atts(array(
		"name"=> ''
	), $atts));

	$content = fixshortcode($content);
	$content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	return '
<div class="quotes">
<blockquote>
<p>'.$content.'<br />
<small>'.$name.'</small>
</p>
</blockquote>
</div>';
}
add_shortcode('quotes', 'hg_quotes');



function hg_clear( $atts, $content = null ) {
 	//[clear_float]

	return '<div class="clear"></div>';
}
add_shortcode('clear_float', 'hg_clear');


function hg_popup_link($atts, $content = null ) {
	//[popup_link text="" tooltip="" link="" type="" icon=""][/popup_link]
	extract(shortcode_atts(array(
		"text" => '',
		"tooltip" => '',
		"link" => '#',
		"type" => 'image',
		"icon" => ''
	), $atts));
	return '<a class="map_link" '.((bool)$tooltip ? 'title="'.$tooltip.'" data-toggle="tooltip" data-placement="top"':'').' data-lightbox="'.$type.'" href="'.$link.'">'.((bool)$icon ? '<i class="fa '.$icon.'"></i> ':'').$text.'</a>';
}
add_shortcode('popup_link', 'hg_popup_link');

function hg_loadstyle( $atts, $content = null ) {
 	// [loadstyle styles=""]
 	extract(shortcode_atts(array(
		"styles"=> ''
	), $atts));
	$doc = JFactory::getDocument();
	$doc->addStyleDeclaration($styles);
}
add_shortcode('loadstyle', 'hg_loadstyle');
//-------------------------------------------------


function hg_alert( $atts, $content = null ) {
 	// [alert type=""]...[/alert]
	// info, success, danger, error

	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

	extract(shortcode_atts(array("type" => 'info'), $atts));
	return '<div class="alert alert-'.$type.'">'.$content.'</div>';
}
add_shortcode('alert', 'hg_alert');
//---------------------------------------------------


function hg_error( $atts, $content = null ) {
 	// [error code=""]...[/error]
	//fix shortcode
	$content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
	extract(shortcode_atts(array("code" => ''), $atts));
	$html = array();
	$html[] = '<div class="row">';
	$html[] = '  <div class="col-sm-12">';
	$html[] = '    <div class="error404">';
	$html[] = '    <h2><span>'.$code.'</span></h2>';
	$html[] = '    <h3>'.$content.'</h3>';
	$html[] = '    </div>';
	$html[] = '  </div>';
	$html[] = '</div>';

	return implode("\n",$html);
}
add_shortcode('error', 'hg_error');
//---------------------------------------------------


function hg_simpleGallery( $atts, $content = null ) {
	// [simple_gallery folder="" width="" height="" class="" resize="" scale=""]

	extract(shortcode_atts(array(
		"folder" => '',
		"width" => 100,
		"height" => 100,
		"class" => '',
		"imgclass" => 'thumbnail',
		"resize" => 1, // 1 = Yes ; 0 = No,
		"scale" => 2 // from 1 to 5
	), $atts));

	$caching_folder = 'simplegallery_shc';

	$html = array();
	$html[] = '<div class="simple_gallery '.$class.'">';
	$html[] = '<ul class="gallery">';

		if (!is_dir($folder))
			$folder = JPATH_ROOT . '/' . $folder;
		// Get a list of files in the search path with the given filter.
		$filter = '\.png$|\.gif$|\.jpg$';
		$files = JFolder::files($folder, $filter);
		// Build the options list from the list of files.
		if (is_array($files))
		{
			foreach ($files as $file)
			{
				$stripext = JFile::stripExt($file);
				$cachedResizedThumbnail = $resize ? JURI::base(true).'/cache/'.$caching_folder.'/'.HgShortcodesHelper::createThumb( $folder.$file , $width, $height, $scale, $caching_folder) : $folder.$file;
				$html[] = '<li><a href="'.$folder.$file.'" data-lightbox="image" class="thumbnail"><img src="'.$cachedResizedThumbnail.'" alt="'.$stripext.'" class="img-responsive "></a></li>';
			}
		}
	$html[] = '</ul>';
	$html[] = '</div>';

	return implode("\n",$html);
}
add_shortcode('simple_gallery', 'hg_simpleGallery');
//---------------------------------------------------

// Load Custom Shortcodes
$custom_shc_path = JPATH_THEMES.DS.(JFactory::getApplication()->getTemplate()).DS.'custom'.DS.'shortcodes'.DS.'shortcodes.php';
if (JFile::exists($custom_shc_path))
    require_once($custom_shc_path);

?>