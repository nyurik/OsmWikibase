MediaWiki extension to customize the Wikibase on OSM Wiki.

* See [OSM Wikibase project info page](https://wiki.openstreetmap.org/wiki/OpenStreetMap:Wikibase)
* See [Installation instructions](https://wiki.openstreetmap.org/wiki/OpenStreetMap:Wikibase/Technical_Site_Configuration)

### Implemented
-  Style sitelink section to only show "other" section without the header and the edit links at at the top right, adjusted for multiple skins

### Work in progress
-  Overrides default ItemId to use `Y` instead of `Q` prefix

This turned out to be much more difficult than anticipated. The work has been moved to the `customPrefix` branch.  The proposed solution works for creating and editing items, but it breaks when a sitelink needs to be resolved into a Wikibase ID.

### Custom Site object
To customize site link normalization, use `OsmWikibase\OsmSite` instead of `Site` object. This code assumes you want `wiki` as the site ID.

```php
.../mediawki$ php maintenance/shell.php
>>>
  $site = new OsmWikibase\OsmSite();
  $site->setGlobalId( 'wiki' );
  $site->setGroup( 'osm' );
  $site->setPath( Site::PATH_LINK, "https://wiki.openstreetmap.org/wiki/$1" );

  // If updating, make sure to keep internal ID
  $store = SiteSQLStore::newInstance();
  $oldSite = $store->getSite( $site->getGlobalId() );
  if ( $oldSite ) $site->setInternalId( $oldSite->getInternalId() );
  $store->saveSites( [ $site ] );
```
