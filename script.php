<?php
/**
 * @package     WT Simple price table
 * @version     1.0.0
 * @author      Sergey Tolkachyov, https://web-tolk.ru
 * @copyright   (c) 2022 - 2026 Sergey Tolkachyov. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       1.0.0
 */

declare(strict_types=1);

use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Version;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

\defined('_JEXEC') or die;

return new class () implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->set(
            InstallerScriptInterface::class,
            new class ($container->get(AdministratorApplication::class)) implements InstallerScriptInterface {
                protected AdministratorApplication $app;

                protected string $minimumJoomla = '6.0.0';

                protected string $minimumPhp = '8.2.0';

                public function __construct(AdministratorApplication $app)
                {
                    $this->app = $app;
                }

                public function install(InstallerAdapter $adapter): bool
                {
                    return true;
                }

                public function uninstall(InstallerAdapter $adapter): bool
                {
                    return true;
                }

                public function update(InstallerAdapter $adapter): bool
                {
                    return true;
                }

                public function preflight(string $type, InstallerAdapter $adapter): bool
                {
                    return $this->checkCompatible($adapter->getElement());
                }

                public function postflight(string $type, InstallerAdapter $adapter): bool
                {
                    if ($type !== 'uninstall') {
                        $smiles = ['&#9786;', '&#128512;', '&#128521;', '&#128525;', '&#128526;', '&#128522;', '&#128591;'];
                        $smile = $smiles[array_rand($smiles)];
                    } else {
                        $smile = '&#128546;';
                    }

                    $element = strtoupper($adapter->getElement());
                    $type = strtoupper($type);
                    $header = Text::_($element . '_AFTER_' . $type) . ' <br/>' . Text::_($element);
                    $message = Text::_($element . '_DESC');
                    $message .= Text::_($element . '_WHATS_NEW');

                    $html = '
                    <div class="row m-0">
                        <div class="col-12 col-md-8 p-0 pe-2">
                            <h2>' . $smile . ' ' . $header . '</h2>
                            ' . $message . '
                        </div>
                        <div class="col-12 col-md-4 p-0 d-flex flex-column justify-content-start">
                            <img width="180" src="https://web-tolk.ru/web_tolk_logo_wide.png" alt="Web Tolk">
                            <p>Joomla Extensions</p>
                            <p class="btn-group">
                                <a class="btn btn-sm btn-outline-primary" href="https://web-tolk.ru" target="_blank" rel="noopener noreferrer">https://web-tolk.ru</a>
                                <a class="btn btn-sm btn-outline-primary" href="mailto:info@web-tolk.ru"><i class="icon-envelope"></i> info@web-tolk.ru</a>
                            </p>
                            <div class="btn-group-vertical mb-3 web-tolk-btn-links" role="group" aria-label="Joomla community links">
                                <a class="btn btn-danger text-white w-100" href="https://t.me/joomlaru" target="_blank" rel="noopener noreferrer">' . Text::_($element . '_JOOMLARU_TELEGRAM_CHAT') . '</a>
                                <a class="btn btn-primary text-white w-100" href="https://t.me/webtolkru" target="_blank" rel="noopener noreferrer">' . Text::_($element . '_WEBTOLK_TELEGRAM_CHANNEL') . '</a>
                            </div>
                            ' . Text::_($element . '_MAYBE_INTERESTING') . '
                        </div>
                    </div>
                    ';

                    $this->app->enqueueMessage($html, 'info');

                    return true;
                }

                protected function checkCompatible(string $element): bool
                {
                    $element = strtoupper($element);

                    if (!(new Version())->isCompatible($this->minimumJoomla)) {
                        $this->app->enqueueMessage(
                            Text::sprintf($element . '_ERROR_COMPATIBLE_JOOMLA', $this->minimumJoomla),
                            'error'
                        );

                        return false;
                    }

                    if (version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
                        $this->app->enqueueMessage(
                            Text::sprintf($element . '_ERROR_COMPATIBLE_PHP', $this->minimumPhp),
                            'error'
                        );

                        return false;
                    }

                    return true;
                }
            }
        );
    }
};
