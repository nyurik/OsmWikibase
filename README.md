MediaWiki extension to customize the Wikibase on OSM Wiki.

See [OSM Wikibase project page](https://wiki.openstreetmap.org/wiki/OpenStreetMap:Wikibase)

### Implemented
-  Style sitelink section to only show "other" section without the header and the edit links at at the top right, adjusted for multiple skins

### Work in progress
-  Overrides default ItemId to use `Y` instead of `Q` prefix

This turned out to be much more difficult than anticipated. The work has been moved to the `customPrefix` branch.  The proposed solution works for creating and editing items, but it breaks when a sitelink needs to be resolved into a Wikibase ID. 
