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

namespace RedKiteLabs\RedKiteCmsBundle\Core\Content\Block;

/**
 * AlBlockManagerFactory creates a BlockManager object
 *
 * @author RedKite Labs <webmaster@redkite-labs.com>
 *
 * @api
 */
interface AlBlockManagerFactoryInterface
{
    /**
     * Creates an instance of an AlBlockManager object
     *
     * @param mixed string | \RedKiteLabs\RedKiteCmsBundle\Model\AlBlock $block
     *
     * @return null|AlBlockManagerInterface
     *
     * @api
     */
    public function createBlockManager($block);
}
