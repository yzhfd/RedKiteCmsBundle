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

namespace RedKiteLabs\RedKiteCmsBundle\Core\Content\Slot\Repeated\Converter;

class AlSlotConverterToPage extends AlSlotConverterBase
{
    /**
     * {@inheritdoc}
     *
     * @return null|boolean
     * @throws \Exception
     *
     * @api
     */
    public function convert()
    {
        if (count($this->arrayBlocks) <= 0) {
            return null;
        }
        try {
            $this->blockRepository->startTransaction();
            $result = $this->deleteBlocks();
            if (false !== $result) {
                $languages = $this->languageRepository->activeLanguages();
                $pages = $this->pageRepository->activePages();
                foreach ($this->arrayBlocks as $block) {
                    foreach ($languages as $language) {
                        foreach ($pages as $page) {
                            $result = $this->updateBlock($block, $language->getId(), $page->getId());
                        }
                    }
                }

                if ($result) {
                    $this->blockRepository->commit();
                } else {
                    $this->blockRepository->rollBack();
                }
            }

            return $result;
        } catch (\Exception $e) {
            if (isset($this->blockRepository) && $this->blockRepository !== null) {
                $this->blockRepository->rollBack();
            }

            throw $e;
        }
    }
}
