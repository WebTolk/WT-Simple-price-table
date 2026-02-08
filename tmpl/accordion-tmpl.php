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
<div class="d-flex flex-column">
	<?php foreach ($sections as $section) : ?>
		<details class="p-3 bg-light border border-light mb-2 shadow-sm">
			<summary class="py-2">
				<h3 class="d-inline h5"><?php echo $escape($section->section_title ?? ''); ?></h3>
			</summary>
			<?php if (!empty($section->table_rows)) : ?>
				<table class="table">
					<?php foreach ($section->table_rows as $row) : ?>
						<?php if (!empty($row->product_title)) : ?>
							<tr>
								<td class="align-middle w-auto">
									<div class="d-flex gap-3 align-items-center">
										<?php if (!empty($row->product_icon)) : ?>
											<?php
                                            $imgSrc = HTMLHelper::cleanImageURL((string) $row->product_icon);
                                            $imgAttribs = [
                                                'width' => '72',
                                                'style' => 'margin-bottom: -4px;',
                                            ];
                                            echo HTMLHelper::image($imgSrc->url, $escape($row->product_title), $imgAttribs);
                                            ?>
										<?php endif; ?>
										<p><?php echo $escape($row->product_title); ?></p>
									</div>
								</td>
								<td class="align-middle w-25">
									<div class="d-flex flex-column align-items-end">
										<?php if (!empty($row->old_price)) : ?>
											<s class="text-muted fs-7 me-2"><?php echo $escape($row->old_price); ?></s>
										<?php endif; ?>
										<?php if (!empty($row->price)) : ?>
											<span class="d-inline-flex align-items-baseline gap-1 text-nowrap lh-1">
												<?php echo !empty($row->show_from) ? Text::_('MOD_WTSIMPLEPRICETABLE_FROM_PREFIX').' ' : ''; ?>
												<?php echo $escape($row->price); ?> <?php echo !empty($currency) ? $escape($currency) : ''; ?>
											</span>
										<?php endif; ?>
									</div>
								</td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</table>
			<?php endif; ?>
		</details>
	<?php endforeach; ?>
</div>
