<?php
/**
 * @package     WT Simple price table
 * @subpackage  mod_wtsimplepricetable
 *
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

declare(strict_types=1);

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$sections = $params->get('sections', null);
$currency = $params->get('currency', null);
$escape = static fn(mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');

if (empty($sections)) {
    return;
}
?>
<div class="uk-margin">
	<ul class="uk-accordion" uk-accordion="multiple: true">
		<?php foreach ($sections as $section) : ?>
			<li>
				<a class="uk-accordion-title" href="#"><?php echo $escape($section->section_title ?? ''); ?></a>
				<div class="uk-accordion-content">
					<?php if (!empty($section->table_rows)) : ?>
						<table class="uk-table uk-table-divider uk-table-small uk-margin-small-top">
							<thead>
								<tr>
									<th class="uk-width-expand"><?php echo Text::_('MOD_WTSIMPLEPRICETABLE_TABLE_COL_PRODUCT'); ?></th>
									<th class="uk-table-shrink uk-text-right uk-text-nowrap"><?php echo Text::_('MOD_WTSIMPLEPRICETABLE_TABLE_COL_PRICE'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($section->table_rows as $row) : ?>
									<?php if (!empty($row->product_title)) : ?>
										<tr>
											<td class="uk-width-expand">
												<div class="uk-flex uk-flex-middle uk-grid-small" uk-grid>
													<?php if (!empty($row->product_icon)) : ?>
														<div class="uk-width-auto">
															<?php
                                                            $imgSrc = HTMLHelper::cleanImageURL((string) $row->product_icon);
                                                            $imgAttribs = [
                                                                'width' => '72',
                                                                'class' => 'uk-border-rounded',
                                                            ];
                                                            echo HTMLHelper::image($imgSrc->url, $escape($row->product_title), $imgAttribs);
                                                            ?>
														</div>
													<?php endif; ?>
													<div class="uk-width-expand">
														<span><?php echo $escape($row->product_title); ?></span>
													</div>
												</div>
											</td>
											<td class="uk-text-right">
												<?php if (!empty($row->old_price)) : ?>
													<span class="uk-text-meta uk-margin-small-right"><s><?php echo $escape($row->old_price); ?></s></span>
												<?php endif; ?>
												<span>
													<?php if (!empty($row->price)) : ?>
														<span class="uk-margin-small-right uk-text-nowrap">
															<?php if (!empty($row->show_from)) : ?>
																<?php echo Text::_('MOD_WTSIMPLEPRICETABLE_FROM_PREFIX'); ?>
															<?php endif; ?>
															<?php echo $escape($row->price); ?> <?php echo !empty($currency) ? $escape($currency) : ''; ?></span>
													<?php endif; ?>
												</span>
											</td>
										</tr>
									<?php endif; ?>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
