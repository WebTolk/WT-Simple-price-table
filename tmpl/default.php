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
           <summary class="py-2" itemprop="name">
               <h3 class="d-inline h5"><?php echo $section->section_title; ?></h3>
           </summary>
           <?php if (!empty($section->table_rows)): ?>
               <table class="table">
                   <?php foreach ($section->table_rows as $row) : ?>
                       <tr itemscope itemtype="https://schema.org/Product">
                           <?php
                           if(!empty($row->product_icon)) { ?>
                               <td>
                                   <?php $img_src = HTMLHelper::cleanImageURL($row->product_icon);
                                   $img_attribs = [
                                           'width' => '72',
                                       'height' => '72',
                                       'style' => 'margin-bottom: -4px;',
                                       'class' => 'me-4'
                                   ];
                                   echo HTMLHelper::image($img_src->url,
                                       (!empty($row->product_title) ? htmlspecialchars($row->product_title):'иконка'), $img_attribs); ?>
                               </td>
                           <?php } ?>

                           <td class="w-75" itemprop="name"><p><?php echo $row->product_title; ?></p></td>
                           <td class="text-center" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                               <meta itemprop="price" content="<?php echo $row->price; ?>">
                               <meta itemprop="priceCurrency" content="<?php echo $currency; ?>">
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
                   <?php endforeach; ?>
               </table>
           <?php endif; ?>
       </details>
   <?php endforeach; ?>
</div>