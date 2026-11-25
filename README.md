# wemake-acs

Wemake Accessibility - free WordPress accessibility plugin by Wemake.

- **Requires:** PHP 5.6.40+ (checked by the plugin).
- The repository is **always public**: the download link below and the updates of copies 1.61-1.62.1 read its releases.

This README is the living reference: download link, how updates work, releases. Source of truth is the code; update
this file in the same change.

## Docs

- `README.md` (this file) - download link, updates, releases.
- [docs/DECISIONS.md](docs/DECISIONS.md) - decisions and who made them, newest on top.
- [docs/CHANGELOG.md](docs/CHANGELOG.md) - releases and changes with Verify and Rollback, newest on top.
- [CLAUDE.md](CLAUDE.md) - rules for Claude in this repository.

## Download link (for users)

Always points to the newest release:

https://github.com/wemake-digital-agency/wemake-acs/releases/latest/download/wemake-acs.zip

It is used in the email sent by the form on https://www.wemake.co.il/acs-plugin/ (CF7 form "ACS plugin" #24233 → Mail (2) → "להורדה" button).
Do not link to `archive/refs/heads/main.zip`: its root folder is `wemake-acs-main/`, so WordPress would install a duplicate plugin, and it contains unreleased code.

## How updates work

From 1.63 the plugin updates through the Wemake update server and the standard WordPress updater (Dashboard > Updates,
the Plugins screen, WordPress auto-updates). It asks `https://repository.wemake.co.il/check.php` when WordPress reads its
update list (at most once per 12 hours, "Check again" skips the cache); the server reads the latest GitHub release of
this repository and returns a signed download link to `wemake-acs.zip`.

- Client: `inc/class-wemake-update-client.php` (`Wemake_Update_Client_1_0`), started in `wemake_acs.php` for every
  request (also cron). The canonical copy lives in `wemake-digital-agency/wemake-repository` (`client/`); copy it from
  there, don't edit it here.
- The `Update URI` header (`wemake_acs.php`) keeps WordPress from offering a wordpress.org plugin with the same slug.
- Nothing is replaced unless the whole zip arrived intact and holds `wemake_acs.php` with a plugin header; otherwise the
  installed version stays. After an update the plugin keeps its installed folder name.
- The server answers only while `wemake-acs` is in `WM_CLIENT_UPDATES` (`wemake-repository`, `public_html/inc/github.php`).
- Sites whose host blocks outgoing requests to `repository.wemake.co.il` get no updates: install new versions there by hand.

Older copies reach the new version by themselves, each in its own way:

| Installed version | How it gets the latest release |
|---|---|
| 1.61 - 1.62.1 | Its own GitHub updater (`inc/admin_update_plugin_github.php`, removed in 1.63) reads `releases/latest` and offers the first `.zip` asset in wp-admin; the admin clicks "Update now" (or WordPress auto-updates it). |
| 1.45 - 1.56 | Its old updater asks `repository.wemake.co.il/update.php` from wp-admin (every 5 minutes while an admin is in wp-admin) and shows "update" under the plugin on the Plugins screen; the admin clicks it. The server offers the latest GitHub release as a zip without the top folder while `wemake-acs` is in `WM_UPDATE_FROM_GITHUB`. That updater downloads the whole zip first, then deletes the plugin files and unpacks the new ones; the server puts `wemake_acs.php` last in that zip, so an unpack that breaks halfway leaves no main file and WordPress skips the plugin. |
| 1.22 and older | No updater: install by hand. |

After that one step every copy is on 1.63+ and updates through the Wemake update server.

Never edit plugin files directly on a site: the next update overwrites them. Fix it here and release.

## Making a release

1. Bump the version in both places in `wemake_acs.php`: the `Version:` header and `WMACS_PLUGIN_VERSION`. Add an entry
   to `docs/CHANGELOG.md`. The new number must be greater than the latest release, compared as versions
   (`1.63` → `1.63.1` fix, `1.64` feature).
2. Merge to `main`, then push a tag with the same version: `git tag v1.64 && git push origin v1.64`.
   Don't create the release in the GitHub web UI: it would be public for a minute without `wemake-acs.zip`, and copies
   1.61-1.62.1 that check in that minute fall back to GitHub's source archive (wrong folder name).
3. The `Release` workflow (`.github/workflows/release.yml`) checks that the tag matches both versions, lints the PHP,
   builds `wemake-acs.zip` (top folder `wemake-acs/`, plugin files only), creates the release as a draft with the zip and
   then publishes it as the latest release.
4. Check the release page (the `wemake-acs.zip` asset is there) and that the download link above returns the new version.
   Sites see the update within 12 hours (plus at most one hour of server cache), or at once with "Check again".

## Updating a site by hand

1. WP Admin → Plugins → **Wemake Accessibility** → *Update now* (*Dashboard → Updates → Check again* forces a check).
   Or upload `wemake-acs.zip` manually: Plugins → Add New → Upload Plugin → *Replace current with uploaded*.
2. Clear the page cache (WP Rocket / LiteSpeed).
