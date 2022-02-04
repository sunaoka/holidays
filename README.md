# Holiday calculation library for PHP

[![Latest](https://poser.pugx.org/sunaoka/holidays/v)](https://packagist.org/packages/sunaoka/holidays)
[![License](https://poser.pugx.org/sunaoka/holidays/license)](https://packagist.org/packages/sunaoka/holidays)
[![PHP](https://img.shields.io/packagist/php-v/sunaoka/holidays)](composer.json)
[![Test](https://github.com/sunaoka/holidays/actions/workflows/test.yml/badge.svg)](https://github.com/sunaoka/holidays/actions/workflows/test.yml)
[![codecov](https://codecov.io/gh/sunaoka/holidays/branch/develop/graph/badge.svg)](https://codecov.io/gh/sunaoka/holidays)

---

## Supported Countries

| Country                       | Code |
|-------------------------------|------|
| :cn: China                    | `CN` |
| :de: Germany                  | `DE` |
| :fr: France                   | `FR` |
| :gb: United Kingdom           | `GB` |
| :hong_kong: Hong Kong         | `HK` |
| :indonesia: Indonesia         | `ID` |
| :it: Italy                    | `IT` |
| :jp: Japan                    | `JP` |
| :kr: Korea                    | `KR` |
| :taiwan: Taiwan               | `TW` |
| :us: United States of America | `US` |

## Installation

```bash
composer require sunaoka/holidays
```

## Basic Usage

### Finds whether a date is a holiday

```php
use Sunaoka\Holidays\Holidays;

// Is January 1, 2021 a holiday in the United States (US)?
$holidays = new Holidays('US');
$holidays->isHoliday('2021-01-01');
// => true
```

### Returns a list of holidays

```php
use Sunaoka\Holidays\Holidays;

// Returns United States (US) Holidays in 2021
$holidays = new Holidays('US');
$holidays->getHolidays(2021);
// =>
// array(36) {
//   [0] =>
//   class Sunaoka\Holidays\Holiday#1 (4) {
//     protected $name =>
//     string(14) "New Year's Day"
//     public $date =>
//     string(26) "2021-01-01 00:00:00.000000"
//     public $timezone_type =>
//     int(3)
//     public $timezone =>
//     string(3) "UTC"
//   }
//   [1] =>
//   class Sunaoka\Holidays\Holiday#2 (4) {
//     protected $name =>
//     string(26) "Martin Luther King Jr. Day"
//     public $date =>
//     string(26) "2021-01-18 00:00:00.000000"
//     public $timezone_type =>
//     int(3)
//     public $timezone =>
//     string(3) "UTC"
//   }
//     :
//     :
//     :
//   [35] =>
//   class Sunaoka\Holidays\Holiday#36 (4) {
//     protected $name =>
//     string(14) "New Year's Eve"
//     public $date =>
//     string(26) "2021-12-31 00:00:00.000000"
//     public $timezone_type =>
//     int(3)
//     public $timezone =>
//     string(3) "UTC"
//   }
```

### Update holiday data to latest

```bash
php ./vendor/bin/holiday-update
```
