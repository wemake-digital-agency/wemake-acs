# wemake-acs

Wemake Accessibility — free WordPress accessibility plugin by Wemake.

Sites update this plugin **from GitHub releases** of this repository. The repository is **always public** — every site that installed the plugin updates from here.

## Download link (for users)

Always points to the newest release:

https://github.com/wemake-digital-agency/wemake-acs/releases/latest/download/wemake-acs.zip

It is used in the email sent by the form on https://www.wemake.co.il/acs-plugin/ (CF7 form "ACS plugin" #24233 → Mail (2) → "להורדה" button).
Do not link to `archive/refs/heads/main.zip`: its root folder is `wemake-acs-main/`, so WordPress would install a duplicate plugin, and it contains unreleased code.

## How updates work

`inc/admin_update_plugin_github.php` checks
`https://api.github.com/repos/wemake-digital-agency/wemake-acs/releases/latest`
and offers an update in WP Admin when the release tag (without the leading `v`) is greater than the installed version (`version_compare(tag, current, '>')`).
The package is the **first `.zip` asset** of the release (`wemake-acs.zip`). If a release has no zip asset, it falls back to GitHub's source zipball, which has the wrong root folder — so always check that the release has `wemake-acs.zip` attached.

Never edit plugin files directly on a site — the next update overwrites them. Fix it here and release.

## Making a release

1. Commit and push the change to `main`.
2. Pick the next tag. It must be greater than the latest one, compared as versions:
   `1.62.1` → `v1.62.2` (fix) or `v1.63` (feature).
   Do not publish a lower number after a higher one: the newest published release becomes "Latest" and is what the download link and the updater serve.
3. Go to [Releases](https://github.com/wemake-digital-agency/wemake-acs/releases) → **Draft a new release**:
   - **Choose a tag** → type the new tag (e.g. `v1.63`) → *Create new tag on publish*, target `main`.
   - **Release title**, e.g. `v1.63 — short summary`.
   - **Release notes**: what changed and why.
   - Keep **Set as the latest release** checked → **Publish release**.
4. The [`plugin-release.yml`](.github/workflows/plugin-release.yml) workflow then runs automatically (watch it in [Actions](https://github.com/wemake-digital-agency/wemake-acs/actions)):
   - sets `Version:` and `WMACS_PLUGIN_VERSION` in `wemake_acs.php` to the tag number and commits it to `main` (`Update plugin version to … [skip ci]`);
   - builds `wemake-acs.zip` (root folder `wemake-acs/`) and attaches it to the release.
5. Check the release page: the `wemake-acs.zip` asset is there, and the download link above returns the new version.
6. Pull `main` locally afterwards — the workflow pushed a version commit.

Do not bump the version in `wemake_acs.php` by hand — the workflow does it from the tag.

## Updating a site

1. WP Admin → Plugins → **Wemake Accessibility** → *Update now* (*Dashboard → Updates → Check again* forces a check).
   Or upload `wemake-acs.zip` manually: Plugins → Add New → Upload Plugin → *Replace current with uploaded*.
2. Clear the page cache (WP Rocket / LiteSpeed).

## Changelog

- **1.62.1** — Release asset is now always named `wemake-acs.zip` (was `wemake-acs-<tag>.zip`), so the permanent `releases/latest/download/wemake-acs.zip` link works. No plugin code changes.
