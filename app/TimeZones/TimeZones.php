<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

class Timezones
{
    public static function getTzFromWindows($windowsTimezone): \DateTimeZone
    {
        $ianaTimezone = self::$timeZoneMap[$windowsTimezone] ?? null;

        // If not found in map, assume the input might be an IANA ID already
        if ($ianaTimezone === null) {
            $ianaTimezone = $windowsTimezone;
        }

        return new \DateTimeZone($ianaTimezone);
    }

    // Basic lookup for mapping Windows time zone identifiers to IANA identifiers
    // Mappings taken from https://github.com/unicode-org/cldr/blob/main/common/supplemental/windowsZones.xml
    private static $timeZoneMap = [
        "Dateline Standard Time" => "Etc/GMT+12",
        "UTC-11" => "Etc/GMT+11",
        "Aleutian Standard Time" => "America/Adak",
        "Hawaiian Standard Time" => "Pacific/Honolulu",
        "Marquesas Standard Time" => "Pacific/Marquesas",
        "Alaskan Standard Time" => "America/Anchorage",
        "UTC-09" => "Etc/GMT+9",
        "Pacific Standard Time (Mexico)" => "America/Tijuana",
        "UTC-08" => "Etc/GMT+8",
        "Pacific Standard Time" => "America/Los_Angeles",
        "US Mountain Standard Time" => "America/Phoenix",
        "Mountain Standard Time (Mexico)" => "America/Chihuahua",
        "Mountain Standard Time" => "America/Denver",
        "Central America Standard Time" => "America/Guatemala",
        "Central Standard Time" => "America/Chicago",
        "Easter Island Standard Time" => "Pacific/Easter",
        "Central Standard Time (Mexico)" => "America/Mexico_City",
        "Canada Central Standard Time" => "America/Regina",
        "SA Pacific Standard Time" => "America/Bogota",
        "Eastern Standard Time (Mexico)" => "America/Cancun",
        "Eastern Standard Time" => "America/New_York",
        "Haiti Standard Time" => "America/Port-au-Prince",
        "Cuba Standard Time" => "America/Havana",
        "US Eastern Standard Time" => "America/Indianapolis",
        "Turks And Caicos Standard Time" => "America/Grand_Turk",
        "Sri Lanka Standard Time" => "Asia/Colombo",
        "Nepal Standard Time" => "Asia/Katmandu",
        "Central Asia Standard Time" => "Asia/Almaty",
        "Bangladesh Standard Time" => "Asia/Dhaka",
        "Omsk Standard Time" => "Asia/Omsk",
        "Myanmar Standard Time" => "Asia/Rangoon",
        "SE Asia Standard Time" => "Asia/Bangkok",
        "Altai Standard Time" => "Asia/Barnaul",
        "W. Mongolia Standard Time" => "Asia/Hovd",
        "North Asia Standard Time" => "Asia/Krasnoyarsk",
        "N. Central Asia Standard Time" => "Asia/Novosibirsk",
        "Tomsk Standard Time" => "Asia/Tomsk",
        "China Standard Time" => "Asia/Shanghai",
        "North Asia East Standard Time" => "Asia/Irkutsk",
        "Singapore Standard Time" => "Asia/Singapore",
        "W. Australia Standard Time" => "Australia/Perth",
        "Taipei Standard Time" => "Asia/Taipei",
        "Ulaanbaatar Standard Time" => "Asia/Ulaanbaatar",
        "Aus Central W. Standard Time" => "Australia/Eucla",
        "Transbaikal Standard Time" => "Asia/Chita",
        "Tokyo Standard Time" => "Asia/Tokyo",
        "North Korea Standard Time" => "Asia/Pyongyang",
        "Korea Standard Time" => "Asia/Seoul",
        "Yakutsk Standard Time" => "Asia/Yakutsk",
        "Cen. Australia Standard Time" => "Australia/Adelaide",
        "AUS Central Standard Time" => "Australia/Darwin",
        "E. Australia Standard Time" => "Australia/Brisbane",
        "AUS Eastern Standard Time" => "Australia/Sydney",
        "West Pacific Standard Time" => "Pacific/Port_Moresby",
        "Tasmania Standard Time" => "Australia/Hobart",
        "Vladivostok Standard Time" => "Asia/Vladivostok",
        "Lord Howe Standard Time" => "Australia/Lord_Howe",
        "Bougainville Standard Time" => "Pacific/Bougainville",
        "Russia Time Zone 10" => "Asia/Srednekolymsk",
        "Magadan Standard Time" => "Asia/Magadan",
        "Norfolk Standard Time" => "Pacific/Norfolk",
        "Sakhalin Standard Time" => "Asia/Sakhalin",
        "Central Pacific Standard Time" => "Pacific/Guadalcanal",
        "Russia Time Zone 11" => "Asia/Kamchatka",
        "New Zealand Standard Time" => "Pacific/Auckland",
        "UTC+12" => "Etc/GMT-12",
        "Fiji Standard Time" => "Pacific/Fiji",
        "Chatham Islands Standard Time" => "Pacific/Chatham",
        "UTC+13" => "Etc/GMT-13",
        "Tonga Standard Time" => "Pacific/Tongatapu",
        "Samoa Standard Time" => "Pacific/Apia",
        "Line Islands Standard Time" => "Pacific/Kiritimati"
    ];
}
