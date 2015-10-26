<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2012 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_showcategory.php 8508 2014-10-22 18:57:14Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );

	if ($this->category->haschildren) {
	    $iCol = 1;
	    $iCategory = 1;
	    $categories_per_row = VmConfig::get('categories_per_row', 3);
	    $category_cellwidth = ' width' . floor(100 / $categories_per_row);
	    $verticalseparator = " vertical-separator";
	    ?>

	    <div class="category-view">

		<?php
		// Start the Output
		if (!empty($this->category->children)) {
		    foreach ($this->category->children as $category) {
/*
			// Show the horizontal seperator
			if ($iCol == 1 && $iCategory > $categories_per_row) {
			    ?>
		    	<div class="horizontal-separator"></div>
			    <?php
			}
*/
			// this is an indicator whether a row needs to be opened or not
			if ($iCol == 1) {
			    ?>
		    	 <div class="row-fluid vmlisting">
				<?php
			    }

			    // Show the vertical seperator
			    if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
				$show_vertical_separator = ' ';
			    } else {
				$show_vertical_separator = $verticalseparator;
			    }

			    // Calculating Categories Per Row
			    $BrowseCats_per_row = $categories_per_row;
			    $Browsecellwidth = ' span' . floor (12 / $BrowseCats_per_row);

			    // Category Link
			    $caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id, FALSE);

			    // Show Category
			    ?>
			    <div class="category <?php echo $Browsecellwidth . $show_vertical_separator ?>">
			      <div class="inner-item product-list-item uppercase">
			        <span class="hover"></span>
			        <div class="image">
			          <a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
			          <?php // if ($category->ids) {
			            echo $category->images[0]->displayMediaThumb("",false);
			          //} ?>
			         </a>
			        </div>
			        <div class="prod-details fixclear">
			          <h4 class="m_title upperCase">
			            <a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>"><?php echo $category->category_name ?></a>
			          </h4>
			        </div>
			      </div><!-- /.inner-item -->
			    </div>

			    <?php
			    $iCategory++;

			    // Do we need to close the current row now?
			    if ($iCol == $categories_per_row) {
				?>
		    	    <div class="clear"></div>
		    	</div>
			    <?php
			    $iCol = 1;
			} else {
			    $iCol++;
			}
		    }
		}
		// Do we need a final closing row tag?
		if ($iCol != 1) {
		    ?>
	    	<div class="clear"></div>
	        </div>
	<?php } ?>
	</div>
    <?php }