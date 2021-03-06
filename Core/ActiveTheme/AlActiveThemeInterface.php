<?php
/**
 * This file is part of the RedKiteCmsBunde Application and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) RedKite Labs <webmaster@redkite-labs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.redkite-labs.com
 *
 * @license    GPL LICENSE Version 2.0
 *
 */

namespace RedKiteLabs\RedKiteCmsBundle\Core\ActiveTheme;

/**
 * Defined the methods the active theme manager object must defin
 *
 * @author RedKite Labs <webmaster@redkite-labs.com>
 */
interface AlActiveThemeInterface
{
    /**
     * Returns the active theme
     * @return null|\RedKiteLabs\ThemeEngineBundle\Core\Theme\AlTheme
     */
    public function getActiveTheme();

    /**
     * Writes the active theme
     * @param string $themeName
     */
    public function writeActiveTheme($themeName);

    /**
     * Returns the bootstrap version used by the requested theme
     *
     * @param string $themeName
     */
    public function getThemeBootstrapVersion($themeName = null);
}
