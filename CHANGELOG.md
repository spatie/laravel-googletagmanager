# Changelog

All notable changes to `laravel-googletagmanager` will be documented in this file

## 2.6.5 - 2021-12-13

## What's Changed

- Change instance to bind in service provider by @fransjooste1 in https://github.com/spatie/laravel-googletagmanager/pull/43

## New Contributors

- @fransjooste1 made their first contribution in https://github.com/spatie/laravel-googletagmanager/pull/43

**Full Changelog**: https://github.com/spatie/laravel-googletagmanager/compare/2.6.4...2.6.5

## 2.6.4 - 2021-12-11

## What's Changed

- Make binding a closure by @bilfeldt in https://github.com/spatie/laravel-googletagmanager/pull/42

## New Contributors

- @bilfeldt made their first contribution in https://github.com/spatie/laravel-googletagmanager/pull/42

**Full Changelog**: https://github.com/spatie/laravel-googletagmanager/compare/2.6.3...2.6.4

## 2.6.3 - 2021-11-17

## What's Changed

- Update CHANGELOG.md by @igor-kamil in https://github.com/spatie/laravel-googletagmanager/pull/36
- teeny tiny fix in readme by @mkwsra in https://github.com/spatie/laravel-googletagmanager/pull/38
- Prevent dataLayer entries from being reset by @FrittenKeeZ in https://github.com/spatie/laravel-googletagmanager/pull/40

## New Contributors

- @igor-kamil made their first contribution in https://github.com/spatie/laravel-googletagmanager/pull/36
- @mkwsra made their first contribution in https://github.com/spatie/laravel-googletagmanager/pull/38
- @FrittenKeeZ made their first contribution in https://github.com/spatie/laravel-googletagmanager/pull/40

**Full Changelog**: https://github.com/spatie/laravel-googletagmanager/compare/2.6.2...2.6.3

## 2.6.1 - 2019-08-21

Get default values from .env file

## 2.6.0 + 2018-10-30

- Added: `setId`

## 2.5.1 - 2018-10-15

- Fixed view creator

## 2.5.0 - 2018-07-25

- Separate the script to head and body sections

## 2.4.0 - 2017-10-26

- Added: support for L5.5 package discovery

## 2.2.3

- Fixed: Unescape unicode in DataLayer JSON

## 2.2.1

- Fixed: `toJson` should always return a string

## 2.2.0

- Added: Flash function

## 2.1.0

- Added: option to specify the path to macros

## 2.0.0

- This is now a Laravel 5 specific package. Laravel 4 version can be found here: https://github.com/spatie/laravel4-googletagmanager

## 1.2.2

- Changed: If GoogleTagManager is disabled, ApiKeyNotSetException won't throw

## 1.2.1

- Bugfix: script rendering was missing $dataLayer

## 1.2.0

- First official release
