<?php
/**
 * Custom Shortcodes for Ammon Template
 *
 * @package		Joomla
 * @subpackage	Shortcodes
 * @version 	1.3
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


if(!function_exists('hg_mtitle')):
//MTITLE
function hg_mtitle($atts, $content = null) {
    //[mtitle class="" style="" textalign="" heading=""][/mtitle]
    extract(shortcode_atts(array(
        "class" => '',
        "style" => '',
        "heading" => 'h4',
        "textalign" => 'left'
     ), $atts));

    $style = 'style="text-align:'.$textalign.'; '.$style.';"';

    $html = '<'.$heading.' class="m_title '.$class.'" '.$style.'>';
    $html .= do_shortcode(strip_tags($content));
    $html .= '</'.$heading.'>';
    return $html;
}
add_shortcode('mtitle', 'hg_mtitle');
endif;

/*
* ------------------------------------------------- *
*		Accordions
* ------------------------------------------------- *
*/
if(!function_exists('hg_shortcode_accordion')):
function hg_shortcode_accordion( $atts, $content = null ) {
    //[accordion style="1" or style="2" width=""][/accordion]
	extract(shortcode_atts(array(
        "style" => '',
        "width" => ''
     ), $atts));

	if($width) { $width = 'width:'.$width.'px'; }

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content));

    return '<div class="accordion-style-'.$style.'" style="'.$width.'">'.$content.'</div>';
}
add_shortcode('accordion', 'hg_shortcode_accordion');
endif;
//---------------------------------------------------

if(!function_exists('hg_shortcode_toggle')):
function hg_shortcode_toggle( $atts, $content = null ) {
    //[toggle style="1" or style="2" width=""][/toggle]
		extract(shortcode_atts(array(
        "style" => '',
        "width" => ''
     ), $atts));

	if($width) { $width = 'width:'.$width.'px'; }

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content));

    return '<div class="toggle-style-'.$style.'" style="'.$width.'">'.$content.'</div>';
}
add_shortcode('toggle', 'hg_shortcode_toggle');
endif;
//---------------------------------------------------


if(!function_exists('hg_shortcode_accordion_panel')):
function hg_shortcode_accordion_panel( $atts, $content = null ) {
	//[acc_pane title=""][/acc_pane]
    extract(shortcode_atts(array(
        "title" => ''
     ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content));

    return '<div class="acc_wrapper"><a href="#" class="acc_trigger"><span>'.$title.'</span></a><div class="acc_container">' . $content . '<div class="clear"></div></div></div>';
}

add_shortcode('acc_pane', 'hg_shortcode_accordion_panel');
endif;
//---------------------------------------------------

if(!function_exists('hg_shortcode_toggle_panel')):
function hg_shortcode_toggle_panel( $atts, $content = null ) {
	//[tgg_pane title=""][/tgg_pane]

    extract(shortcode_atts(array(
        "title" => ''
     ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content));

    return '<div class="tgg_wrapper"><a href="#" class="tgg-trigger"><span>'.$title.'</span></a><div class="toggle_container">' . $content . '<div class="clear"></div></div></div>';
}
add_shortcode('tgg_pane', 'hg_shortcode_toggle_panel');
endif;
//---------------------------------------------------


if(!function_exists('hg_video_button')):
function hg_video_button( $atts, $content = null ) {
    //[video_button type="" video_id="" width="" height="" label=""]
    extract(shortcode_atts(array(
        "type" => '',
        "video_id" => '',
        "width" => '80%',
        "height" => '80%',
        "label" => ''
    ), $atts));

    if($type == 'youtube') $href = 'http://www.youtube.com/embed/'.$video_id;
    elseif($type == 'vimeo') $href = 'http://vimeo.com/'.$video_id;

    $html = '<div class="video_trigger_container">';
    $html .= '<a class="playVideo" data-rel="prettyPhoto" href="'.$href.'?iframe=true&amp;width='.$width.'&amp;height='.$height.'"></a>';
    $html .= $label;
    $html .= '</div>';

    return $html;
}
add_shortcode('video_button', 'hg_video_button');
endif;
//---------------------------------------------------

if(!function_exists('hg_sidegallery')):
function hg_sidegallery($atts, $content = null ) {
    //[sidegallery align="right" thumbwidth="" thumbheight="" style="" class=""] .. [/sidegallery]

    $GLOBALS['thumb_count'] = 0;

    //fix shortcode
    $content = wpautop(do_shortcode($content));



    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    extract(shortcode_atts(array(
        "align" => 'right',
        "thumbwidth" => '',
        "thumbheight" => '',
        "style" => '',
        "class" => ''
    ), $atts));

    if( is_array( $GLOBALS['thumb'] ) ){
        foreach( $GLOBALS['thumb'] as $t => $thumb ){
            $the_thumb = JURI::base(true).'/cache/'.HgShortcodesHelper::createThumb($thumb['src'], $thumbwidth, $thumbheight,1);
            $thumbs[] = '<li><a href="'.$thumb['href'].'" '.($thumb['class'] ? 'class="'.$thumb['class'].'"':'').' '.($thumb['style'] ? 'style="'.$thumb['style'].'"':'').' data-rel="prettyPhoto"><img src="'.$the_thumb.'" class="shadow" /></a></li>';
        }
        $return = '<ul class="sidegallery '.$class.'" style="float:'.$align.'; '.$style.'" >'."\n".implode( "\n", $thumbs ).'</ul>'."\n";

    }
    return $return;

}
add_shortcode('sidegallery', 'hg_sidegallery');
endif;
//---------------------------------------------------

if(!function_exists('hg_thumb_link')):
function hg_thumb_link($atts, $content = null ) {
    //[thumb_link type="" width="" height="" src="" class="" style="" url=""]
    // type = thumb // gallery

    extract(shortcode_atts(array(
        "width" => '100',
        "height" => '75',
        "src" => '',
        "style" => '',
        "class" => '',
        "url" => '',
        "type" => 'thumb'
    ), $atts));

    $href = $url ? $url : $src;
    if($type=='gallery'){
        $x = $GLOBALS['thumb_count'];
        $GLOBALS['thumb'][$x] = array( 'href' => $href, 'src' => $src, 'style' => $style, 'class' => $class );
        $GLOBALS['thumb_count']++;
    } else {
        $thumb = JURI::base(true).'/cache/'.HgShortcodesHelper::createThumb($src, $width, $height);
        return '<a href="'.$href.'" '.($class ? 'class="'.$class.'"':'').' '.($style ? 'style="'.$style.'"':'').' data-rel="prettyPhoto"><img src="'.$thumb.'" class="shadow" /></a>';
    }
}
add_shortcode('thumb_link', 'hg_thumb_link');
endif;
//---------------------------------------------------


if(!function_exists('hg_icon')):
function hg_icon($atts, $content = null ) {
    //[icon src="" theme=""]
    extract(shortcode_atts(array(
        "src" => 'heart',
        "theme" => 'white'
    ), $atts));
    return '<span class="icon-'.$src.' icon-'.$theme.'"></span>';
}
add_shortcode('icon', 'hg_icon');
endif;
//---------------------------------------------------

if(!function_exists('hg_small')):
function hg_small($atts, $content = null ) {
    //[small][/small]
    return '<small>'.$content.'</small>';
}
add_shortcode('small', 'hg_small');
endif;
//---------------------------------------------------

if(!function_exists('hg_or')):
function hg_or( $atts, $content = null ) {
    //[or width="" height="" text=""]
    extract(shortcode_atts(array(
        "width" => '70',
        "height" => '25',
        "text" => 'or'
    ), $atts));

    return '<span class="or" style="width:'.$width.'px; height:'.$height.'px;">'.$text.'</span>';
}
add_shortcode('or', 'hg_or');
endif;
//---------------------------------------------------


if(!function_exists('hg_huge_title')):
function hg_huge_title($atts, $content = null ) {
//[huge_title fontsize="" color="" class=""] CONTENT HERE [/huge_title]

    extract(shortcode_atts(array(
        "fontsize" => '36',
        "color" => '#595959',
        "class" => ''
    ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    return '<h2 class="'.$class.' hugetitle" style="font-size:'.$fontsize.'px; color:'.$color.'; ">'.$content.'</h2>';
}
add_shortcode('huge_title', 'hg_huge_title');
endif;
//---------------------------------------------------

if(!function_exists('hg_quicksteps')):
function hg_quicksteps( $atts, $content = null ) {
    //[quicksteps style=""]
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));
    return '<div class="'.$atts['style'].' fixclear">'.$content.'</div>';
}
add_shortcode('quicksteps', 'hg_quicksteps');
endif;
//---------------------------------------------------

if(!function_exists('hg_quickstep')):
function hg_quickstep( $atts, $content = null ) {
    //[quickstep number="" color=""]  [/quickstep]
    extract(shortcode_atts(array(
        "color" => '',
        "number" => ''
    ), $atts));
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    return '<div><span class="number" style="background:'.$color.'">'.$number.'</span>'.$content.'</div>';
}
add_shortcode('quickstep', 'hg_quickstep');
endif;
//---------------------------------------------------


if(!function_exists('hg_infotext')):
function hg_infotext( $atts, $content = null ) {
    // [infotext title="" style=""] ... [/infotext]
    extract(shortcode_atts(array(
        "style" => '',
        "title" => ''
    ), $atts));
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));
    $html = '<h3 class="m_title" style="'.$style.'">'.$title.'</h3>';
    if($content) $html .= '<p>'.$content.'</p>';

    return $html;
}
add_shortcode('infotext', 'hg_infotext');
endif;
//---------------------------------------------------

if(!function_exists('hg_circlebutton')):
function hg_circlebutton( $atts, $content = null ) {
    // [circlebutton text="" link="" target="" size="" arrow_position="" align="" symbol=""]
    // size - small / medium / empty for normal
    // arrow_position - top-left / top-right / bottm-left / bottom-right / top / right / bottom / left
    // align - left / right (where to float the element)
    // symbol (path to symbol)
    // target - _self / _blank

    extract(shortcode_atts(array(
        "text" => 'TEXT HERE',
        "size" => '',
        "arrow_position" => 'top-left',
        "align" => 'right',
        "symbol" => '',
        "link" => '#',
        "target" => '_self'
    ), $atts));

    $html = '
    <a href="'.$link.'" target="'.$target.'" class="circlehover '.($symbol ? 'with-symbol':'').'" data-size="'.$size.'" data-position="'.$arrow_position.'" data-align="'.$align.'">
        <span class="text">'.$text.'</span>
        '.($symbol ? '<span class="symbol"><img src="'.$symbol.'" alt=""></span>':'').'
    </a>';

    return $html;
}
add_shortcode('circlebutton', 'hg_circlebutton');
endif;
//---------------------------------------------------


if(!function_exists('hg_acc')):
function hg_acc( $atts, $content = null ) {
    // [acc title="" style="" start_opened="" tweaked=""] ... [/acc]
    extract(shortcode_atts(array(
        "title" => 'Title here',
        "style" => 'default-style',
        "start_opened" => 'no',
        "tweaked" => 'no'
    ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));
    $random = mt_rand();
    $html = '
    <div class="acc-group '.$style.' '.($tweaked == 'yes' ? 'tweaked':'').'">
        <button data-toggle="collapse" data-target="#acc'.$random.'" class="'.($start_opened == 'yes' ? '':'collapsed').' '.($style == 'style2' ? 'btn-link':'').'">'.$title.'</button>
        <div id="acc'.$random.'" class="collapse '.($start_opened == 'yes' ? 'out':'in').'">
            <div class="content">
                '.$content.'
            </div><!-- end content -->
        </div>
    </div><!-- end acc group -->
    ';

    return $html;
}
add_shortcode('acc', 'hg_acc');
endif;
//---------------------------------------------------




if(!function_exists('hg_process_box')):
function hg_process_box( $atts, $content = null ) {
    // [process_box no="" arrow="" last="yes"] ...[/process_box]
    extract(shortcode_atts(array(
        "no" => '01',
        "arrow" => 'left',
        "last" => ''
    ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $html = '
<div class="process_box '.($last == 'yes' ? 'last':'').'" data-align="'.$arrow.'">
    <div class="number"><span>'.$no.'</span></div>
    <div class="content">'.$content.'</div>
    <div class="clear"></div>
</div><!-- end process box -->
    ';

    return $html;
}
add_shortcode('process_box', 'hg_process_box');
endif;
//---------------------------------------------------


if(!function_exists('hg_keywordbox')):
function hg_keywordbox( $atts, $content = null ) {
    // [keywordbox] ... [/keywordbox]

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    return '<div class="keywordbox">'.$content.'</div>';
}
add_shortcode('keywordbox', 'hg_keywordbox');
endif;
//---------------------------------------------------


if(!function_exists('hg_map_link')):
function hg_map_link( $atts, $content = null ) {
    // [map_link href="" title=""]
    extract(shortcode_atts(array(
        "href" => '',
        "title" => ''
    ), $atts));
    return '<a href="'.trim($href).'" target="_blank" class="map-link"><span class="icon-map-marker icon-white"></span> '.$title.'</a>';
}
add_shortcode('map_link', 'hg_map_link');
endif;
//---------------------------------------------------


if(!function_exists('hg_gobox')):
function hg_gobox( $atts, $content = null ) {
    // [gobox featured=""] ... [/gobox]

    extract(shortcode_atts(array(
        "featured" => ''
    ), $atts));
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));

    $html = '
    <div class="gobox '.($featured == 'yes' ? 'ok': '' ).'">'.$content.'</div>
    ';

    return $html;
}
add_shortcode('gobox', 'hg_gobox');
endif;
//---------------------------------------------------

if(!function_exists('hg_features')):
function hg_features( $atts, $content = null ) {
    // [features class=""] ... [/features]
	extract(shortcode_atts(array(
        "class" => ''
    ), $atts));
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

    return '<ul class="features '.$class.'">'.$content.'</ul>';;
}
add_shortcode('features', 'hg_features');
endif;
//---------------------------------------------------

if(!function_exists('hg_feature')):
function hg_feature( $atts, $content = null ) {
    // [feature class="" title=""] ... [/feature]
 	extract(shortcode_atts(array(
        "class" => '',
        "title" => ''
    ), $atts));
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

    return '<li class="'.$class.'"><h4>'.$title.'</h4><span>'.$content.'</span></li>';;
}
add_shortcode('feature', 'hg_feature');
endif;
//---------------------------------------------------


if(!function_exists('hg_hoverbox')):
function hg_hoverbox( $atts, $content = null ) {
    // [hoverbox hover="" centered="" link="" target=""] ... [/hoverbox]

    extract(shortcode_atts(array(
        "hover" => '#cd2122',
        "centered" => 'no',
        "link" => '#',
        "target" => '_self'
    ), $atts));

    $random = mt_rand();
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    $html = '<a href="'.$link.'" target="'.$target.'" class="hover-box '.($centered == 'yes'?'centered':'').' fixclear" id="hoverbox'.$random.'">'.$content.'</a>';

    if($hover) JFactory::getDocument()->addStyleDeclaration('#hoverbox'.$random.':hover {background:'.$hover.';} ');

    return $html;
}
add_shortcode('hoverbox', 'hg_hoverbox');
endif;
//---------------------------------------------------


if(!function_exists('hg_icontitle')):
function hg_icontitle( $atts, $content = null ) {
    // [icontitle icon="" title=""]
 	extract(shortcode_atts(array(
        "icon" => '',
        "title" => ''
    ), $atts));
    return '<h3 class="mb_title">'.($icon ? '<img src="'.$icon.'" alt="">':'').' '.$title.'</h3>';
}
add_shortcode('icontitle', 'hg_icontitle');
endif;
//---------------------------------------------------

if(!function_exists('hg_statbox')):
function hg_statbox( $atts, $content = null ) {
    // [statbox icon="" title="" number=""]
    extract(shortcode_atts(array(
        "icon" => '',
        "title" => 'Title here',
        "number" => '000'
    ), $atts));

    return '<div class="statbox">
        '.($icon ? '<img src="'.$icon.'" alt="">':'').'
        <h4>'.$number.'</h4>
        <h6>'.$title.'</h6>
    </div>';
}
add_shortcode('statbox', 'hg_statbox');
endif;
//---------------------------------------------------


if(!function_exists('hg_baloonbox')):
function hg_baloonbox( $atts, $content = null ) {
    // [baloonbox fontsize=""] ... [/baloonbox]
    extract(shortcode_atts(array(
        "fontsize" => 28,
        "background" => '#767676'
    ), $atts));
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    return '<div class="info-text" style="font-size:'.$fontsize.'px; background:'.$background.'">'.$content.'</div>';
}
add_shortcode('baloonbox', 'hg_baloonbox');
endif;
//---------------------------------------------------


if(!function_exists('hg_revslide')):
function hg_revslide( $atts, $content = null ) {
    // [revslide transition="" bg=""] ... [/revslide]
    // boxslide / boxfade / slotzoom-horizontal / slotslide-horizontal / slotfade-horizontal / slotzoom-vertical / slotslide-vertical / slotfade-vertical / curtain-1 / curtain-2 / curtain-3 / slideleft / slideright / slideup / slidedown / fade / random / slidehorizontal / slidevertical / papercut / flyin / cube / 3dcurtain-vertical / 3dcurtain-horizontal

    extract(shortcode_atts(array(
        "transition" => 'fade',
        "bg" => ''
    ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));
    $html = array();
    $html[] = '<li data-transition="'.$transition.'">'."";
    if($bg) $html[] = '<img src="'.$bg.'" alt="">';
    $html[] = $content;
    $html[] = '</li>';

    return implode("\n",$html);
}
add_shortcode('revslide', 'hg_revslide');
endif;


if(!function_exists('hg_revobject')):
function hg_revobject( $atts, $content = null ) {
    // [revobject type="" image="" url="" target="" effect="" x="" y="" speed="" start="" easing="" class="" parallax=""] ... [/revobject]
    // type - text, image
    // url
    // target
    // effect - sft - Short from Top /// sfb - Short from Bottom /// sfr - Short from Right /// sfl - Short from Left /// lft - Long from Top /// lfb - Long from Bottom /// lfr - Long from Right /// lfl - Long from Left /// fade - fading /// randomrotate- Fade in, Rotate from a Random position and Degree
    // x
    // y
    // speed
    // start
    // easing
    // class
    // parallax
    //=> content - path of the image or content that is displayed

    extract(shortcode_atts(array(
        "type" => '',
        "url" => '',
        "image" => '',
        "target" => '_self',
        "effect" => 'fade',
        "x" => 0,
        "y" => 0,
        "speed" => 600,
        "start" => 700,
        "easing" => 'easeOutExpo',
        "text" => '',
        "class" => '',
        "parallax" => ''
    ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content));

    $html = array();

    $html[] = '<div class="caption '.$effect.' '.$class.' '.($parallax ? 'para'.$parallax : '').'" data-x="'.$x.'" data-y="'.$y.'" data-speed="'.$speed.'" data-start="'.$start.'" data-easing="'.$easing.'">';

    if($url) $html[] = '<a href="'.$url.'" target="'.$target.'">';

    if($type == "image")
        $html[] = '<img src="'.$image.'" alt="">';
    elseif($type == "text")
        $html[] = $text;

    if($url) $html[] = '</a>';

    $html[] = '</div>';

    return implode("\n",$html);
}
add_shortcode('revobject', 'hg_revobject');
endif;



if(!function_exists('hg_tooltip')):
function hg_tooltip( $atts, $content = null ) {
    // [tooltip position="" animated="" class="" text=""] ... [/tooltip]
    // position = top / left / right / bottom
    // animated = true / false

    extract(shortcode_atts(array(
        "animated" => 'true',
        "position" => 'top',
        "class" => '',
        "text" => ''
    ), $atts));

    //fix shortcode
    $content = fixshortcode($content);

    $html = '<span class="'.$class.'" data-rel="tooltip" data-placement="'.$position.'" title="'.$text.'" data-animation="'.$animated.'">'.$content.'</span>';

    return $html;
}
add_shortcode('tooltip', 'hg_tooltip');
endif;
//---------------------------------------------------


/*
* ------------------------------------------------- *
*       STATIC CONTENT SHORTCODES
* ------------------------------------------------- *
*/

if(!function_exists('hg_animated_box')):
function hg_animated_box( $atts, $content = null ) {
    // [animated_box arrow_position="" align="" effect="" url="" target="" url_label=""] ... [/animated_box]
    // arrow_position // top / left / right / bottom
    // align // center / left / right
    // effect // fadeBoxIn / none

    extract(shortcode_atts(array(
        "arrow_position" => 'top',
        "align" => 'center',
        "effect" => 'fadeBoxIn',
        "url" => '',
        "target" => '_self',
        "url_label" => 'Some text'
    ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    $html = '<div class="info_pop '.($effect != 'none' ? 'animated '.$effect : '').' '.$align.'" data-arrow="'.$arrow_position.'">';
    if($url)
    $html .= '  <a href="'.$url.'" class="buyit" target="'.$target.'">'.$url_label.'</a>';
    $html .= '  <h5 class="text">'.$content.'</h5>';
    $html .= '  <div class="clear"></div>';
    $html .= '</div>';

    return $html;
}
add_shortcode('animated_box', 'hg_animated_box');
endif;
//---------------------------------------------------


if(!function_exists('hg_textpop_line')):
function hg_textpop_line( $atts, $content = null ) {
    // [textpop_line font_size="" letter_spacing="" word_spacing="" font_weight="" style=""] ... [/textpop_line]

    extract(shortcode_atts(array(
        "font_size" => '20',
        "letter_spacing" => '0',
        "word_spacing" => '0',
        "font_weight" => 'normal',
        "style" => ''
    ), $atts));

    //fix shortcode
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    $html = '<span class="textpop_line" style="font-size:'.$font_size.'px; letter-spacing: '.$letter_spacing.'px; word-spacing: '.$word_spacing.'px; font-weight:'.$font_weight.'; '.$style.'">'.$content.'</span>';

    return $html;
}
add_shortcode('textpop_line', 'hg_textpop_line');
endif;
//---------------------------------------------------



if(!function_exists('hg_countdown')):
function hg_countdown( $atts, $content = null ) {
    // [countdown day="" month="" year=""]

    extract(shortcode_atts(array(
        "day" => '1',
        "month" => '1',
        "year" => '2013'
    ), $atts));

    $asset_path = JURI::base(true).'/templates/'.JFactory::getApplication()->getTemplate().'/addons/countdown';
    $html = array();
    $html[] = '
<div class="ud_counter">
    <ul id="Counter">
        <li>0<span>day</span></li>
        <li>00<span>hours</span></li>
        <li>00<span>min</span></li>
        <li>00<span>sec</span></li>
    </ul>
</div><!-- end counter -->';

    $js = '
    jQuery(document).ready(function(){
    var counter = {
            init: function (d) {
                jQuery("#Counter").countdown({
                    until: new Date(d),
                    layout: counter.layout(),
                    labels: ["years", "months", "weeks", "days", "hours", "min", "sec"],
                    labels1: ["year", "month", "week", "day", "hour", "nin", "sec"]
                });'."\n";
    $js .= "},
            layout: function () {
                return '<li>{dn}<span>{dl}</span></li>' +
                            '<li>{hnn}<span>{hl}</span></li>' +
                            '<li>{mnn}<span>{ml}</span></li>' +
                            '<li>{snn}<span>{sl}</span></li>' +
                            '<li class=\"till_lauch\"><img src=\"".$asset_path."/rocket.png\"></li>';
            }
        }"."\n";
    $js .= 'counter.init("'.date("F", mktime(0, 0, 0, $month)).' '.date("d", mktime(0, 0, 0, 0, $day)).', '.$year.'");
    });
    ';


    JFactory::getDocument()->addScript($asset_path.'/jquery.countdown.js');
    JFactory::getDocument()->addScriptDeclaration($js);

    return implode("\n",$html);
}
add_shortcode('countdown', 'hg_countdown');
endif;
//---------------------------------------------------


/* Social Icons shortcode*/
if(!function_exists('hg_socialicons')):
function hg_socialicons( $atts, $content = null ) {
    // [socialicons class="" type="" style="" ][/socialicons]
    // type = normal / colored

    extract(shortcode_atts(array(
        "class" => '',
        "type" => 'normal',
        "style" => ''
    ), $atts));

    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $content = preg_replace('#<ul>#', '', trim($content));
    $content = preg_replace('#<\/ul>#', '', trim($content));
    $content = preg_replace('#<li>#', "",trim($content));
    $content = preg_replace('#<\/li>#', "",trim($content));

    return '<ul class="social-icons '.$type.' '.$class.'" '.(($style != '') ? 'style="'.$style.'"' : '').'>'.$content.'</ul>';
}
add_shortcode('socialicons', 'hg_socialicons');
endif;

/* Social Icon */
if(!function_exists('hg_socialicon')):
function hg_socialicon( $atts, $content = null ) {
    // [socialicon network="" url="#"]

    extract(shortcode_atts(array(
        "network" => 'twitter',
        "url" => '#'
    ), $atts));

    return '<li class="social-'.$network.'"><a href="'.$url.'" target="_blank">'.$network.'</a></li>';
}
add_shortcode('socialicon', 'hg_socialicon');
endif;


if(!function_exists('hg_line')):
function hg_line( $atts, $content = null ) {
    // [line]
    return '<span class="line"></span>';
}
add_shortcode('line', 'hg_line');
endif;
//---------------------------------------------------

if(!function_exists('hg_testimonial')):
function hg_testimonial( $atts, $content = null ) {
    // [testimonial name="" position="" style=""][/testimonial]
    extract(shortcode_atts(array(
        "style" => '',
        "name" => '',
        "position" => ''
    ), $atts));
    //fix shortcode
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));
    $html = '';
    if($style==2) {
    $html .= '<div class="testimonial_box4">';
    $html .= '<blockquote>'.$content.'</blockquote>';
    $html .= '<h5>'.$name.' '.($position ? ' // '.$position:'').'</h5>';
    $html .= '</div>';
    } else {
    $html .= '<blockquote>';
    $html .= '<p>'.$content.'</p>';
    $html .= '<small>'.$name.' '.($position ? '- <cite>'.$position.'</cite>':'').'</small>';
    $html .= '</blockquote>';
    }
    return $html;
}
add_shortcode('testimonial', 'hg_testimonial');
endif;
//---------------------------------------------------



if(!function_exists('hg_timeline')):
function hg_timeline( $atts, $content = null ) {
    // [timeline] .. [/timeline]
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);
    $html = array();
    $html[] = '<div class="row">';
    $html[] = '  <div class="span12 timeline_bar">';
    $html[] = '    <div class="row">'.$content.'</div>';
    $html[] = '  </div>';
    $html[] = '</div>';

    return implode("\n",$html);
}
add_shortcode('timeline', 'hg_timeline');
endif;
//---------------------------------------------------


if(!function_exists('hg_timeline_box')):
function hg_timeline_box( $atts, $content = null ) {
    // [timeline_box year="" align="" title=""] ... [/timeline_box]
    //fix shortcode

    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content));

    extract(shortcode_atts(array(
        "year" => '',
        "align" => 'left',
        "title" => ''
    ), $atts));
    $edge = ($align == 'top' || $align == 'bottom') ? true : false;
    $html = array();
    $html[] = '<div class="span'.($edge ? '12 end_timeline':'6').' '.($align == 'right' ? 'offset6" data-align="right"':'"').'>';
    if($edge) {
        $html[] = '  <span>'.$year.($year ? ' &rsaquo; ':'').$title.'</span>';
    } else {
        $html[] = '  <div class="timeline_box">';
        $html[] = '    <div class="date">'.$year.'</div>';
        $html[] = '    <h4 class="htitle">'.$title.'</h4>';
        $html[] = '    <p>'.$content.'</p>';
        $html[] = '  </div>';
    }
    $html[] = '</div>';

    return implode("\n",$html);
}
add_shortcode('timeline_box', 'hg_timeline_box');
endif;
//---------------------------------------------------


if(!function_exists('hg_error')):
function hg_error( $atts, $content = null ) {
    // [error code=""]...[/error]
    //fix shortcode
    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

 	extract(shortcode_atts(array(
        "code" => ''
    ), $atts));

    $html = array();
    $html[] = '<div class="row">';
    $html[] = '  <div class="span12">';
    $html[] = '    <div class="error404">';
    $html[] = '    <h2><span>'.$code.'</span></h2>';
    $html[] = '    <h3>'.$content.'</h3>';
    $html[] = '    </div>';
    $html[] = '  </div>';
    $html[] = '</div>';

    return implode("\n",$html);
}
add_shortcode('error', 'hg_error');
endif;
//---------------------------------------------------


if(!function_exists('hg_alert')):
function hg_alert( $atts, $content = null ) {
    // [alert type=""]...[/alert]
    // info, success, danger, error

    $content = wpautop(do_shortcode($content));
    $content = fixshortcode($content);

    extract(shortcode_atts(array(
        "type" => 'info'
    ), $atts));
    return '<div class="alert alert-'.$type.'">'.$content.'</div>';
}
add_shortcode('alert', 'hg_alert');
endif;
//---------------------------------------------------

if(!function_exists('hg_prettyprint_script')):
function hg_prettyprint_script( $atts, $content = null ) {
    // [prettyprint_script]
    $tpath = JURI::base(true).'/templates/'.JFactory::getApplication()->getTemplate();
    $doc = JFactory::getDocument();
    $doc->addStyleSheet($tpath.'/addons/prettify-code/prettify.css');
    $doc->addScript($tpath.'/addons/prettify-code/prettify.js');
    $doc->addScriptDeclaration(' jQuery(window).load(function(){ prettyPrint(); });  ');
}
add_shortcode('prettyprint_script', 'hg_prettyprint_script');
endif;
//---------------------------------------------------


if(!function_exists('hg_loadstyle')):
function hg_loadstyle( $atts, $content = null ) {
    // [loadstyle styles=""]
    extract(shortcode_atts(array(
        "styles" => ''
    ), $atts));
    $doc = JFactory::getDocument();
    $doc->addStyleDeclaration($styles);
}
add_shortcode('loadstyle', 'hg_loadstyle');
endif;
//---------------------------------------------------


?>