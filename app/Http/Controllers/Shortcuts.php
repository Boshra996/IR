<?php

namespace App\Http\Controllers;


class Shortcuts extends Controller
{
    function numberToWords($num)
    {
        $ones = array(1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five", 6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen", 16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen");
        $tens = array(1 => "ten", 2 => "twenty", 3 => "thirty", 4 => "forty", 5 => "fifty", 6 => "sixty", 7 => "seventy", 8 => "eighty", 9 => "ninety");
        $hundreds = array("hundred", "thousand", "million", "billion", "trillion", "quadrillion");

        //limit t quadrillion

        $num = number_format($num, 2, ".", ",");

        if ($num == 0)
            return "zero";

        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));

        krsort($whole_arr);
        $rettxt = "";
        foreach ($whole_arr as $key => $i) {
            $i = ltrim($i, '0');
            if ($i != "") {
                if ($i < 20) {
                    $rettxt .= $ones[$i];
                } else if ($i < 100) {
                    $rettxt .= $tens[substr($i, 0, 1)];

                    if (substr($i, 1, 1) != 0)
                        $rettxt .= " " . $ones[substr($i, 1, 1)];
                } else {
                    $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                    $i = substr($i, 1, 2);
                    // $rettxt .= " ".$tens[substr($i,1,1)];
                    // $rettxt .= " ".$ones[substr($i,2,1)];
                    $i = ltrim($i, '0');
                    if ($i != "") {
                        if ($i < 20) {
                            $rettxt .= " " . $ones[$i];
                        } else if ($i < 100) {
                            $rettxt .= " " . $tens[substr($i, 0, 1)];

                            if (substr($i, 1, 1) != 0)
                                $rettxt .= " " . $ones[substr($i, 1, 1)];
                        }
                    }
                }
            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        }
        if ($decnum > 0) {
            $rettxt .= " and ";
            if ($decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }


    function convertShortucts($tokens)
    {
        // $daysIndex = array('sun' => 0, 'mon' => 1, 'tue' => 2, 'wed' => 3, 'thu' => 4, 'fri' => 5, 'sat' => 6);
        // $days = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
        // $monthsIndex = array('jan' => 0, 'feb' => 1, 'mar' => 2, 'apr' => 3, 'may' => 4, 'june' => 5, 'july' => 6, 'aug' => 7, 'sept' => 8, 'oct' => 9, 'nov' => 10, 'dec' => 11);
        // $months = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
        $currencyShortuct = array("$" => "usd", "€" => "eur", "£" => 'gbp', "¥" => "jpy", "ƒ" => "ang");
        $currency = array(
            "aed" => "united arab emirates dirham",
            "afn" => "afghan afghani",
            "amd" => "armenian dram",
            "ang" => "netherlands antillean guilder",
            "aoa" => "angolan kwanza",
            "ars" => "argentine peso",
            "aud" => "australian dollar",
            "awg" => "aruban florin",
            "azn" => "azerbaijani manat",
            "bam" => "bosnia and herzegovina convertible mark",
            "bbd" => "barbados dollar",
            "bdt" => "bangladeshi taka",
            "bgn" => "bulgarian lev",
            "bhd" => "bahraini dinar",
            "bif" => "burundian franc",
            "bmd" => "bermudian dollar",
            "bnd" => "brunei dollar",
            "bob" => "boliviano",
            "brl" => "brazilian real",
            "bsd" => "bahamian dollar",
            "bwp" => "botswana pula",
            "byn" => "new belarusian ruble",
            "byr" => "belarusian ruble",
            "bzd" => "belize dollar",
            "cad" => "canadian dollar",
            "cdf" => "congolese franc",
            "chf" => "swiss franc",
            "clf" => "unidad de fomento",
            "clp" => "chilean peso",
            "cny" => "renminbi|chinese yuan",
            "cop" => "colombian peso",
            "crc" => "costa rican colon",
            "cuc" => "cuban convertible peso",
            "cve" => "cape verde escudo",
            "czk" => "czech koruna",
            "djf" => "djiboutian franc",
            "dkk" => "danish krone",
            "dop" => "dominican peso",
            "dzd" => "algerian dinar",
            "egp" => "egyptian pound",
            "ern" => "eritrean nakfa",
            "etb" => "ethiopian birr",
            "eur" => "euro",
            "fjd" => "fiji dollar",
            "fkp" => "falkland islands pound",
            "gbp" => "pound sterling",
            "gel" => "georgian lari",
            "ghs" => "ghanaian cedi",
            "gip" => "gibraltar pound",
            "gmd" => "gambian dalasi",
            "gnf" => "guinean franc",
            "gtq" => "guatemalan quetzal",
            "gyd" => "guyanese dollar",
            "hkd" => "hong kong dollar",
            "hnl" => "honduran lempira",
            "hrk" => "croatian kuna",
            "htg" => "haitian gourde",
            "huf" => "hungarian forint",
            "idr" => "indonesian rupiah",
            "ils" => "israeli new shekel",
            "inr" => "indian rupee",
            "iqd" => "iraqi dinar",
            "irr" => "iranian rial",
            "isk" => "icelandic króna",
            "jmd" => "jamaican dollar",
            "jod" => "jordanian dinar",
            "jpy" => "japanese yen",
            "kes" => "kenyan shilling",
            "kgs" => "kyrgyzstani som",
            "khr" => "cambodian riel",
            "kmf" => "comoro franc",
            "kpw" => "north korean won",
            "krw" => "south korean won",
            "kwd" => "kuwaiti dinar",
            "kyd" => "cayman islands dollar",
            "kzt" => "kazakhstani tenge",
            "lak" => "lao kip",
            "lbp" => "lebanese pound",
            "lkr" => "sri lankan rupee",
            "lrd" => "liberian dollar",
            "lsl" => "lesotho loti",
            "lyd" => "libyan dinar",
            "mdl" => "moldovan leu",
            "mga" => "malagasy ariary",
            "mkd" => "macedonian denar",
            "mmk" => "myanmar kyat",
            "mnt" => "mongolian tögrög",
            "mop" => "macanese pataca",
            "mro" => "mauritanian ouguiya",
            "mur" => "mauritian rupee",
            "mvr" => "maldivian rufiyaa",
            "mwk" => "malawian kwacha",
            "mxn" => "mexican peso",
            "mxv" => "mexican unidad de inversion",
            "myr" => "malaysian ringgit",
            "mzn" => "mozambican metical",
            "nad" => "namibian dollar",
            "ngn" => "nigerian naira",
            "nio" => "nicaraguan córdoba",
            "nok" => "norwegian krone",
            "npr" => "nepalese rupee",
            "nzd" => "new zealand dollar",
            "omr" => "omani rial",
            "pab" => "panamanian balboa",
            "pen" => "peruvian sol",
            "pgk" => "papua new guinean kina",
            "pkr" => "pakistani rupee",
            "pln" => "polish złoty",
            "pyg" => "paraguayan guaraní",
            "qar" => "qatari riyal",
            "ron" => "romanian leu",
            "rsd" => "serbian dinar",
            "rub" => "russian ruble",
            "rwf" => "rwandan franc",
            "sar" => "saudi riyal",
            "sbd" => "solomon islands dollar",
            "scr" => "seychelles rupee",
            "sdg" => "sudanese pound",
            "sek" => "swedish krona",
            "sgd" => "singapore dollar",
            "shp" => "saint helena pound",
            "sll" => "sierra leonean leone",
            "sos" => "somali shilling",
            "srd" => "surinamese dollar",
            "ssp" => "south sudanese pound",
            "std" => "são tomé and príncipe dobra",
            "svc" => "salvadoran colón",
            "syp" => "syrian pound",
            "szl" => "swazi lilangeni",
            "thb" => "thai baht",
            "tjs" => "tajikistani somoni",
            "tmt" => "turkmenistani manat",
            "tnd" => "tunisian dinar",
            "ttd" => "trinidad and tobago dollar",
            "twd" => "new taiwan dollar",
            "tzs" => "tanzanian shilling",
            "uah" => "ukrainian hryvnia",
            "ugx" => "ugandan shilling",
            "usd" => "united states dollar",
            "uyi" => "uruguay peso en unidades indexadas",
            "uyu" => "uruguayan peso",
            "uzs" => "uzbekistan som",
            "vef" => "venezuelan bolívar",
            "vnd" => "vietnamese đồng",
            "vuv" => "vanuatu vatu",
            "wst" => "samoan tala",
            "xaf" => "central african cfa franc",
            "xcd" => "east caribbean dollar",
            "xof" => "west african cfa franc",
            "xpf" => "cfp franc",
            "yer" => "yemeni rial",
            "zar" => "south african rand",
            "zmw" => "zambian kwacha",
            "zwl" => "zimbabwean dollar"
        );

        $countryList = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas the',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island (Bouvetoya)',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros the',
            'CD' => 'Congo',
            'CG' => 'Congo the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote d\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FO' => 'Faroe Islands',
            'FK' => 'Falkland Islands (Malvinas)',
            'FJ' => 'Fiji the Fiji Islands',
            'FI' => 'Finland',
            'FR' => 'France, French Republic',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia the',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => 'Korea',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyz Republic',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NL' => 'Netherlands the',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal, Portuguese Republic',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia (Slovak Republic)',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia, Somali Republic',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard & Jan Mayen Islands',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland, Swiss Confederation',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States of America',
            'UM' => 'United States Minor Outlying Islands',
            'VI' => 'United States Virgin Islands',
            'UY' => 'Uruguay, Eastern Republic of',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );

        foreach ($tokens as $index => $token) {
            // if (isset($daysIndex[$token])) {
            //     $tokens[$index] = $days[$daysIndex[$token]];
            // } else if (isset($monthsIndex[$token])) {
            //     $tokens[$index] = $months[$monthsIndex[$token]];
            // }
            if (isset($currencyShortuct[$token])) {
                $tokens[$index] = $currency[$currencyShortuct[$token]];
            } else if (isset($currency[$token])) {
                $tokens[$index] = $currency[$token];
            } else if (isset($countryList[strtoupper($token)])) {
                $tokens[$index] = strtolower($countryList[strtoupper($token)]);
            } else if (is_numeric($token)) {
                $tokens[$index] = $this->numberTowords($token);
            }
        }
        return $tokens;
    }
}
