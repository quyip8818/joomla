<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
require_once dirname(__FILE__).'/../../..'.'/lib/icon_helper.php';
require_once dirname(__FILE__).'/../../..'.'/lib/image_helper.php';

// Create shortcuts to some parameters.
$params		= $this->item->params;
$images = json_decode($this->item->images);
$urls = json_decode($this->item->urls);
$canEdit	= $this->item->params->get('access-edit');
$cache_folder = JURI::base(true).'/cache/hgimages/';
$user		= JFactory::getUser();

$template_path = JURI::base(true).'/templates/'.JFactory::getApplication()->getTemplate();
$ptparams = new JRegistry($this->item->attribs);
$pt_image = $ptparams->get('pt_image');
$pt_image_width = 480; 	// carousel width
$scale_mode = 2; 	// scale mode

if($pt_image) $ptThumb = hgImageHelper::createThumb($pt_image, $pt_image_width, ($pt_image_width/1.33), $scale_mode);

$pt_other = $ptparams->get('pt_images');

?>
<div class="item-page hg-portfolio-item <?php echo $this->pageclass_sfx?>">
<?php /*?>
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1 class="title" >
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
<?php */?>
<?php
if (!empty($this->item->pagination) AND $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
{
 echo $this->item->pagination;
}
 ?>

<?php if ($params->get('show_title')) : ?>
	<h1 class="page-title">
	<?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
		<a href="<?php echo $this->item->readmore_link; ?>">
		<?php echo $this->escape($this->item->title); ?></a>
	<?php else : ?>
		<?php echo $this->escape($this->item->title); ?>
	<?php endif; ?>
	</h1>
<?php endif; ?>

<?php

 $useDefList = (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_parent_category'))
	or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date'))
	or ($params->get('show_hits'))); ?>

<?php if ($canEdit ||  $params->get('show_print_icon') || $params->get('show_email_icon') || $useDefList) : ?>
<div class="article-details">

<?php if ($canEdit ||  $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
	<ul class="actions clearfix">
	<?php if (!$this->print) : ?>
		<?php if ($params->get('show_print_icon')) : ?>
			<li class="print-icon">
			<?php echo JHtml::_('icon.print_popup',  $this->item, $params); ?>
			</li>
		<?php endif; ?>

		<?php if ($params->get('show_email_icon')) : ?>
			<li class="email-icon">
			<?php echo JHtml::_('icon.email',  $this->item, $params); ?>
			</li>
		<?php endif; ?>

		<?php if ($canEdit) : ?>
			<li class="edit-icon">
			<?php echo JHtml::_('icon.edit', $this->item, $params); ?>
			</li>
		<?php endif; ?>

	<?php else : ?>
		<li>
		<?php echo JHtml::_('icon.print_screen',  $this->item, $params); ?>
		</li>
	<?php endif; ?>

	</ul>
<?php endif; ?>

<?php  if (!$params->get('show_intro')) :
	echo $this->item->event->afterDisplayTitle;
endif; ?>

<?php echo $this->item->event->beforeDisplayContent; ?>

<?php if ($useDefList) : ?>
	<dl class="article-info clearfix">
	<?php /*?><dt class="article-info-term"><?php  echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?></dt><?php */?>
<?php endif; ?>
<?php if ($params->get('show_parent_category') && $this->item->parent_slug != '1:root') : ?>
	<dd class="parent-category-name">
	<?php	$title = $this->escape($this->item->parent_title);
	$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';?>
	<?php if ($params->get('link_parent_category') and $this->item->parent_slug) : ?>
		<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
	<?php else : ?>
		<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
	<?php endif; ?>
	</dd>
<?php endif; ?>
<?php if ($params->get('show_category')) : ?>
	<dd class="category-name">
	<?php 	$title = $this->escape($this->item->category_title);
	$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';?>
	<?php if ($params->get('link_category') and $this->item->catslug) : ?>
		<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
	<?php else : ?>
		<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
	<?php endif; ?>
	</dd>
<?php endif; ?>
<?php if ($params->get('show_create_date')) : ?>
	<dd class="create">
	<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC2'))); ?>
	</dd>
<?php endif; ?>
<?php if ($params->get('show_modify_date')) : ?>
	<dd class="modified">
	<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
	</dd>
<?php endif; ?>
<?php if ($params->get('show_publish_date')) : ?>
	<dd class="published">
	<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?>
	</dd>
<?php endif; ?>
<?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
	<dd class="createdby">
	<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author; ?>
	<?php if (!empty($this->item->contactid) && $params->get('link_author') == true): ?>
	<?php
		$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid;
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getItems('link', $needle, true);
		$cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;
	?>
		<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', JRoute::_($cntlink), $author)); ?>
	<?php else: ?>
		<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
	<?php endif; ?>
	</dd>
<?php endif; ?>
<?php if ($params->get('show_hits')) : ?>
	<dd class="hits">
	<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
	</dd>
<?php endif; ?>
<?php if ($useDefList) : ?>
	</dl>
<?php endif; ?>

</div>
<!-- end article details -->
<?php endif; ?>

<?php if (isset ($this->item->toc)) : ?>
	<?php echo $this->item->toc; ?>
<?php endif; ?>

<?php if (isset($urls) AND ((!empty($urls->urls_position) AND ($urls->urls_position=='0')) OR  ($params->get('urls_position')=='0' AND empty($urls->urls_position) ))
		OR (empty($urls->urls_position) AND (!$params->get('urls_position')))): ?>
	<?php echo $this->loadTemplate('links'); ?>
<?php endif; ?>

<?php if ($params->get('access-view')):?>

<?php  if (isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
<?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
<div class="img-fulltext-<?php echo htmlspecialchars($imgfloat); ?>">
<img
	<?php if ($images->image_fulltext_caption):
		echo 'class="caption"'.' title="' .htmlspecialchars($images->image_fulltext_caption) .'"';
	endif; ?>
	src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"/>
</div>
<?php endif; ?>

<?php
if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
	echo $this->item->pagination;
 endif;
?>
<?php
$full_align = $params->get('full_align', 'right');
$margin_full_align = ($full_align == 'left') ? 'right' : 'left';
?>

<div class="img-full" <?php echo 'style="float:'.$full_align.'; margin-'.$margin_full_align.':25px;"'; ?>>
	<a href="<?php echo $pt_image; ?>" rel="prettyPhoto" class="hoverBorder">
		<img src="<?php echo $cache_folder.$ptThumb; ?>" alt="<?php echo $this->escape($this->item->title); ?>" class="" />
	</a>
    <div class="clear"></div>

    <div class="itemLinks">
        <?php
		$pt_livepreview = $ptparams->get('pt_livepreview');
		$pt_collaborators = $ptparams->get('pt_collaborators');
		$pt_social = $ptparams->get('pt_social');
		if($pt_livepreview) echo '<p><a href="'.$pt_livepreview.'" target="_blank" >'.JText::_('TPL_KALLYAS_PORTFOLIO_CAROUSEL_LIVE_PREVIEW').' <strong>'.str_replace('http:','',str_replace('/','',$pt_livepreview)).'</strong></a></p>';
        if($pt_collaborators) echo '<p>'.JText::_('TPL_KALLYAS_PORTFOLIO_CAROUSEL_COLLABORATORS').' <strong>'.$pt_collaborators.'</strong></p>';
        ?>
    </div>

    <?php if($pt_social) { ?>
    <div class="itemSocialSharing clearfix">

		<!-- Twitter Button -->
		<div class="itemTwitterButton">
			<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
		</div>

		<!-- Facebook Button -->
		<div class="itemFacebookButton">
			<div id="fb-root"></div>
			<script type="text/javascript">
				(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) {return;}
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#appId=177111755694317&xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
			<div class="fb-like" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
		</div>

		<!-- Google +1 Button -->
		<div class="itemGooglePlusOneButton">
			<g:plusone size="medium"></g:plusone>
			<script type="text/javascript">
			  (function() {
			  	window.___gcfg = {lang: 'en'}; // Define button default language here
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		</div>

		<div class="clr"></div>
	</div>
    <?php } ?>
</div><!-- img-full -->

<div class="text">
	<?php echo $this->item->text; ?>
</div>
<div class="clear"></div>
<ul class="other-images clearfix" data-columns="<?php echo $ptparams->get('pt_others_cols',4) ?>">
<?php

$thumbw = $ptparams->get('pt_others_w',280);
$thumbh = $ptparams->get('pt_others_h',200);

foreach($pt_other->vals as $k => $v):

	$img = $pt_other->img[$k];
	$media = $pt_other->media[$k];

	if($img || $media) {
		$ot_image = 'http://placehold.it/280x195&text=No+Image';
		$ot_link = '#';
		$ot_lightbox = 'image';
		echo '<li>';
		if($img) {
			$ot_image = $cache_folder.hgImageHelper::createThumb($img, $thumbw, $thumbh, 5);
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
		<a href="'.$ot_link.'" data-mfp="'.$ot_lightbox.'" rel="prettyPhoto" class="hoverBorder" >
			<img src="'.$ot_image.'" alt="'.$this->escape($this->item->title).'" class="img-responsive" width="'.$thumbw.'" height="'.$thumbh.'" />
		</a>';

		echo '</li>';
	}
endforeach;
?>
</ul>

<?php
if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND!$this->item->paginationrelative):
	 echo $this->item->pagination;?>
<?php endif; ?>

<?php if (isset($urls) AND ((!empty($urls->urls_position)  AND ($urls->urls_position=='1')) OR ( $params->get('urls_position')=='1') )): ?>
<?php echo $this->loadTemplate('links'); ?>
<?php endif; ?>
	<?php //optional teaser intro text for guests ?>
<?php elseif ($params->get('show_noauth') == true and  $user->get('guest') ) : ?>
	<?php echo $this->item->introtext; ?>
	<?php //Optional link to let them register to see the whole article. ?>
	<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
		$link1 = JRoute::_('index.php?option=com_users&view=login');
		$link = new JURI($link1);?>
		<p class="readmore">
		<a href="<?php echo $link; ?>">
		<?php $attribs = json_decode($this->item->attribs);  ?>
		<?php
		if ($attribs->alternative_readmore == null) :
			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
		elseif ($readmore = $this->item->alternative_readmore) :
			echo $readmore;
			if ($params->get('show_readmore_title', 0) != 0) :
			    echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
			endif;
		elseif ($params->get('show_readmore_title', 0) == 0) :
			echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
		else :
			echo JText::_('COM_CONTENT_READ_MORE');
			echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
		endif; ?></a>
		</p>
	<?php endif; ?>
<?php endif; ?>
<?php
if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND $this->item->paginationrelative):
	 echo $this->item->pagination;?>
<?php
endif; ?>

<?php

echo $this->item->event->afterDisplayContent; ?>
</div>