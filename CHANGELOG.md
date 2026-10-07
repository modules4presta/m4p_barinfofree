# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project
adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-10-06

### Removed

- A cURL call to modules4presta.io made on every visit to the module configuration, which fetched
  advertisements to display in the back office of somebody else's shop, along with the advertisement
  panel and the two settings that cached its responses.
- The link to the paid version embedded in the module description.

### Added

- Default settings written on install, so a fresh installation has sensible colours and font size
  instead of empty values.

### Changed

- Released under the MIT license, with English and Polish catalogues and the standard documentation.
- Compatibility declared against the installed PrestaShop instead of stopping at 8.1.99.
- Author headers no longer carry the retired `kontakt@nice-code.eu` address.

## [1.2.0] - earlier

### Added

- Top bar with configurable text, colours and font size, an optional close button and a cookie that
  remembers the dismissal.
