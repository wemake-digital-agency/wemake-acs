# Wemake Accessibility - Changelog

Releases and other changes, newest on top. Every entry: What, Why, Verify, Rollback, Task.
Versions before 1.62.1 have no entries here; see the git history.

## 2026-11-25 - 1.63: updates through the Wemake update server

What:
- Shared update client (`inc/class-wemake-update-client.php`, started for every request in `wemake_acs.php`) and the `Update URI` header. Removed the GitHub updater (`inc/admin_update_plugin_github.php`), the old updater (`inc/admin_update.php`, `inc/action.php`, the update code in `assets/js/admin.js` and the `wmacs_language` script in `inc/admin.php`). Version 1.63.
- `inc/frontend.php`: removed the old updater's maintenance mode (it showed "Briefly unavailable" on the whole site while the option `wmacs_maintenance_on` was set).
- `inc/action.php` turned PHP error display on for every AJAX request of the site (`WMACS_AJAX_DEBUG`); the file and the constant are gone.
- `inc/admin.php`: the settings form checks a WordPress nonce and saves only allowed values (checkbox, listed radio options, color values).
- Release workflow `.github/workflows/release.yml` (tag-based, draft first, asset `wemake-acs.zip`) instead of `plugin-release.yml`. README rewritten, docs added. Personal email removed from the file header.
Why: Decision 2026-11-25 "Updates through the Wemake update server, old copies included".
Verify: After the tag `v1.63` the GitHub release has `wemake-acs.zip` with the top folder `wemake-acs/`, and the download link returns 1.63. Tested locally (WordPress 7.0, PHP 8.3, the update server code with `wemake-acs` in both lists): the real 1.56 old updater (same code as 1.51) got 1.63 from `update.php`, removed its old files, the plugin stayed active and the widget shows on the front end; 1.62.1 with its GitHub updater installed 1.63 from the release zip; 1.63 then updated to newer versions through the update server with "Update now" and with WordPress auto-update; the settings form without a nonce stops with "The link you followed has expired", with a nonce it saves and replaces a bad color with the default. PHP lint on 7.4 and 8.3.
Rollback: Publish a new release with the previous code and a higher version (e.g. 1.63.1); on the update server remove `wemake-acs` from `WM_UPDATE_FROM_GITHUB` and `WM_CLIENT_UPDATES` to stop offering releases.
Task: https://task.nexfield.day/t/1f244bcb-0313-55f0-8ec7-53ab75b7acfb

## 1.62.1 - release asset name

What: The release asset is always named `wemake-acs.zip` (was `wemake-acs-<tag>.zip`), so the permanent `releases/latest/download/wemake-acs.zip` link works. No plugin code changes.
Why: The download link in the form email on wemake.co.il/acs-plugin/.
Verify: https://github.com/wemake-digital-agency/wemake-acs/releases/latest/download/wemake-acs.zip downloads the zip.
Rollback: Not needed.
Task: -
