<?php
/**
 * @package     WT Simple price table
 * @author      Sergey Tolkachyov and Sergey Sergevnin
 * @copyright   Copyright (C) 2021-2026 Sergey Tolkachyov. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @link        https://web-tolk.ru
 * @version     1.0.0
 */

declare(strict_types=1);

namespace Joomla\Module\Wtsimplepricetable\Site\Fields;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\SpacerField;
use Joomla\CMS\Language\Text;

class ModuleinfoField extends SpacerField
{
    protected $type = 'Moduleinfo';

    protected function getInput(): string
    {
        return ' ';
    }

    protected function getTitle(): string
    {
        return $this->getLabel();
    }

    protected function getLabel(): string
    {
        $data = $this->form->getData();
        $module = (string) $data->get('module', 'mod_wtsimplepricetable');
        $doc = Factory::getApplication()->getDocument();
        $doc->addStyleDeclaration(
            '.plugin-info-img-svg:hover * { cursor: pointer; }'
        );

        $moduleManifestPath = JPATH_SITE . '/modules/' . $module . '/' . $module . '.xml';
        $version = '';

        if (is_file($moduleManifestPath)) {
            $manifest = simplexml_load_file($moduleManifestPath);

            if ($manifest !== false && isset($manifest->version)) {
                $version = (string) $manifest->version;
            }
        }

        return '
        </div>
        <div class="row g-0 w-100 p-3 shadow">
            <div class="col-12 col-md-3">
                <a href="https://web-tolk.ru" target="_blank" rel="noopener noreferrer">
                    <svg class="plugin-info-img-svg" width="200" height="50" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <title>Go to https://web-tolk.ru</title>
                            <text font-weight="bold" xml:space="preserve" text-anchor="start"
                                  font-family="Helvetica, Arial, sans-serif" font-size="32" id="svg_3" y="36.085949"
                                  x="8.152073" stroke-width="0" stroke="#000"
                                  fill="#0fa2e6">Web</text>
                            <text font-weight="bold" xml:space="preserve" text-anchor="start"
                                  font-family="Helvetica, Arial, sans-serif" font-size="32" id="svg_4" y="36.081862"
                                  x="74.239105" stroke-width="0" stroke="#000"
                                  fill="#384148">Tolk</text>
                        </g>
                    </svg>
                </a>
            </div>
            <div class="col-12 col-md-9">
                <span class="badge bg-success text-white">v.' . htmlspecialchars($version, ENT_QUOTES, 'UTF-8') . '</span>
                ' . Text::_(strtoupper($module) . '_DESC') . '
            </div>
        </div>
        <div>
        ';
    }
}
