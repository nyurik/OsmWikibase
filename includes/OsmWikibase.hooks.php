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
}
