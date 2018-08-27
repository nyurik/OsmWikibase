MediaWiki extension to customize the Wikibase on OSM Wiki.

See [OSM Wikibase project page](https://wiki.openstreetmap.org/wiki/OpenStreetMap:Wikibase)

# Implemented
-  Overrides default ItemId to use `Y` instead of `Q` prefix
-  Style sitelink section to only show "other" section without the header and the edit links at at the top right, adjusted for multiple skins

# Custom Item Prefixes Notes
The code in this repo will only customize the "repo" (storage) portion of the Wikibase, allowing Wikibase Items to start with a 'Y' instead of 'Q'. PRs are welcome to make it parametrizable.  This code will NOT work for the sitelinks, because as of this moment (2018-08-27), Wikibase in many places still relies on the old method of the ID parsing.  See [my patch in gerrit](https://gerrit.wikimedia.org/r/#/c/mediawiki/extensions/Wikibase/+/455480/) to fix it.

If you want to update your existing site to use a different prefix, run these queries. Depending on what extensions you have, you may have a few more tables, and possibly a slightly different table structure... danger zone, must have good backup, and be willing to break things:

```sql
UPDATE abuse_filter_log SET afl_title=CONCAT('Y',substring(afl_title, 2)) where afl_title like 'Q%' and afl_namespace = 120;
UPDATE archive SET ar_title=CONCAT('Y',substring(ar_title, 2)) where ar_title like 'Q%' and ar_namespace = 120;
UPDATE cu_changes SET cuc_title=CONCAT('Y',substring(cuc_title, 2)) where cuc_title like 'Q%' and cuc_namespace = 120;
UPDATE cur SET cur_title=CONCAT('Y',substring(cur_title, 2)) where cur_title like 'Q%' and cur_namespace = 120;
UPDATE job SET job_title=CONCAT('Y',substring(job_title, 2)) where job_title like 'Q%' and job_namespace = 120;
UPDATE logging SET log_title=CONCAT('Y',substring(log_title, 2)) where log_title like 'Q%' and log_namespace = 120;
UPDATE page SET page_title=CONCAT('Y',substring(page_title, 2)) where page_title like 'Q%' and page_namespace = 120;
UPDATE pagelinks SET pl_title=CONCAT('Y',substring(pl_title, 2)) where pl_title like 'Q%' and pl_namespace = 120;
UPDATE protected_titles SET pt_title=CONCAT('Y',substring(pt_title, 2)) where pt_title like 'Q%' and pt_namespace = 120;
UPDATE querycache SET qc_title=CONCAT('Y',substring(qc_title, 2)) where qc_title like 'Q%' and qc_namespace = 120;
UPDATE querycachetwo SET qcc_title=CONCAT('Y',substring(qcc_title, 2)) where qcc_title like 'Q%' and qcc_namespace = 120;
UPDATE querycachetwo SET qcc_title=CONCAT('Y',substring(qcc_title, 2)) where qcc_title like 'Q%' and qcc_namespace = 120;
UPDATE recentchanges SET rc_title=CONCAT('Y',substring(rc_title, 2)) where rc_title like 'Q%' and rc_namespace = 120;
UPDATE redirect SET rd_title=CONCAT('Y',substring(rd_title, 2)) where rd_title like 'Q%' and rd_namespace = 120;
UPDATE templatelinks SET tl_title=CONCAT('Y',substring(tl_title, 2)) where tl_title like 'Q%' and tl_namespace = 120;
UPDATE text SET old_title=CONCAT('Y',substring(old_title, 2)) where old_title like 'Q%' and old_namespace = 120;
UPDATE watchlist SET wl_title=CONCAT('Y',substring(wl_title, 2)) where wl_title like 'Q%' and wl_namespace = 120;
UPDATE wb_terms SET term_full_entity_id=CONCAT('Y',substring(term_full_entity_id, 2)) where term_full_entity_id like 'Q%';
UPDATE wb_changes SET change_object_id=CONCAT('Y',substring(change_object_id, 2)) where change_object_id like 'Q%';
UPDATE revision SET rev_comment=replace(rev_comment, "Item:Q", "Item:Y") where rev_comment like '%Item:Q%';
UPDATE text SET old_text=replace(old_text, '"id":"Q', '"id":"Y') where old_text like '%"id":"Q%';
UPDATE page_props SET pp_value=CONCAT('Y',substring(pp_value, 2)) where pp_propname='wikibase_item' AND pp_value like 'Q%';
```
