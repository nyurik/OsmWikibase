<?php
/**
 * OsmWikibase extension Hooks
 *
 * @file
 * @ingroup Extensions
 */

namespace OsmWikibase;


class Hooks
{
	public static function onRegistration() {
		global $wgSiteTypes;
		$wgSiteTypes['osm'] = OsmSite::class;
	}

	/**
	 * Adds CSS to customize Wikibase display
	 * @param \OutputPage &$out
	 * @param \Skin &$skin
	 * @return bool
	 */
	public static function onBeforePageDisplay(
		/** @noinspection PhpUnusedParameterInspection */ &$out, &$skin
	) {
		$out->addModuleStyles( 'ext.OsmWikibase-all' );

		$title = $out->getTitle();
		if ( $title ) {
			$ns = $title->getNamespace();
			if ( $ns === WB_NS_ITEM || $ns === WB_NS_PROPERTY ) {
				$out->addModuleStyles( 'ext.OsmWikibase' );
			}
		}

		return true;
	}

}
