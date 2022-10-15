<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DateTimeFormat extends Component
{
    public bool $paletteShown = false;
    public string $input = '';

    protected $listeners = ['show'];

    public function show()
    {
        $this->paletteShown = true;
    }

    public function render()
    {
        return view('livewire.date-time-format');
    }

    public function formattedString()
    {
        return $this->input ? now()->format($this->input) : now();
    }

    public function getFormatProperty()
    {
        return [
            'Day' => [
                [
                    'character' => 'd',
                    'desc' => 'Day of the month, 2 digits with leading zeros',
                    'example' => '01 to 31',
                ],
                [
                    'character' => 'D',
                    'desc' => 'A textual representation of a day, three letters',
                    'example' => 'Mon through Sun',
                ],
                [
                    'character' => 'j',
                    'desc' => 'Day of the month without leading zeros',
                    'example' => '1 to 31',
                ],
                [
                    'character' => 'l (lowercase \'L\')',
                    'desc' => 'A full textual representation of the day of the week',
                    'example' => 'Sunday through Saturday',
                ],
                [
                    'character' => 'N',
                    'desc' => 'ISO 8601 numeric representation of the day of the week',
                    'example' => '1 (for Monday) through 7 (for Sunday)',
                ],
                [
                    'character' => 'S',
                    'desc' => 'English ordinal suffix for the day of the month, 2 characters',
                    'example' => 'st, nd, rd or th. Works well with j',
                ],
                [
                    'character' => 'w',
                    'desc' => 'Numeric representation of the day of the week',
                    'example' => '0 (for Sunday) through 6 (for Saturday)',
                ],
                [
                    'character' => 'z',
                    'desc' => 'The day of the year (starting from 0)',
                    'example' => '0 through 365',
                ],
            ],
            'Week' => [
                [
                    'character' => 'W',
                    'desc' => 'ISO 8601 week number of year, weeks starting on Monday',
                    'example' => 'Example: 42 (the 42nd week in the year)',
                ],
            ],
            'Month' => [
                [
                    'character' => 'F',
                    'desc' => 'A full textual representation of a month, such as January or March',
                    'example' => 'January through December',
                ],
                [
                    'character' => 'm',
                    'desc' => 'Numeric representation of a month, with leading zeros',
                    'example' => '01 through 12',
                ],
                [
                    'character' => 'M',
                    'desc' => 'A short textual representation of a month, three letters',
                    'example' => 'Jan through Dec',
                ],
                [
                    'character' => 'n',
                    'desc' => 'Numeric representation of a month, without leading zeros',
                    'example' => '1 through 12',
                ],
                [
                    'character' => 't',
                    'desc' => 'Number of days in the given month',
                    'example' => '28 through 31',
                ],
            ],
            'Year' => [
                [
                    'character' => 'L',
                    'desc' => 'Whether it\'s a leap year',
                    'example' => '1 if it is a leap year, 0 otherwise.',
                ],
                [
                    'character' => 'o',
                    'desc' => 'ISO 8601 week-numbering year. This has the same value as Y, except that if the ISO week number (W) belongs to the previous or next year, that year is used instead.',
                    'example' => 'Examples: 1999 or 2003',
                ],
                [
                    'character' => 'X',
                    'desc' => 'An expanded full numeric representation of a year, at least 4 digits, with - for years BCE, and + for years CE.',
                    'example' => 'Examples: -0055, +0787, +1999, +10191',
                ],
                [
                    'character' => 'x',
                    'desc' => 'An expanded full numeric representation if requried, or a standard full numeral representation if possible (like Y). At least four digits. Years BCE are prefixed with a -. Years beyond (and including) 10000 are prefixed by a +.',
                    'example' => 'Examples: -0055, 0787, 1999, +10191',
                ],
                [
                    'character' => 'Y',
                    'desc' => 'A full numeric representation of a year, at least 4 digits, with - for years BCE.',
                    'example' => 'Examples: -0055, 0787, 1999, 2003, 10191',
                ],
                [
                    'character' => 'y',
                    'desc' => 'A two digit representation of a year',
                    'example' => 'Examples: 99 or 03',
                ],
            ],
            'Time' => [
                [
                    'character' => 'a',
                    'desc' => 'Lowercase Ante meridiem and Post meridiem',
                    'example' => 'am or pm',
                ],
                [
                    'character' => 'A',
                    'desc' => 'Uppercase Ante meridiem and Post meridiem', 
                    'example' => 'AM or PM',
                ],
                [
                    'character' => 'B',
                    'desc' => 'Swatch Internet time', 
                    'example' => '000 through 999',
                ],
                [
                    'character' => 'g',
                    'desc' => '12-hour format of an hour without leading zeros', 
                    'example' => '1 through 12',
                ],
                [
                    'character' => 'G',
                    'desc' => '24-hour format of an hour without leading zeros', 
                    'example' => '0 through 23',
                ],
                [
                    'character' => 'h',
                    'desc' => '12-hour format of an hour with leading zeros', 
                    'example' => '01 through 12',
                ],
                [
                    'character' => 'H',
                    'desc' => '24-hour format of an hour with leading zeros', 
                    'example' => '00 through 23',
                ],
                [
                    'character' => 'i',
                    'desc' => 'Minutes with leading zeros', 
                    'example' => '00 to 59',
                ],
                [
                    'character' => 's',
                    'desc' => 'Seconds with leading zeros', 
                    'example' => '00 through 59',
                ],
                [
                    'character' => 'u',
                    'desc' => 'Microseconds. Note that date() will always generate 000000 since it takes an int parameter, whereas DateTime::format() does support microseconds if DateTime was created with microseconds.',
                    'example' => 'Example: 654321',
                ],
                [
                    'character' => 'v',
                    'desc' => 'Milliseconds. Same note applies as for u.',
                    'example' => 'Example: 654',
                ],
            ],
            'Timezone' => [
                [
                    'character' => 'e',
                    'desc' => 'Timezone identifier',
                    'example' => 'Examples: UTC, GMT, Atlantic/Azores',
                ],
                [
                    'character' => 'I (capital i)',
                    'desc' => 'Whether or not the date is in daylight saving time',
                    'example' => '1 if Daylight Saving Time, 0 otherwise.',
                ],
                [
                    'character' => 'O',
                    'desc' => 'Difference to Greenwich time (GMT) without colon between hours and minutes',
                    'example' => 'Example: +0200',
                ],
                [
                    'character' => 'P',
                    'desc' => 'Difference to Greenwich time (GMT) with colon between hours and minutes',
                    'example' => 'Example: +02:00',
                ],
                [
                    'character' => 'p',
                    'desc' => 'The same as P, but returns Z instead of +00:00 (available as of PHP 8.0.0)',
                    'example' => 'Example: +02:00',
                ],
                [
                    'character' => 'T',
                    'desc' => 'Timezone abbreviation, if known; otherwise the GMT offset.',
                    'example' => 'Examples: EST, MDT, +05',
                ],
                [
                    'character' => 'Z',
                    'desc' => 'Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive.',
                    'example' => '-43200 through 50400',
                ],
            ],
            'Full Date/Time' => [
                [
                    'character' => 'c',
                    'desc' => 'ISO 8601 date',
                    'example' => '2004-02-12T15:19:21+00:00',
                ],
                [
                    'character' => 'r',
                    'desc' => '» RFC 2822/» RFC 5322 formatted date',
                    'example' => 'Example: Thu, 21 Dec 2000 16:01:07 +0200',
                ],
                [
                    'character' => 'U',
                    'desc' => 'Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)',
                    'example' => 'See also time()',
                ],
            ],
        ];
    }
}
