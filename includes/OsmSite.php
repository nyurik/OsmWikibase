<?php

/**
 * Class representing an OSM wiki site.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Site
 * @license GPL-2.0-or-later
 * @author Yuri Astrakhan < yuriastrakhan@gmail.com >
 */

namespace OsmWikibase;

use MediaWiki\Site\MediaWikiPageNameNormalizer;
use Site;
use Title;

/**
 * Class representing an OSM site.
 *
 * @ingroup Site
 */
class OsmSite extends Site {

	public function __construct( $type = 'osm' ) {
		parent::__construct( $type );
	}

	// Force English as the language code for OSM wikis if not set.
	// For some reason setting 'en' in the constructor does not work,
	// probably due to APCU cache deserialization order.
	// Without this, this code assumes it is not NULL:
	//    extensions/Wikibase/repo/includes/Specials/SpecialItemByTitle.php:194
	public function getLanguageCode() {
		return parent::getLanguageCode() ?? 'en';
	}

	// FIXME: Blindly adding $followRedirect to make OsmSite::normalizePageName() compatible with Site normalizePageName()
	// This is a hack, and should be fixed properly.
	public function normalizePageName( $pageName, $followRedirect = MediaWikiPageNameNormalizer::FOLLOW_REDIRECT  ) {
		return Title::newFromText( $pageName )->getPrefixedText();
	}

	public function getPageUrl( $pageName = false ) {
		if ( $pageName !== false ) {
			// Use dbkey-style URL
			$pageName = str_replace( ' ', '_', trim( $pageName ) );
		}

		return parent::getPageUrl( $pageName );
	}
}
