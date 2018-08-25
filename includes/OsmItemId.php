<?php

namespace OsmWikibase;

use Wikibase\DataModel\Entity\EntityId;
use Wikibase\DataModel\Entity\Int32EntityId;
use Wikibase\DataModel\Entity\ItemId;
use InvalidArgumentException;

/**
 * @license GPL-2.0+
 */
class OsmItemId extends ItemId {

	const PREFIX = 'Y';

	/**
	 * @since 0.5
	 */
	const PATTERN = '/^' . self::PREFIX . '[1-9]\d{0,9}\z/i';

	/**
	 * @param string $idSerialization
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( $idSerialization ) {
		$parts = self::splitSerialization( $idSerialization );
		$this->assertValidIdFormat( $parts[2] );
		EntityId::__construct( self::joinSerialization(
			[ $parts[0], $parts[1], strtoupper( $parts[2] ) ]
		) );
	}

	private function assertValidIdFormat( $idSerialization ) {
		if ( !preg_match( self::PATTERN, $idSerialization ) ) {
			throw new InvalidArgumentException( '$idSerialization must match ' . self::PATTERN );
		}

		if ( strlen( $idSerialization ) > 10
			&& substr( $idSerialization, 1 ) > Int32EntityId::MAX
		) {
			throw new InvalidArgumentException( '$idSerialization can not exceed '
				. Int32EntityId::MAX );
		}
	}

	/**
	 * Construct an ItemId given the numeric part of its serialization.
	 *
	 * CAUTION: new usages of this method are discouraged. Typically you
	 * should avoid dealing with just the numeric part, and use the whole
	 * serialization. Not doing so in new code requires special justification.
	 *
	 * @param int|float|string $numericId
	 *
	 * @return self
	 * @throws InvalidArgumentException
	 */
	public static function newFromNumber( $numericId ) {
		if ( !is_numeric( $numericId ) ) {
			throw new InvalidArgumentException( '$numericId must be numeric' );
		}

		return new self( self::PREFIX . $numericId );
	}

	/**
	 * CAUTION: Use the full string serialization whenever you can and avoid using numeric IDs.
	 *
	 * @since 7.0
	 *
	 * @param string $repositoryName
	 * @param int|float|string $numericId
	 *
	 * @return self
	 * @throws InvalidArgumentException
	 */
	public static function newFromRepositoryAndNumber( $repositoryName, $numericId ) {
		if ( !is_numeric( $numericId ) ) {
			throw new InvalidArgumentException( '$numericId must be numeric' );
		}

		return new self( self::joinSerialization( [ $repositoryName, '', self::PREFIX . $numericId ] ) );
	}

}
