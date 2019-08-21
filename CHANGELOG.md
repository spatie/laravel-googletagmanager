# Changelog

All notable changes to `laravel-googletagmanager` will be documented in this file

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
