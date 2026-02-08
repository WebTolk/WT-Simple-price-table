<?php

/**
 * @package       WT Simple price table
 * @subpackage      mod_custom
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license         GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;


$sections = $params->get('sections', null);
$currency = $params->get('currency', null);

if (empty($sections)) return;
?>
<div class="d-flex flex-column">
   <?php foreach ($sections as $section) : ?>
       <details class="p-3 bg-light border border-light mb-2 shadow-sm">
           <summary class="py-2">
               <h3 class="d-inline h5"><?php echo $section->section_title; ?></h3>
           </summary>
           <?php if (!empty($section->table_rows)): ?>
               <table class="table">
                   <?php foreach ($section->table_rows as $row) : ?>
                       <?php if (!empty($row->product_title)) : ?>
                           <tr>
                               <td  class="align-middle w-auto">
                                   <?php if(!empty($row->product_icon)) : ?>
                                   <div class="d-flex gap-3 align-items-center">
                                       <?php $img_src = HTMLHelper::cleanImageURL($row->product_icon);
                                       $img_attribs = [
                                           'width' => '72',
                                           'style' => 'margin-bottom: -4px;',
                                           ];
                                           $img_alt = $row->product_title;
                                           echo HTMLHelper::image($img_src->url, $img_alt, $img_attribs); ?>
                                        <?php endif ?>
                                        <p><?php echo $row->product_title; ?></p>
                                   </div>
                                   </td>
                               <!--<td><p><?php // echo $row->product_title; ?></p></td>-->
                               <td class="align-middle w-25 text-end">
                                   <p>
                                       <?php if (!empty($row->old_price)) :?>
                                           <s class="text-muted fs-7 me-2"><?php echo $row->old_price; ?></s>
                                       <?php endif; ?>
                                       <?php if (!empty($row->show_from)) :
                                                 echo "<span class=\"me-1\">от</span>";
                                            endif; ?>
                                       <?php if (!empty($row->price)) :?>
                                           <span class="me-1"><?php echo $row->price; ?></span>
                                       <?php endif; ?>
                                       <?php if (!empty($currency)) :?>
                                           <span class=""><?php echo $currency; ?></span>
                                       <?php endif; ?>
                                   </p>
                               </td>
                           </tr>
                       <?php endif; ?>
                   <?php endforeach; ?>
               </table>
           <?php endif; ?>
       </details>
   <?php endforeach; ?>
</div>