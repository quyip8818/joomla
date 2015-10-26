<?php

if (!self::$videoHelpInit) {

	$document = JFactory::getDocument();

	$document->addScript(self::getPath().'js/jquery.easyModal.js');

	$output .= '
	<div id="video_help" class="modal_window">
		<h2>How to add source?</h2>
		<ol>
			<li>
				<h4>Self Hosted Videos</h4>
				<p>Because Media Manager cannot provide support for inserting videos through it\'s own interface, the easiest way is to upload the files through a <a href="http://extensions.joomla.org/extensions/core-enhancements/file-management" target="_blank">Joomla File Manager Extension</a> or by <a href="http://docs.joomla.org/Using_an_FTP_client_to_upload_files" target="_blank">FTP</a>, most commonly into the <em>/images/</em> folder or better, <em>/images/videos/</em>.</p>
				<p>To have a full browser support for videos you should add the video into the 3 most common support video types: <strong>.mp4 (Chrome), .ogg/.ogv (Firefox), .webm (Chrome, Safari, etc.)</strong>. So upload all 3 of them. <strong>Make sure the filenames of each is the same</strong> eg: <a href="http://screencast.com/t/iiibxypoyu" target="_blank">http://screencast.com/t/iiibxypoyu</a>.</p>
				<p>After properly uploading them, into the Source field, add the full path from your root, eg: <strong>images/some_videos/my_video</strong> <strong><em>without the extension</em></strong>. It will be added automatically.</p>
			</li>
			<li>
				<h4>Youtube Videos</h4>
				<p>For videos from Youtube, just copy the video code after ?v=..., eg: http://www.youtube.com/watch?v=<strong>G-1HNnxb0WE</strong> .</p>
			</li>
			<li>
				<h4>Vimeo Videos</h4>
				<p>For videos from Vimeo, just copy the video code after vimeo.com/..., eg: http://vimeo.com/<strong>37398997</strong> .</p>
			</li>
		</ol>
	</div>';
	self::$videoHelpInit = true;
}

$unique_id = uniqid('chkbox_');
$output .= '
<div class="fld clearfix videojs_fld">
	<h4 '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</h4>
	<input name="'.$name.'['.$option->name.'][enabled][]" class="en_stat" type="hidden" value="'
. ($values[$option->name]['enabled'] == 'enabled' ? 'enabled' : '') . '" />
	<label class="iostoggle '
. ($values[$option->name]['enabled'] == 'enabled' ? 'video-enabled' : '') . '"></label>
	<div class="clearfix"></div>
		<div class="video_options">
			<div class="inner-vo">
			<p>The image above these settings is becoming the poster image.</p>';
// Video Type
	$vt_data = array(
		array( 'value' => 'self_hosted', 'text' => 'Self Hosted'),
		array( 'value' => 'youtube', 'text' => 'YouTube Video'),
		array( 'value' => 'vimeo', 'text' => 'Vimeo Video'),
	);
	$vt_options = array( 'option.key'=>'value',	'option.text'=>'text', 'list.select'=>(isset($values[$option->name]['video_type']) ? $values[$option->name]['video_type'] : 'youtube') );
	$videotypelist = JHtmlSelect::genericlist($vt_data, $name.'['.$option->name.'][video_type][]', $vt_options);
	$output .= '
	<div class="field-row clearfix">
		<div class="label">Video Type:</div>
		'. $videotypelist .'
	</div>';
// Source
	$output .= '
	<div class="field-row clearfix">
		<div class="label">Source ID <a href="#" class="open-videohelp">[ How to add source?! ]</a></div>
		<input type="text" name="' . $name.'['.$option->name.'][sourceid][]' . '" value="'
. ($values[$option->name]['sourceid'] ? $values[$option->name]['sourceid'] : '') . '" class="input-xlarge" />
		
	</div>';
// Loop
	$output .= '
	<div class="field-row clearfix">
		<div class="label">Loop video?</div>
		' . JHTML::_('select.genericlist', array(JHtml::_('select.option', '0', JText::_('JNO')), JHtml::_('select.option', '1', JText::_('JYES'))), $name.'['.$option->name.'][loop][]', '', 'value','text', (isset($values[$option->name]['loop']) ? $values[$option->name]['loop'] : 1) ) .'
	</div>';
// Autoplay
	$output .= '
	<div class="field-row clearfix">
		<div class="label">Autoplay?</div>
		' . JHTML::_('select.genericlist', array(JHtml::_('select.option', '0', JText::_('JNO')), JHtml::_('select.option', '1', JText::_('JYES'))), $name.'['.$option->name.'][autoplay][]', '', 'value','text', (isset($values[$option->name]['autoplay']) ? $values[$option->name]['autoplay'] : 1) ) .'
	</div>';
// Preload
	$output .= '
	<div class="field-row clearfix">
		<div class="label">Preload video?</div>
		' . JHTML::_('select.genericlist', array(JHtml::_('select.option', 'auto', 'Auto'), JHtml::_('select.option', 'metadata', 'Metadata'), JHtml::_('select.option', 'none', 'None')), $name.'['.$option->name.'][preload][]', '', 'value','text', (isset($values[$option->name]['preload']) ? $values[$option->name]['preload'] : 'none') ) .'
	</div>';
// Mute
	$output .= '
	<div class="field-row clearfix">
		<div class="label">Start Mute?</div>
		' . JHTML::_('select.genericlist', array(JHtml::_('select.option', '0', JText::_('JNO')), JHtml::_('select.option', '1', JText::_('JYES'))), $name.'['.$option->name.'][mute][]', '', 'value','text', (isset($values[$option->name]['mute']) ? $values[$option->name]['mute'] : 1) ) .'
	</div>';
// Has Overlay
	$output .= '
	<div class="field-row clearfix">
		<div class="label">Has Overlay?</div>
		' . JHTML::_('select.genericlist', array(JHtml::_('select.option', '0', JText::_('JNO')), JHtml::_('select.option', '1', JText::_('JYES'))), $name.'['.$option->name.'][hasoverlay][]', '', 'value','text', (isset($values[$option->name]['hasoverlay']) ? $values[$option->name]['hasoverlay'] : 1) ) .'
	</div>';



$output .= '
			</div>
		</div>
</div>';
