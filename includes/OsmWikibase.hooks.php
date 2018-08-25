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
	/**
	 * WikibaseRepoEntityTypes hook handler.
	 *
	 * @param array $entityTypeDefinitionsArray
	 * @return bool
	 */
	public static function onWikibaseRepoEntityTypes( &$entityTypeDefinitionsArray ) {

		$entityTypeDefinitionsArray['item']['entity-id-pattern'] = OsmItemId::PATTERN;

		$entityTypeDefinitionsArray['item']['entity-id-builder'] = function ( $serialization ) {
			return new OsmItemId( $serialization );
		};

		$entityTypeDefinitionsArray['item']['entity-id-composer-callback'] = function ( $repositoryName, $uniquePart ) {
			return OsmItemId::newFromRepositoryAndNumber( $repositoryName, $uniquePart );
		};

		return true;
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
