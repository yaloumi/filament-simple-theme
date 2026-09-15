# Changelog

## v5.0.0

- Filament 5, Laravel 12 and 13, PHP 8.2+.
- The theme is precompiled CSS loaded through Filament assets: no Vite, Tailwind 3 preset or npm build,
  and the install command no longer overwrites `vite.config.js`, `package.json` and `postcss.config.js`.
- Uses Filament's own sidebar user menu (`topbar(false)`) instead of a copied user menu view, so plugins that render
  next to the user menu, such as language switchers, show up again (#1).
- New `sidebarUserMenu(false)` option to keep the topbar.
- Follows the tomatophp/filament-tomatophp-theme colors when both are enabled.
- Dropped the `tomatophp/console-helpers` dependency.
