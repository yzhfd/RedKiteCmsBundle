<?php
/**
 * This file is part of the RedKiteCmsBunde Application and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) RedKite Labs <webmaster@redkite-labs.com>
 *
 * For the full copyright and license infpageRepositoryation, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.redkite-labs.com
 *
 * @license    GPL LICENSE Version 2.0
 *
 */

namespace RedKiteLabs\RedKiteCmsBundle\Core\Repository\Repository;

use RedKiteLabs\RedKiteCmsBundle\Model\AlSeo;

/**
 * Defines the methods used to fetch seo page attributes records
 *
 * @author RedKite Labs <webmaster@redkite-labs.com>
 */
interface SeoRepositoryInterface
{
    /**
     * Fetches a seo record by a primary key
     *
     * @param  int   $id The primary key
     * @return AlSeo A seo instance
     */
    public function fromPK($id);

    /**
     * Fetches the seo record found by page and language ids
     *
     * @param  int   $languageId The id of the language
     * @param  int   $pageId     The id of the page
     * @return AlSeo A seo instance
     */
    public function fromPageAndLanguage($languageId, $pageId);

    /**
     * Fetches the seo record by a permalink
     *
     * @param  string $permalink The permalink
     * @return AlSeo  A seo instance
     */
    public function fromPermalink($permalink);

    /**
     * Fetches the seo records by a page id
     *
     * @param  int               $pageId The id of the page
     * @return \Iterator|AlSeo[] A collection of objects
     */
    public function fromPageId($pageId);

    /**
     * Fetches the seo records by a language id
     *
     * @param  int               $languageId The id of the language
     * @return \Iterator|AlSeo[] A collection of objects
     */
    public function fromLanguageId($languageId);

    /**
     * Fetches the seo records by a page with the languages objects
     *
     * @param  int               $pageId The id of the page
     * @return \Iterator|AlSeo[] A collection of objects
     */
    public function fromPageIdWithLanguages($pageId);

    /**
     * Fetches the seo records by its page and languages with the
     * pages and languages objects
     *
     * @return \Iterator|AlSeo[] A collection of objects
     */
    public function fetchSeoAttributesWithPagesAndLanguages();

    /**
     * Fetches the seo records by a language name
     *
     * @param  string            $languageName The name of the language
     * @param  boolean           $ordered      When true orders by permalink
     * @return \Iterator|AlSeo[] A collection of objects
     */
    public function fromLanguageName($languageName, $ordered = true);

    /**
     * Fetches the seo records from by a language name
     *
     * @param  string $languageName The name of the language
     * @param  string $pageName     The name of the page
     * @return AlSeo  A seo instance
     */
    public function fromLanguageAndPageNames($languageName, $pageName);
}
