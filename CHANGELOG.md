# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).
## [Unreleased]

## [1.5.0]

### Fixed

- Test setTtl() is duplicated #24

### Added

- Added support for creating a new group #26

## [1.4.0]

### Added

- Added support for Time to Live (TTL) parameter

### Changed

- Changed phpunit test command; removed `-v` flag 

## [1.3.2]

### Added

- Added error message from curl into logic exception when curl failed to send a request

## [1.3.1] - 2023-02-06

### Added

- Added change log

### Changed

- Changed tests pipeline from Travis to Github Actions

## [1.3.0] - 2022-12-31

### Removed

- Drop PHP 7.1, 7.2 and 7.3 support

### Fixed

- Fix deprecation warning when running tests on PHP 8.1 and 8.2

[Unreleased]: https://github.com/slunak/pushover-php/compare/v1.5.0...HEAD
[1.5.0]: https://github.com/slunak/pushover-php/compare/v1.4.0...v1.5.0
[1.4.0]: https://github.com/slunak/pushover-php/compare/v1.3.2...v1.4.0
[1.3.2]: https://github.com/slunak/pushover-php/compare/v1.3.1...v1.3.2
[1.3.1]: https://github.com/slunak/pushover-php/compare/v1.3.0...v1.3.1
[1.3.0]: https://github.com/slunak/pushover-php/compare/v1.2.0...v1.3.0
