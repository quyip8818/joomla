<?php

/*------------------------------------------------------------------------
@author 		Hogash Studio
@copyright 		Copyright © 2014 hogash.com. All rights reserved.
@license 		Commercial License http://themeforest.net/licenses/regular_extended
@website 		http://www.hogash.com/
@version 		1.1

@Supports:
	* Text Field
		~ Simple text field
		~ type="text"
		~ Options/Attributes:
	* Hidden Field
		~ Simple hidden field
		~ type="hidden"
		~ Options/Attributes:
	* Media Field
		~ Browse for image field
		~ type="media"
		~ Options/Attributes:
	* Spacer field
		~ Simple spacer field
		~ type="spacer"
		~ Options/Attributes:
	* Textarea field
		~ Simple textarea field
		~ type="textarea"
		~ Options/Attributes:
	* Editor Field
		~ Generates a WYSIWYG editor
		~ type="editor"
		~ Options/Attributes:
	* Texturl field
		~ URL + Target field (for links)
		~ type="texturl"
		~ Options/Attributes:
	* Video field
		~ Text fields to provide paths to videos
		~ type="video"
		~ Options/Attributes:
	* Fontlist field
		~ List of icon font from FontAwesome
		~ type="fontlist"
		~ Options/Attributes:
	* Select field
		~ Simple select list
		~ type="select"
		~ Options/Attributes:
	* Sql field
		~ SQL Query for various usages eg: articles list
		~ type="sql"
		~ Options/Attributes:
	* Menuitem Field
		~ List with all Menus and Menu items
		~ type="menuitem"
		~ Options/Attributes:

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
jimport('joomla.filesystem.file');

class JFormFieldHgdyno extends JFormField {
	/*
	TO DO
		-
	*/
	protected $type = 'Hgdyno';
	protected static $initialised = false;
	protected static $mediaInitialised = false;
	protected static $videoHelpInit = false;
	protected static $editorInitialised = false;

	protected static function getPath() {
		$path = JURI::root(true)."/plugins/system/hg_assets/assets/";
		return $path;
	}

	protected function getLabel() {
		$html = '';
		return $html;
	}

	protected function getInput() {

		$fieldID = str_replace(array('[', ']', 'jformparams'), '', $this->name);


		if (!self::$initialised) {
			$document = JFactory::getDocument();

		$document->addScriptDeclaration('
//;(function($) {
	var minimizeText = "Minimize",
		maximizeText = "Maximize";

	// Generate Unique ID
	function uniqueid() {
		return Math.random().toString(36).substr(2, 9);
	}

	// Update the item count
	function updateItemsCount(container) {
		var count = 0;
		container.find("div.dynoitem").each(function(){
			count++;
		});
		return count;
	}

	// Clear Button - clear the filed
	function clearButton(container){
		container.find(".clearBtn").each(function(){
			jQuery(this).on("click",function(e){
				e.preventDefault();
				jQuery(this).closest(".wrapper").find("input[type=text]").attr("value","");
			});
		});
	}

	// Refresh rows
	function confirm($row, dynoManager) {
		var cnt = updateItemsCount(dynoManager);

		// prepare image fields
		$row.find(".browseField input[type=text]").each(function(){
			var _t =  jQuery(this),
				thisID = _t.attr("id"),
				uniq = uniqueid(),
				thisIDnum = _t.attr("id").match(/\d+/g);

			_t.attr("id", thisID.replace(thisID, "imgfield_"+uniq));

			// also replace in href
			var thisBtn = _t.closest(".wrapper").find("a.modalBtn"),
				thisBtnHref = thisBtn.attr("href"),
				thisBtnNum = thisBtnHref.split("=").pop();
			if(thisBtnNum)
				thisBtn.attr("href", thisBtnHref.replace(thisBtnNum, "imgfield_"+uniq));
			else
				thisBtn.attr("href", thisBtnHref+"imgfield_"+uniq);
		});

		// enable clear button for new instances
		clearButton(dynoManager);

		// update item counter
		$row.find("span.itemcounter").text(cnt);

		// enable squeeze button for new instances
		//SqueezeBox.assign($$("#hgdynoManager tr:last-child a.modal"), {parse: "rel"});
		if(typeof(SqueezeBox) != "undefined" && SqueezeBox != null)
			SqueezeBox.assign($$(".hgdynoManager tr:last-child a.modal"), {parse: "rel"});

		// enable the resize button for new instances
		$row.find(".resize-dynoitem").on("click", toggleIndividualBox);

		// update newly menu items fields
		var menuItemField = $row.find(".fld.menuitem select"),
			thisName = menuItemField.attr("name"),
			str;
		if(menuItemField.length > 0) {
			str = thisName.replace("[][]", "[" + (cnt - 1) + "][]");
			menuItemField.attr("name", str);
		}

		if(typeof(jQuery.fn.trumbowyg) != "undefined" && jQuery.fn.trumbowyg != null)
			$row.find(".fld.editor textarea").trumbowyg({
				fixedFullWidth: true,
				resetCss: true,
				autogrow: true
			});

		if(typeof(jQuery.fn.minicolors) != "undefined" && jQuery.fn.minicolors != null)
			$row.find(".fld.colorpicker .minicolors").minicolors({
				control: "hue",
				position: "right",
				theme: "bootstrap"
			});

		iosLabels(dynoManager);
		easemdl(dynoManager);
	}

	function updateMenuItems($row) {
		var menuItemFields = $row.find(".fld.menuitem select"),
			boxes = [],
			regex = /\[([0-9]+)\]/;
		if(menuItemFields.length > 0) {
		menuItemFields.each(function(i){
			var thisName = jQuery(this).attr("name"),
				matches = thisName.match(regex);
			if (null != matches) {
				boxes.push(matches[1]);
				str = thisName.replace(regex, "[" + (boxes.length - 1) + "]");
				jQuery(this).attr("name", str);
			}
		});
		}
	}

	// Minimize/Maximize Individual Box
	function toggleIndividualBox() {
		var $this = jQuery(this),
			dynoBox = $this.closest("td");
		$this.text(dynoBox.hasClass("minimized") ? minimizeText + " Box" : maximizeText + " Box");
		dynoBox.toggleClass("minimized");
	};

	// Minimize/Maximize All Boxes
	function toggleMasterCollapse() {

		var $this = jQuery(this),
			dynoManager = jQuery(this).closest(".manager_wrap").find("table.hgdynoManager");
			dynoBoxes = dynoManager.find("td"),
			dynoBoxesButtons = dynoBoxes.find(".resize-dynoitem");

		if($this.hasClass("minimized")) {
			$this.text(minimizeText + " All");
			dynoBoxes.removeClass("minimized");
			dynoBoxesButtons.text(minimizeText + " Box");
		} else {
			$this.text(maximizeText + " All");
			dynoBoxes.addClass("minimized");
			dynoBoxesButtons.text(maximizeText + " Box");
		}
		$this.toggleClass("minimized");
	};

	function toggleAllCollapse() {

		var $this = jQuery(this),
			dynoManager = jQuery(this).closest(".manager_wrap").find("table.hgdynoManager");
			dynoBoxes = dynoManager.find("td"),
			dynoBoxesButtons = dynoBoxes.find(".resize-dynoitem");

		if($this.hasClass("minimized")) {
			$this.text(minimizeText + " All");
			dynoBoxes.removeClass("minimized");
			dynoBoxesButtons.text(minimizeText + " Box");
		} else {
			$this.text(maximizeText + " All");
			dynoBoxes.addClass("minimized");
			dynoBoxesButtons.text(maximizeText + " Box");
		}
		$this.toggleClass("minimized");
	}
	function iosLabels(container){
		jQuery(container).find("label.iostoggle").each(function(i,el){
			var $el = jQuery(el),
				$field = $el.prev(".en_stat");
			$el.click(function(e){
				$el.toggleClass("video-enabled");
				if($field.val() == "")
					$field.val("enabled");
				else
					$field.val("");

			});
		});
	}

	function easemdl(container){
		var videoHelp = jQuery("#video_help");
		if(jQuery.fn.easyModal != "undefined" && videoHelp.length) {
			videoHelp.easyModal({ top: 200, overlay : 0.2});
			jQuery(container).find(".open-videohelp").click(function(e){
				e.preventDefault();
				videoHelp.trigger("openModal");
			});
		}
	}
//})(jQuery);
			');

			if (!version_compare(JVERSION, '3.0', 'ge')) {
				$checkJqueryLoaded = false;
				$header = $document->getHeadData();
				foreach($header['scripts'] as $scriptName => $scriptData)
				{
					if(substr_count($scriptName,'/jquery')){
						$checkJqueryLoaded = true;
					}
				}
				//Add js
				if(!$checkJqueryLoaded)
				$document->addScript(self::getPath().'js/jquery.min.js');
				$document->addScript(self::getPath().'js/jquery.noconflict.js');
			}

			// load css
			$document->addStyleSheet(self::getPath().'css/manager.css');
			// load scripts
			$document->addScript(self::getPath().'js/jquery-ui.min.js');
			$document->addScript(self::getPath().'js/jquery.dynotable.js');

			$document->addStyleDeclaration('#hgdynoManager'.$fieldID.' .chzn-done {display:inline-block !important;} #hgdynoManager'.$fieldID.' .chzn-done + .chzn-container {display:none !important;}');

			self::$initialised = true;
		}

$triggerSc = '
;(function($) {
	// when dom ready
	$(document).ready(function() {
		var dynoManager = $("#hgdynoManager'.$fieldID.'"),
			dynoElems = dynoManager.find("td");
		// init dynotable
		dynoManager.dynoTable({
			removeClass: ".removeDynoItem'.$fieldID.'",
			lastRowRemovable: '.($this->element['lastrowremovable'] == 'yes' ? 'true' : 'false').',
			orderable: '.($this->element['dragging'] != 'no' ? 'true' : 'false').',
			dragHandleClass: ".dragDynoItem'.$fieldID.'",
			addRowTemplateId: "#addTemplate'.$fieldID.'",
            addRowButtonId: "#addRow'.$fieldID.'",
			onRowRemove: function(){
				var dynoManager = $("#hgdynoManager'.$fieldID.'");
				updateItemsCount($("#hgdynoManager'.$fieldID.'"));
				updateMenuItems($("#hgdynoManager'.$fieldID.'"));
			},
			onRowAdd: function(){
				confirm($("#hgdynoManager'.$fieldID.'").find("tr:last-child"), $("#hgdynoManager'.$fieldID.'"));
				updateItemsCount($("#hgdynoManager'.$fieldID.'"));
			},
			onRowReorder: function(){
				updateItemsCount($("#hgdynoManager'.$fieldID.'"));
			}
		});

		// on click, do the work
		$(".resizeDynoItem'.$fieldID.'").on("click", toggleIndividualBox);
		$("#minimizeAll'.$fieldID.'").on("click", toggleMasterCollapse);

		updateItemsCount(dynoManager);
		clearButton(dynoManager);

		iosLabels(dynoManager);
		easemdl(dynoManager);
	});
})(jQuery);';

		JFactory::getDocument()->addScriptDeclaration($triggerSc);

		$itemName = ($this->element['itemnname'] ? $this->element['itemnname'] : 'Item');
		$showPreview = ($this->element['showpreview'] == 'no' ? false : true);
		$itemMinimized = $this->element['minimized'];

		$output = '<div class="manager_wrap">';

		$output .= '
	<div class="manager_head clearfix">
		<span id="minimizeAll'.$fieldID.'" class="minimize_all hg_uikit_button '.($itemMinimized == 'yes'  ? 'minimized' : '').'">'.($itemMinimized == 'yes'  ? 'Maximize All' : 'Minimize All').'</span>
		<strong class="manager_label">'.$this->element['label'].'</strong>
	</div>

	<table class="hgdynoManager" id="hgdynoManager'.$fieldID.'">';
		if($this->value && is_array($this->value)) {
		//if($this->value) {
			// Get the field options.
			$options = $this->getOptions();
			// print_r($this->value);
			foreach($this->value['vals'] as $k => $v) {
				// get stored values
				$thevalues = array();
				// assign stored values to each field
				// print_r($this->value);
				foreach ($options as $option)
				{

					if($option->type == 'spacer') {
						$thevalues[$option->name] = null;
					} else {

						if(self::is_multidim_array($this->value[$option->name])) {

							foreach ($this->value[$option->name] as $mdk => $mdv) {
								$thevalues[$option->name][$mdk] = isset($this->value[$option->name][$mdk][$k]) ? $this->value[$option->name][$mdk][$k] : null;;
								// echo $this->value[$option->name][$mdk][$k];
							}
							// $thevalues[$option->name]['link'] = $this->value[$option->name]['link'][$k];
						} else {
							$thevalues[$option->name] = isset($this->value[$option->name][$k]) ? $this->value[$option->name][$k] : null;
						}

					}

					if(isset($this->value['dynotitle'][$k]))
						$thevalues['dynotitle'] = $this->value['dynotitle'][$k];
				}
				// print_r($thevalues);

				// load fields with the stored values
				$output .= '<tr>'.self::getFields($this->name, 'default', $thevalues, $k).'</tr>';
			}

		} else {
			// load empty fields
			if($this->element['startempty'] != 'yes')
			$output .= '<tr>'.self::getFields($this->name, 'default').'</tr>';
		}
			//load template fields for dynoTable script
			$output .= '<tr id="addTemplate'.$fieldID.'">'.self::getFields($this->name, 'template').'</tr>';

		$output .= '
	</table>
	<a id="addRow'.$fieldID.'" class="hg_uikit_button addnew">Add New '.$itemName.'</a>
</div>';

		return $output;
	}

	protected function getMedia($imgName, $img = null, $i = null) {

			$link = (string) $this->element['img']['link'];

			if (!self::$mediaInitialised) {

				// Load the modal behavior script.
				JHtml::_('behavior.modal');

				// Build the script.
				$script = array();
				$script[] = '	function jInsertFieldValue(value, id) {';
				$script[] = '		var old_id = document.id(id).value;';
				$script[] = '		if (old_id != id) {';
				$script[] = '			var elem = document.id(id)';
				$script[] = '			elem.value = value;';
				$script[] = '			elem.fireEvent("change");';
				$script[] = '		}';
				$script[] = '	}';

				// Add the script to the document head.
				JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

				self::$mediaInitialised = true;
			}

			// Initialize variables.
			$html = array();
			$attr = '';

			// The text field.
			$html[] = '<div class="wrapper">';
			$html[] = '<div class="fltlft chain browseField">';
			$unique_id = uniqid('imgfield_');
			$html[] = '	<input class="input-medium" type="text" name="'.$this->name.'['.$imgName.'][]'.'" id="'.$unique_id.'"' .
						' value="'.htmlspecialchars($img, ENT_COMPAT, 'UTF-8').'"' .
						' readonly="readonly" />';
			$html[] = '</div>';

			// The button.
			$html[] = '<a class="modal modalBtn hg_uikit_button" title="'.JText::_('JLIB_FORM_BUTTON_SELECT').'"
				href="'.($this->element['img']['readonly'] ? '' : ($link ? $link : 'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=&amp;author=') . '&amp;folder=&amp;fieldid='.$unique_id).'" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">';
			$html[] = JText::_('JLIB_FORM_BUTTON_SELECT').'</a>';

			$html[] = '<a title="'.JText::_('JLIB_FORM_BUTTON_CLEAR').'" class="clearBtn hg_uikit_button"  href="#" >'.JText::_('JLIB_FORM_BUTTON_CLEAR').'</a>';
			$html[] = '</div>';

			return implode("\n", $html);

		}

	function getFields($name, $type = 'default', $values = null, $k = null){

		$fieldID = str_replace(array('[', ']', 'jformparams'), '', $this->name);

		$itemName = ($this->element['itemnname'] ? $this->element['itemnname'] : 'Item');
		$dragging = $this->element['dragging'];
		$itemMinimized = $this->element['minimized'];

		// Get the field options.
		$options = $this->getOptions();


		$output = '<td class="'.(($itemMinimized == 'yes' && $type =='default')  ? 'minimized' : '').' '.($type == 'template' ? 'fromtemplate':'').'" >
	<span class="itemcounter hg_uikit_button">'.($k+1).'</span>'
	.($dragging != 'no' ? '<span class="dragDynoItem'.$fieldID.' drag-dynoitem hg_uikit_button" title="click and drag to rearrange">Drag to arrange</span>':'').
	'<span class="removeDynoItem'.$fieldID.' remove-dynoitem hg_uikit_button" title="Remove '.$itemName.'">Remove '.$itemName.'</span>
	<span class="resizeDynoItem'.$fieldID.' resize-dynoitem hg_uikit_button " title="Minimize Box">'.(($itemMinimized == 'yes' && $type =='default') ? 'Maximize Box' : 'Minimize Box').'</span>
	<hr class="underbuttons">
	<div class="dynoitem">';

		$dynotitle = isset($values['dynotitle']) ? htmlspecialchars($values['dynotitle'], ENT_COMPAT, 'UTF-8') : '&raquo; Box title (click to edit, only for backend usage)';
		$output .= '
		<div class="fld clearfix dynotitle">
			<input type="text" name="'.$name.'[dynotitle][]" value="'.$dynotitle.'" title="Click to edit" />
		</div>';

	// Build the radio field output.
	foreach ($options as $i => $option)
	{
		switch($option->type){
			case"hidden":
				$output .= '<input type="hidden" name="'.$name.'['.$option->name.'][]" value="'.$values[$option->name].'" />';
			break;

			case"media":
				$showPreview = ($this->element['showpreview'] == 'no' ? false : true);
				$output .= '
				<div class="fld clearfix mediaField">
					'.(($values[$option->name] && $showPreview) ? '<div class="previewimg"><img src="'.JURI::root().$values[$option->name].'"/></div>' : '').'
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>
					'.self::getMedia($option->name, $values[$option->name], $k).'
				</div>';
			break;

			case"text":
				$output .= '
				<div class="fld clearfix">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>
					<input type="text" name="'.$name.'['.$option->name.'][]" value="'.($values[$option->name] ? htmlspecialchars($values[$option->name], ENT_COMPAT, 'UTF-8') : htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8')).'" class="'.$option->class.'" placeholder="'.$option->placeholder.'" />
				</div>';
			break;

			case"spacer":
				$output .= '
				<div class="fld clearfix">
					<label><strong>'.$option->label.'</strong></label>
				</div>';
			break;

			case"textarea":
				$output .= '
				<div class="fld clearfix">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>
					<textarea name="'.$name.'['.$option->name.'][]" class="'.$option->class.'" rows="'.($option->rows ? $option->rows : 3).'" placeholder="'.$option->placeholder.'">'.($values[$option->name] ? htmlspecialchars($values[$option->name], ENT_COMPAT, 'UTF-8') : htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8')).'</textarea>
				</div>';
			break;

			case"editor":

				if (!self::$editorInitialised) {

					$document = JFactory::getDocument();

					$document->addStyleSheet(self::getPath().'trumbowyg/design/css/trumbowyg.css');
					$document->addScript(self::getPath().'trumbowyg/trumbowyg.js');

					$document->addScriptDeclaration('
						jQuery(document).ready(function(){
							txtar = jQuery(":not(.fromtemplate) .fld.editor textarea");
							txtar.trumbowyg({
								fixedFullWidth: true,
					            resetCss: true,
					            autogrow: true
							});
						});
					');

					self::$editorInitialised = true;
				}

				$output .= '
				<div class="fld editor clearfix">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>
					<div class="clearfix"></div>
					<textarea name="'.$name.'['.$option->name.'][]" class=" '.$option->class.'" placeholder="'.$option->placeholder.'" >'.($values[$option->name] ? htmlspecialchars($values[$option->name], ENT_COMPAT, 'UTF-8') : htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8')).'</textarea>
				</div>';
			break;

			case"texturl":
				$target = ($values[$option->name]['target'] ? $values[$option->name]['target'] : $option->target);
				$output .= '
				<div class="fld clearfix">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>
					<input type="text" name="'.$name.'['.$option->name.'][link][]" value="'.$values[$option->name]['link'].'" class="input-medium" />
					<select name="'.$name.'['.$option->name.'][target][]" class="dropdown_target" >
						<option value="_self" '.($target == '_self' ? 'selected="selected"' : '').'>Same Window</option>
						<option value="_blank" '.($target == '_blank' ? 'selected="selected"' : '').'>New Window</option>
						<option value="lightbox_img" '.($target == 'lightbox_img' ? 'selected="selected"' : '').'>Lightbox Image</option>
						<option value="lightbox_iframe" '.($target == 'lightbox_iframe' ? 'selected="selected"' : '').'>Lightbox Iframe</option>
					</select>
				</div>';
			break;

			case"video":

				include dirname(__FILE__).'/_video.hgdyno.php';

			break;

			case"select":
				$output .= '
				<div class="fld clearfix">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>
					<select name="'.$name.'['.$option->name.'][]" class="'.$option->class.'" >';
				$lists = (array) json_decode($option->text);
				foreach($lists as $list) {
					$selected = '';
					if($values[$option->name]) {
						if($values[$option->name] == $list->value) {
							$selected = 'selected="selected"';
						}
					} else {
						if($option->value == $list->value){
							$selected = 'selected="selected"';
						}
					}
					$output .= '<option value="'.$list->value.'" '.$selected.'>'.$list->name.'</option>';
				}
				$output .= '</select>
				</div>';
			break;

			case"fontlist":
				$output .= '
				<div class="fld clearfix">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>
					<select name="'.$name.'['.$option->name.'][]" class="'.$option->class.'" >';

				$fontlistjson =  realpath(dirname(__FILE__) . '/..').DS.'fontlist.json';

				if(JFile::exists($fontlistjson)) {
					$lists = (array) json_decode(file_get_contents($fontlistjson));
					foreach($lists as $list) {

						$selected = '';
						if($values[$option->name]) {
							if($values[$option->name] == $list->value) {
								$selected = 'selected="selected"';
							}
						} else {
							if($option->value == $list->value){
								$selected = 'selected="selected"';
							}
						}
						$output .= '<option value="'.$list->value.'" '.$selected.'>'.$list->name.'</option>';
					}
				}
				$output .= '</select>
				</div>';
			break;

			case"menuitem":

				$multiple = isset($option->multiple) ? $option->multiple : '';

				$output .= '
				<div class="fld clearfix menuitem">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>'."\n";

					$selected = $values[$option->name]  ? $values[$option->name] : 'mainmenu.1';
					jimport('joomla.html.html.menu');

					$options = JHTML::_('menu.menuitems');
					$ilist = JHtml::_('select.genericlist', $options, $name.'['.$option->name.']['.$k.'][]',
							array(
								'list.attr' => 'class="multiple_select" '.($multiple == 'yes' ? 'multiple="multiple" ':'' ),
								'list.select' => $selected,
								'list.translate' => false
							)
						);
				$output .= $ilist;
				$output .= '</div>';
			break;

			case"sql":
				$output .= '
				<div class="fld clearfix sqlfield">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>'."\n";
					$selected = $values[$option->name]  ? $values[$option->name] : '';

					$sqloptions = array();
					$key = $option->key_field ? (string) $option->key_field : 'value';
					$value = $option->value_field ? (string) $option->value_field : (string) $option->name;
					$translate = false;
					$query = (string) $option->query;
					$db = JFactory::getDBO();
					$db->setQuery($query);
					$items = $db->loadObjectlist();
					if ($db->getErrorNum()) {
						JError::raiseWarning(500, $db->getErrorMsg());
						return $sqloptions;
					}
					$sqloptions[] = JHtml::_('select.option', 0, '-- No Article --');
					if (!empty($items))	{
						foreach ($items as $item)
							$sqloptions[] = JHtml::_('select.option', $item->$key, $item->$value);
					}

					$ilist = JHtml::_('select.genericlist', $sqloptions, $name.'['.$option->name.'][]',
							array(
								'list.attr' => 'class="'.$option->class.'"',
								'list.select' => $selected,
								'list.translate' => false
							)
						);
				$output .= $ilist;
				$output .= '</div>';
			break;

			case"colorpicker":
				$class        = ' class="' . trim('minicolors ' . $option->class) . '"';

				// Including fallback code for HTML5 non supported browsers.
				JHtml::_('jquery.framework');
				JHtml::_('script', 'system/html5fallback.js', false, true);

				JHtml::_('behavior.colorpicker');
				$output .= '
					<div class="fld colorpicker clearfix">
					<label '.($option->description ? 'class="hasTip" title="'.$option->label.'::'.$option->description.'"':'').'>'.$option->label.'</label>';
				$output .= '<input type="text" name="'.$name.'['.$option->name.'][]" id="' . $this->id . '"' . ' value="'.($values[$option->name] ? htmlspecialchars($values[$option->name], ENT_COMPAT, 'UTF-8') : htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8')).'" placeholder="#rrggbb" '  . $class . ' data-position="right" data-control="hue" />';
				$output .= '</div>';
			break;
		}
	}

		$output .= '
	</div>

</td>';
		return $output;
	}


	function is_multidim_array($arr) {
		if (!is_array($arr))
			return false;
		foreach ($arr as $elm) {
			if (!is_array($elm))
				return false;
		}
		return true;
	}

	/**
	 * Method to get the field options for fields
	 *
	 * @return  array  The field option objects.
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		foreach ($this->element->children() as $option)
		{

			// Only add <option /> elements.
			if ($option->getName() != 'option')
			{
				continue;
			}
			//print_r($option->option);

			// Create a new option object based on the <option /> element.
			$tmp = JHtml::_(
				'select.option', (string) $option['value'], trim((string) $option), 'value', 'text',
				((string) $option['disabled'] == 'true')
			);

			// Set some option attributes.
			$tmp->class = (string) $option['class'];
			$tmp->type = (string) $option['type'];
			$tmp->label = (string) $option['label'];
			$tmp->options = (string) $option['options'];
			$tmp->name = (string) $option['name'];
			$tmp->target = (string) $option['target'];
			$tmp->description = (string) $option['description'];
			$tmp->placeholder = (string) $option['placeholder'];
			$tmp->query = (string) $option['query'];
			$tmp->key_field = (string) $option['key_field'];
			$tmp->value_field = (string) $option['value_field'];

			if($tmp->type=='textarea')
				$tmp->rows = (string) $option['rows'];

			// Add the option object to the result set.
			$options[] = $tmp;
		}


		reset($options);

		return $options;
	}

}


?>