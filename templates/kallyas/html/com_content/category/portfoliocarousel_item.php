<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
$images = json_decode($this->item->images);
$canEdit	= $this->item->params->get('access-edit');
$cache_folder = JURI::base(true).'/cache/hgimages/';
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
//JHtml::core();

require_once dirname(__FILE__).'/../../..'.'/lib/image_helper.php';

$template_path = JURI::base(true).'/templates/'.JFactory::getApplication()->getTemplate();

$ptparams = new JRegistry($this->item->attribs);
// $thumbw = $ptparams->get('pt_others_w',570);
// $thumbh = $ptparams->get('pt_others_h',360);
$thumbw = 570;
$thumbh = 360;
$pt_image = $ptparams->get('pt_image');
$pt_other = $ptparams->get('pt_images');
$scale_mode = 3;

if($pt_image) $pt_image = hgImageHelper::createThumb($pt_image, $thumbw, $thumbh, $scale_mode);

$url_type = $ptparams->get('pt_urltype');
$rel = '';
$target = '';

$doc = JFactory::getDocument();
$css = '.rhinoslider {width:'.$thumbw.'px; height:'.$thumbh.'px;}';
$doc->addStyleDeclaration($css);

if ($params->get('access-view')) :
	$itemlink = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
else :
	$menu = JFactory::getApplication()->getMenu();
	$active = $menu->getActive();
	$itemId = $active->id;
	$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
	$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
	$itemlink = new JURI($link1);
	$itemlink->setVar('return', base64_encode($returnURL));
endif;

if ($url_type != 5) :
	// if 0 - Portfolio item page
	if($url_type == 0){
		$link = $itemlink;
	}// if 0 (normal link)
	else if($url_type == 1){
		$link = ($ptparams->get('pt_image_full')) ? $ptparams->get('pt_image_full') : $cache_folder.$pt_image;
		$rel = 'data-rel="prettyPhoto"';
	}//if 1 (lightbox image)
	else if($url_type == 2){
		$link = 'http://www.youtube.com/watch?v='.$ptparams->get('pt_videoid');
		$rel = 'data-rel="prettyPhoto"';
	}//if 2 (youtube)
	else if($url_type == 3){
		$link = 'http://www.vimeo.com/'.$ptparams->get('pt_videoid');
		$rel = 'data-rel="prettyPhoto"';
	}//if 3 (vimeo)
	else if($url_type == 4){
		$link = $ptparams->get('pt_url');
		$target = 'target="_blank"';
	}//if 4 (external)
endif;

?>

<?php if ($this->item->state == 0) : ?>
<div class="system-unpublished">
<?php endif; ?>

<div class="inner-item">

<div class="span6">
<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $this->item->event->beforeDisplayContent; ?>

<div class="ptcontent">
	<?php if ($params->get('show_title')) : ?>
        <h3 class="title">
            <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>

                <a href="<?php echo $itemlink; ?>"><?php echo $this->escape($this->item->title); ?></a>

            <?php else : ?>
                <?php echo $this->escape($this->item->title); ?>
            <?php endif; ?>
        </h3>
    <?php endif; ?>

    <div class="pt-cat-desc">
        <?php echo $this->item->introtext; ?>
    </div>
    <div class="itemLinks">
        <?php
		$pt_livepreview = $ptparams->get('pt_livepreview');
		if($pt_livepreview) echo '<span><a href="'.$pt_livepreview.'" target="_blank" >'.JText::_('TPL_KALLYAS_PORTFOLIO_CAROUSEL_LIVE_PREVIEW').' '.str_replace('http:','',str_replace('/','',$pt_livepreview)).'</a></span>'; ?>
        <span class="seemore"><a href="<?php echo $itemlink; ?>" ><?php echo JText::_('TPL_KALLYAS_PORTFOLIO_CAROUSEL_SEE_MORE') ;?></a></span>
    </div>
</div><!-- end ptcontent -->
</div>
<div class="span6">
	<div class="ptcarousel">
		<div class="controls">
			<a href="#" class="prev"><span class="icon-chevron-left icon-white"></span></a>
			<a href="#" class="next"><span class="icon-chevron-right icon-white"></span></a>
		</div>
		<ul id="ptcarousel<?php echo $this->item->id ?>" class="">

		<li>
		<?php if ($params->get('access-view') && $url_type != 5) { ?>
			<a href="<?php echo $link; ?>" <?php echo $rel; ?> <?php echo $target; ?>>

			<?php } ?>
				<img src="<?php echo $cache_folder.$pt_image; ?>" alt="<?php echo $this->escape($this->item->title); ?>"/>
			<?php if ($params->get('access-view') && $url_type != 5) { ?>
			</a>
		<?php } ?>
		</li>

<?php
if(!empty($pt_other)):
foreach($pt_other->vals as $k => $v):

	$img = $pt_other->img[$k];
	$media = $pt_other->media[$k];

	if($img || $media) {
		$ot_image = 'http://placehold.it/570x360&text=No+Image';
		$ot_link = '#';
		$ot_lightbox = 'image';
		echo '<li>';
		if($img) {
			$ot_image = $cache_folder.hgImageHelper::createThumb($img, $thumbw, $thumbh, $scale_mode);
			$ot_link = $img;
			$ot_lightbox = 'image';
		} else if($media) {
			if(is_numeric($media)) {
				$ot_image = 'http://i.vimeocdn.com/video/'.$media.'_'.$thumbw.'x'.$thumbh.'.jpg';
				$ot_link = 'http://vimeo.com/'.$media;
			} else {
				$ot_image = 'http://img.youtube.com/vi/'.$media.'/0.jpg';
				$ot_link = 'http://youtube.com/watch?v='.$media;
			}
			$ot_lightbox = 'iframe';
		}
		echo '
		<a href="'.$ot_link.'" rel="prettyPhoto"" >
			<img src="'.$ot_image.'" alt="'.$this->escape($this->item->title).'" class="img-responsive" width="'.$thumbw.'" height="'.$thumbh.'" />
		</a>';

		echo '</li>';
	}
endforeach;
endif;
?>
		</ul>
	</div><!-- end ptcarousel -->
</div>
<div class="clear"></div>

</div>

<?php if ($this->item->state == 0) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>
