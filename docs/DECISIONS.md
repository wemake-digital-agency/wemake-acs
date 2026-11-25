# Wemake Accessibility - Decisions

Newest on top. Never delete an entry; mark replaced ones `Status: superseded by <date> <title>`.

## 2026-11-25 - Updates through the Wemake update server, old copies included

Decided by: Vitalii
Context: The plugin is free and installed on many sites we don't manage. Copies updated in three different ways: 1.61-1.62.1 straight from the latest GitHub release (their own GitHub updater), 1.45-1.56 through the old repository.wemake.co.il updater (an admin's click on the Plugins screen; none had moved past 1.56), 1.22 and older not at all.
Decision: From 1.63 the plugin ships the shared Wemake update client (`inc/class-wemake-update-client.php`) with the `Update URI` header, like the other Wemake plugins; the GitHub updater and the old updater are removed. Releases are built by `.github/workflows/release.yml` from a `v*` tag, published only after `wemake-acs.zip` is attached. The update server offers the latest release to old copies too: 1.61-1.62.1 get it through their GitHub updater, 1.45-1.56 through `update.php` (`WM_UPDATE_FROM_GITHUB`). Vitalii: every site must be able to update by itself, without manual work on our side. WordPress auto-updates are not forced on: a bad release would reach every site at once.
Why: One safe update path for all copies, so sites we don't manage keep getting new versions; installs recorded on the update server.
Affects: The repository stays public and the release asset stays `wemake-acs.zip` (download link and copies 1.61-1.62.1). Every release needs a tag that matches the `Version` header and `WMACS_PLUGIN_VERSION`. Removing `wemake-acs` from `WM_UPDATE_FROM_GITHUB` or `WM_CLIENT_UPDATES` stops updates for old copies or for 1.63+. The `wmacs_l` option checks are left as they are; the old updater set that option, so it now keeps its last value.
Status: active
Task: https://task.nexfield.day/t/1f244bcb-0313-55f0-8ec7-53ab75b7acfb
