<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Location\Domain\Models\City;
class SACitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                "id" => 104774,
                "name" => "Abha",
                "state_id" => 2853,
                "state_code" => "14",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "18.21639000",
                "longitude" => "42.50528000",
                'ar'  => ['name' => 'أبها'],
                'en'  => ['name' => "Abha"]
            ],
            [
                "id" => 102827,
                "name" => "Al Majāridah",
                "state_id" => 2853,
                "state_code" => "14",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "19.12361000",
                "longitude" => "41.91111000"
            ],
            [
                "id" => 102840,
                "name" => "An Nimāş",
                "state_id" => 2853,
                "state_code" => "14",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "19.14547000",
                "longitude" => "42.12009000"
            ],
            [
                "id" => 102861,
                "name" => "Khamis Mushait",
                "state_id" => 2853,
                "state_code" => "14",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "18.30000000",
                "longitude" => "42.73333000"
            ],
            [
                "id" => 102871,
                "name" => "Qal‘at Bīshah",
                "state_id" => 2853,
                "state_code" => "14",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "20.00054000",
                "longitude" => "42.60520000"
            ],
            [
                "id" => 102876,
                "name" => "Sabt Al Alayah",
                "state_id" => 2853,
                "state_code" => "14",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "19.70000000",
                "longitude" => "41.91667000"
            ],
            [
                "id" => 102882,
                "name" => "Tabālah",
                "state_id" => 2853,
                "state_code" => "14",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "19.95000000",
                "longitude" => "42.40000000"
            ],
            [
                "id" => 102815,
                "name" => "Al Bahah",
                "state_id" => 2859,
                "state_code" => "11",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "20.01288000",
                "longitude" => "41.46767000"
            ],
            [
                "id" => 102829,
                "name" => "Al Mindak",
                "state_id" => 2859,
                "state_code" => "11",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "20.15880000",
                "longitude" => "41.28337000"
            ],
            [
                "id" => 102872,
                "name" => "Qurayyat",
                "state_id" => 2857,
                "state_code" => "12",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "31.33176000",
                "longitude" => "37.34282000"
            ],
            [
                "id" => 102877,
                "name" => "Sakakah",
                "state_id" => 2857,
                "state_code" => "12",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "29.96974000",
                "longitude" => "40.20641000"
            ],
            [
                "id" => 102896,
                "name" => "Şuwayr",
                "state_id" => 2857,
                "state_code" => "12",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "30.11713000",
                "longitude" => "40.38925000"
            ],
            [
                "id" => 102898,
                "name" => "Ţubarjal",
                "state_id" => 2857,
                "state_code" => "12",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "30.49987000",
                "longitude" => "38.21603000"
            ],
            [
                "id" => 102839,
                "name" => "Al-`Ula",
                "state_id" => 2851,
                "state_code" => "03",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.60853000",
                "longitude" => "37.92316000"
            ],
            [
                "id" => 102849,
                "name" => "Badr Ḩunayn",
                "state_id" => 2851,
                "state_code" => "03",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "23.78292000",
                "longitude" => "38.79047000"
            ],
            [
                "id" => 102865,
                "name" => "Medina",
                "state_id" => 2851,
                "state_code" => "03",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "24.46861000",
                "longitude" => "39.61417000"
            ],
            [
                "id" => 102879,
                "name" => "Sulţānah",
                "state_id" => 2851,
                "state_code" => "03",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "24.49258000",
                "longitude" => "39.58572000"
            ],
            [
                "id" => 102892,
                "name" => "Yanbu",
                "state_id" => 2851,
                "state_code" => "03",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "24.08954000",
                "longitude" => "38.06180000"
            ],
            [
                "id" => 102810,
                "name" => "Adh Dhibiyah",
                "state_id" => 2861,
                "state_code" => "05",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.02700000",
                "longitude" => "43.15700000"
            ],
            [
                "id" => 102817,
                "name" => "Al Bukayrīyah",
                "state_id" => 2861,
                "state_code" => "05",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.13915000",
                "longitude" => "43.65782000"
            ],
            [
                "id" => 102818,
                "name" => "Al Fuwayliq",
                "state_id" => 2861,
                "state_code" => "05",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.44360000",
                "longitude" => "43.25164000"
            ],
            [
                "id" => 102830,
                "name" => "Al Mithnab",
                "state_id" => 2861,
                "state_code" => "05",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.86012000",
                "longitude" => "44.22228000"
            ],
            [
                "id" => 102841,
                "name" => "Ar Rass",
                "state_id" => 2861,
                "state_code" => "05",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.86944000",
                "longitude" => "43.49730000"
            ],
            [
                "id" => 102850,
                "name" => "Buraydah",
                "state_id" => 2861,
                "state_code" => "05",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.32599000",
                "longitude" => "43.97497000"
            ],
            [
                "id" => 102883,
                "name" => "Tanūmah",
                "state_id" => 2861,
                "state_code" => "05",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "27.10000000",
                "longitude" => "44.13333000"
            ],
            [
                "id" => 102891,
                "name" => "Wed Alnkil",
                "state_id" => 2861,
                "state_code" => "05",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.42670000",
                "longitude" => "42.83430000"
            ],
            [
                "id" => 102805,
                "name" => "Abqaiq",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.93402000",
                "longitude" => "49.66880000"
            ],
            [
                "id" => 102814,
                "name" => "Al Awjām",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.56324000",
                "longitude" => "49.94331000"
            ],
            [
                "id" => 102816,
                "name" => "Al Baţţālīyah",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.43333000",
                "longitude" => "49.63333000"
            ],
            [
                "id" => 102820,
                "name" => "Al Hufūf",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.36467000",
                "longitude" => "49.58764000"
            ],
            [
                "id" => 102821,
                "name" => "Al Jafr",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.37736000",
                "longitude" => "49.72154000"
            ],
            [
                "id" => 102823,
                "name" => "Al Jubayl",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "27.01740000",
                "longitude" => "49.62251000"
            ],
            [
                "id" => 102825,
                "name" => "Al Khafjī",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "28.43905000",
                "longitude" => "48.49132000"
            ],
            [
                "id" => 102828,
                "name" => "Al Markaz",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.40000000",
                "longitude" => "49.73333000"
            ],
            [
                "id" => 102831,
                "name" => "Al Mubarraz",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.40768000",
                "longitude" => "49.59028000"
            ],
            [
                "id" => 102832,
                "name" => "Al Munayzilah",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.38333000",
                "longitude" => "49.66667000"
            ],
            [
                "id" => 102834,
                "name" => "Al Muţayrifī",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.47878000",
                "longitude" => "49.55824000"
            ],
            [
                "id" => 102837,
                "name" => "Al Qārah",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.41667000",
                "longitude" => "49.66667000"
            ],
            [
                "id" => 102835,
                "name" => "Al Qaţīf",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.56542000",
                "longitude" => "50.00890000"
            ],
            [
                "id" => 102836,
                "name" => "Al Qurayn",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.48333000",
                "longitude" => "49.60000000"
            ],
            [
                "id" => 102843,
                "name" => "As Saffānīyah",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "27.97083000",
                "longitude" => "48.73000000"
            ],
            [
                "id" => 102848,
                "name" => "Aţ Ţaraf",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.36232000",
                "longitude" => "49.72757000"
            ],
            [
                "id" => 102846,
                "name" => "At Tūbī",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.55778000",
                "longitude" => "49.99167000"
            ],
            [
                "id" => 102851,
                "name" => "Dammam",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.43442000",
                "longitude" => "50.10326000"
            ],
            [
                "id" => 102852,
                "name" => "Dhahran",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.28864000",
                "longitude" => "50.11396000"
            ],
            [
                "id" => 102857,
                "name" => "Hafar Al-Batin",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "28.43279000",
                "longitude" => "45.97077000"
            ],
            [
                "id" => 102860,
                "name" => "Julayjilah",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.50000000",
                "longitude" => "49.60000000"
            ],
            [
                "id" => 102862,
                "name" => "Khobar",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.27944000",
                "longitude" => "50.20833000"
            ],
            [
                "id" => 102868,
                "name" => "Mulayjah",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "27.27103000",
                "longitude" => "48.42419000"
            ],
            [
                "id" => 102870,
                "name" => "Qaisumah",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "28.31117000",
                "longitude" => "46.12729000"
            ],
            [
                "id" => 102873,
                "name" => "Raḩīmah",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.70791000",
                "longitude" => "50.06194000"
            ],
            [
                "id" => 102895,
                "name" => "Şafwá",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.64970000",
                "longitude" => "49.95522000"
            ],
            [
                "id" => 102878,
                "name" => "Sayhāt",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.48345000",
                "longitude" => "50.04849000"
            ],
            [
                "id" => 102888,
                "name" => "Tārūt",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.57330000",
                "longitude" => "50.04028000"
            ],
            [
                "id" => 102890,
                "name" => "Umm as Sāhik",
                "state_id" => 2856,
                "state_code" => "04",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.65361000",
                "longitude" => "49.91639000"
            ],
            [
                "id" => 102856,
                "name" => "Ha'il",
                "state_id" => 2855,
                "state_code" => "06",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "27.52188000",
                "longitude" => "41.69073000"
            ],
            [
                "id" => 102806,
                "name" => "Abū ‘Arīsh",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "16.96887000",
                "longitude" => "42.83251000"
            ],
            [
                "id" => 102807,
                "name" => "Ad Darb",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "17.72285000",
                "longitude" => "42.25261000"
            ],
            [
                "id" => 102822,
                "name" => "Al Jarādīyah",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "16.57946000",
                "longitude" => "42.91240000"
            ],
            [
                "id" => 102854,
                "name" => "Farasān",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "16.70222000",
                "longitude" => "42.11833000"
            ],
            [
                "id" => 102859,
                "name" => "Jizan",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "16.88917000",
                "longitude" => "42.55111000"
            ],
            [
                "id" => 102866,
                "name" => "Mislīyah",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "17.45988000",
                "longitude" => "42.55720000"
            ],
            [
                "id" => 102867,
                "name" => "Mizhirah",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "16.82611000",
                "longitude" => "42.73333000"
            ],
            [
                "id" => 102894,
                "name" => "Şabyā",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "17.14950000",
                "longitude" => "42.62537000"
            ],
            [
                "id" => 102897,
                "name" => "Şāmitah",
                "state_id" => 2858,
                "state_code" => "09",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "16.59601000",
                "longitude" => "42.94435000"
            ],
            [
                "id" => 102819,
                "name" => "Al Hadā",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "21.36753000",
                "longitude" => "40.28694000"
            ],
            [
                "id" => 102824,
                "name" => "Al Jumūm",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "21.61694000",
                "longitude" => "39.69806000"
            ],
            [
                "id" => 102833,
                "name" => "Al Muwayh",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "22.43333000",
                "longitude" => "41.75829000"
            ],
            [
                "id" => 102845,
                "name" => "Ash Shafā",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "21.07210000",
                "longitude" => "40.31185000"
            ],
            [
                "id" => 102855,
                "name" => "Ghran",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "21.98027000",
                "longitude" => "39.36521000"
            ],
            [
                "id" => 102858,
                "name" => "Jeddah",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "21.54238000",
                "longitude" => "39.19797000"
            ],
            [
                "id" => 102864,
                "name" => "Mecca",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "21.42664000",
                "longitude" => "39.82563000"
            ],
            [
                "id" => 102875,
                "name" => "Rābigh",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "22.79856000",
                "longitude" => "39.03493000"
            ],
            [
                "id" => 102884,
                "name" => "Ta’if",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "21.27028000",
                "longitude" => "40.41583000"
            ],
            [
                "id" => 102886,
                "name" => "Turabah",
                "state_id" => 2850,
                "state_code" => "02",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "21.21406000",
                "longitude" => "41.63310000"
            ],
            [
                "id" => 102869,
                "name" => "Najrān",
                "state_id" => 2860,
                "state_code" => "10",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "17.49326000",
                "longitude" => "44.12766000"
            ],
            [
                "id" => 102842,
                "name" => "Arar",
                "state_id" => 2854,
                "state_code" => "08",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "30.97531000",
                "longitude" => "41.03808000"
            ],
            [
                "id" => 102887,
                "name" => "Turaif",
                "state_id" => 2854,
                "state_code" => "08",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "31.67252000",
                "longitude" => "38.66374000"
            ],
            [
                "id" => 102808,
                "name" => "Ad Dawādimī",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "24.50772000",
                "longitude" => "44.39237000"
            ],
            [
                "id" => 102809,
                "name" => "Ad Dilam",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "23.99104000",
                "longitude" => "47.16181000"
            ],
            [
                "id" => 102811,
                "name" => "Afif",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "23.90650000",
                "longitude" => "42.91724000"
            ],
            [
                "id" => 102812,
                "name" => "Ain AlBaraha",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "24.75806000",
                "longitude" => "43.77389000"
            ],
            [
                "id" => 102813,
                "name" => "Al Arţāwīyah",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.50387000",
                "longitude" => "45.34813000"
            ],
            [
                "id" => 102826,
                "name" => "Al Kharj",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "24.15541000",
                "longitude" => "47.33457000"
            ],
            [
                "id" => 102844,
                "name" => "As Sulayyil",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "20.46067000",
                "longitude" => "45.57792000"
            ],
            [
                "id" => 102847,
                "name" => "Az Zulfī",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.29945000",
                "longitude" => "44.81542000"
            ],
            [
                "id" => 102863,
                "name" => "Marāt",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.07064000",
                "longitude" => "45.45775000"
            ],
            [
                "id" => 102874,
                "name" => "Riyadh",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "24.68773000",
                "longitude" => "46.72185000"
            ],
            [
                "id" => 102880,
                "name" => "Sājir",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.18251000",
                "longitude" => "44.59964000"
            ],
            [
                "id" => 102893,
                "name" => "shokhaibٍ",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "24.49023000",
                "longitude" => "46.26871000"
            ],
            [
                "id" => 102885,
                "name" => "Tumayr",
                "state_id" => 2849,
                "state_code" => "01",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.70347000",
                "longitude" => "45.86835000"
            ],
            [
                "id" => 102838,
                "name" => "Al Wajh",
                "state_id" => 2852,
                "state_code" => "07",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "26.24551000",
                "longitude" => "36.45249000"
            ],
            [
                "id" => 102853,
                "name" => "Duba",
                "state_id" => 2852,
                "state_code" => "07",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "27.35134000",
                "longitude" => "35.69014000"
            ],
            [
                "id" => 102881,
                "name" => "Tabuk",
                "state_id" => 2852,
                "state_code" => "07",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "28.39980000",
                "longitude" => "36.57151000"
            ],
            [
                "id" => 102889,
                "name" => "Umm Lajj",
                "state_id" => 2852,
                "state_code" => "07",
                "country_id" => 194,
                "country_code" => "SA",
                "latitude" => "25.02126000",
                "longitude" => "37.26850000"
            ],
            [
                "id" => 104704,
                "name" => "Dakar",
                "state_id" => 473,
                "state_code" => "DK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.69370000",
                "longitude" => "-17.44406000"
            ],
            [
                "id" => 104705,
                "name" => "Dakar Department",
                "state_id" => 473,
                "state_code" => "DK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.71403000",
                "longitude" => "-17.45534000"
            ],
            [
                "id" => 104716,
                "name" => "Guédiawaye Department",
                "state_id" => 473,
                "state_code" => "DK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.77610000",
                "longitude" => "-17.39560000"
            ],
            [
                "id" => 104737,
                "name" => "Mermoz Boabab",
                "state_id" => 473,
                "state_code" => "DK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.70649000",
                "longitude" => "-17.47581000"
            ],
            [
                "id" => 104744,
                "name" => "N’diareme limamoulaye",
                "state_id" => 473,
                "state_code" => "DK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.78148000",
                "longitude" => "-17.38410000"
            ],
            [
                "id" => 104748,
                "name" => "Pikine",
                "state_id" => 473,
                "state_code" => "DK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.76457000",
                "longitude" => "-17.39071000"
            ],
            [
                "id" => 104749,
                "name" => "Pikine Department",
                "state_id" => 473,
                "state_code" => "DK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.76515000",
                "longitude" => "-17.35198000"
            ],
            [
                "id" => 104756,
                "name" => "Rufisque Department",
                "state_id" => 473,
                "state_code" => "DK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.74339000",
                "longitude" => "-17.19841000"
            ],
            [
                "id" => 104734,
                "name" => "Mbacké",
                "state_id" => 480,
                "state_code" => "DB",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.80828000",
                "longitude" => "-15.86454000"
            ],
            [
                "id" => 104735,
                "name" => "Mbaké",
                "state_id" => 480,
                "state_code" => "DB",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.79032000",
                "longitude" => "-15.90803000"
            ],
            [
                "id" => 104769,
                "name" => "Tiébo",
                "state_id" => 480,
                "state_code" => "DB",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.63333000",
                "longitude" => "-16.23333000"
            ],
            [
                "id" => 104770,
                "name" => "Touba",
                "state_id" => 480,
                "state_code" => "DB",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.85000000",
                "longitude" => "-15.88333000"
            ],
            [
                "id" => 104708,
                "name" => "Diofior",
                "state_id" => 479,
                "state_code" => "FK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.18333000",
                "longitude" => "-16.66667000"
            ],
            [
                "id" => 104710,
                "name" => "Fatick Department",
                "state_id" => 479,
                "state_code" => "FK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.25909000",
                "longitude" => "-16.49884000"
            ],
            [
                "id" => 104711,
                "name" => "Foundiougne",
                "state_id" => 479,
                "state_code" => "FK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.13333000",
                "longitude" => "-16.46667000"
            ],
            [
                "id" => 104715,
                "name" => "Guinguinéo",
                "state_id" => 479,
                "state_code" => "FK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.26667000",
                "longitude" => "-15.95000000"
            ],
            [
                "id" => 104747,
                "name" => "Passi",
                "state_id" => 479,
                "state_code" => "FK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.98333000",
                "longitude" => "-16.26667000"
            ],
            [
                "id" => 104751,
                "name" => "Pourham",
                "state_id" => 479,
                "state_code" => "FK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.35000000",
                "longitude" => "-16.41667000"
            ],
            [
                "id" => 104759,
                "name" => "Sokone",
                "state_id" => 479,
                "state_code" => "FK",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.88333000",
                "longitude" => "-16.36667000"
            ],
            [
                "id" => 104719,
                "name" => "Kaffrine",
                "state_id" => 475,
                "state_code" => "KA",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.10594000",
                "longitude" => "-15.55080000"
            ],
            [
                "id" => 104726,
                "name" => "Koungheul",
                "state_id" => 475,
                "state_code" => "KA",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.98333000",
                "longitude" => "-14.80000000"
            ],
            [
                "id" => 104712,
                "name" => "Gandiaye",
                "state_id" => 483,
                "state_code" => "KL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.23333000",
                "longitude" => "-16.26667000"
            ],
            [
                "id" => 104721,
                "name" => "Kaolack",
                "state_id" => 483,
                "state_code" => "KL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "14.15197000",
                "longitude" => "-16.07259000"
            ],
            [
                "id" => 104741,
                "name" => "Ndofane",
                "state_id" => 483,
                "state_code" => "KL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.91667000",
                "longitude" => "-15.93333000"
            ],
            [
                "id" => 104743,
                "name" => "Nioro du Rip",
                "state_id" => 483,
                "state_code" => "KL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.75000000",
                "longitude" => "-15.80000000"
            ],
            [
                "id" => 104709,
                "name" => "Département de Salémata",
                "state_id" => 481,
                "state_code" => "KE",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "12.59971000",
                "longitude" => "-12.77619000"
            ],
            [
                "id" => 104727,
                "name" => "Kédougou",
                "state_id" => 481,
                "state_code" => "KE",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "12.55561000",
                "longitude" => "-12.18076000"
            ],
            [
                "id" => 104728,
                "name" => "Kédougou Department",
                "state_id" => 481,
                "state_code" => "KE",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "12.81716000",
                "longitude" => "-12.17834000"
            ],
            [
                "id" => 104758,
                "name" => "Saraya",
                "state_id" => 481,
                "state_code" => "KE",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.00150000",
                "longitude" => "-11.79627000"
            ],
            [
                "id" => 104724,
                "name" => "Kolda",
                "state_id" => 474,
                "state_code" => "KD",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "12.89390000",
                "longitude" => "-14.94125000"
            ],
            [
                "id" => 104725,
                "name" => "Kolda Department",
                "state_id" => 474,
                "state_code" => "KD",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "12.88300000",
                "longitude" => "-14.95000000"
            ],
            [
                "id" => 104731,
                "name" => "Marsassoum",
                "state_id" => 474,
                "state_code" => "KD",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "12.82750000",
                "longitude" => "-15.98056000"
            ],
            [
                "id" => 104771,
                "name" => "Vélingara",
                "state_id" => 474,
                "state_code" => "KD",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.15000000",
                "longitude" => "-14.11667000"
            ],
            [
                "id" => 104706,
                "name" => "Dara",
                "state_id" => 485,
                "state_code" => "LG",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.34844000",
                "longitude" => "-15.47993000"
            ],
            [
                "id" => 104717,
                "name" => "Guéoul",
                "state_id" => 485,
                "state_code" => "LG",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.48333000",
                "longitude" => "-16.35000000"
            ],
            [
                "id" => 104729,
                "name" => "Linguere Department",
                "state_id" => 485,
                "state_code" => "LG",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.35900000",
                "longitude" => "-15.15800000"
            ],
            [
                "id" => 104730,
                "name" => "Louga",
                "state_id" => 485,
                "state_code" => "LG",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.61867000",
                "longitude" => "-16.22436000"
            ],
            [
                "id" => 104739,
                "name" => "Ndibène Dahra",
                "state_id" => 485,
                "state_code" => "LG",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.33380000",
                "longitude" => "-15.47660000"
            ],
            [
                "id" => 104707,
                "name" => "Diawara",
                "state_id" => 476,
                "state_code" => "MT",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.02196000",
                "longitude" => "-12.54374000"
            ],
            [
                "id" => 104720,
                "name" => "Kanel",
                "state_id" => 476,
                "state_code" => "MT",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.49160000",
                "longitude" => "-13.17627000"
            ],
            [
                "id" => 104732,
                "name" => "Matam",
                "state_id" => 476,
                "state_code" => "MT",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.65587000",
                "longitude" => "-13.25544000"
            ],
            [
                "id" => 104733,
                "name" => "Matam Department",
                "state_id" => 476,
                "state_code" => "MT",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.73191000",
                "longitude" => "-13.63393000"
            ],
            [
                "id" => 104745,
                "name" => "Ouro Sogui",
                "state_id" => 476,
                "state_code" => "MT",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.60588000",
                "longitude" => "-13.32230000"
            ],
            [
                "id" => 104753,
                "name" => "Ranérou",
                "state_id" => 476,
                "state_code" => "MT",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.30000000",
                "longitude" => "-13.96667000"
            ],
            [
                "id" => 104761,
                "name" => "Sémé",
                "state_id" => 476,
                "state_code" => "MT",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.19422000",
                "longitude" => "-12.94482000"
            ],
            [
                "id" => 104772,
                "name" => "Waoundé",
                "state_id" => 476,
                "state_code" => "MT",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.26367000",
                "longitude" => "-12.86821000"
            ],
            [
                "id" => 104713,
                "name" => "Goléré",
                "state_id" => 477,
                "state_code" => "SL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "16.25575000",
                "longitude" => "-14.10165000"
            ],
            [
                "id" => 104740,
                "name" => "Ndioum",
                "state_id" => 477,
                "state_code" => "SL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "16.51293000",
                "longitude" => "-14.64706000"
            ],
            [
                "id" => 104750,
                "name" => "Polel Diaoubé",
                "state_id" => 477,
                "state_code" => "SL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "15.26667000",
                "longitude" => "-13.00000000"
            ],
            [
                "id" => 104754,
                "name" => "Richard-Toll",
                "state_id" => 477,
                "state_code" => "SL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "16.46250000",
                "longitude" => "-15.70083000"
            ],
            [
                "id" => 104755,
                "name" => "Rosso",
                "state_id" => 477,
                "state_code" => "SL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "16.42028000",
                "longitude" => "-15.79834000"
            ],
            [
                "id" => 104757,
                "name" => "Saint-Louis",
                "state_id" => 477,
                "state_code" => "SL",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "16.01793000",
                "longitude" => "-16.48962000"
            ],
            [
                "id" => 104714,
                "name" => "Goudomp Department",
                "state_id" => 482,
                "state_code" => "SE",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "12.57778000",
                "longitude" => "-15.87222000"
            ],
            [
                "id" => 104760,
                "name" => "Sédhiou",
                "state_id" => 482,
                "state_code" => "SE",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "12.70806000",
                "longitude" => "-15.55694000"
            ],
            [
                "id" => 104762,
                "name" => "Tambacounda",
                "state_id" => 486,
                "state_code" => "TC",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.77073000",
                "longitude" => "-13.66734000"
            ],
            [
                "id" => 104763,
                "name" => "Tambacounda Department",
                "state_id" => 486,
                "state_code" => "TC",
                "country_id" => 195,
                "country_code" => "SN",
                "latitude" => "13.60500000",
                "longitude" => "-13.64700000"
            ],
        ];

        foreach ($cities as $city)
        {
           $city_check = City::where('id', $city['id'])->first();
            if(!$city_check){
                City::create([
                   'id' => $city['id'],
                   'is_active' => 1,
                   'state_id' => $city['state_id'],
                   'country_id' => $city['country_id'],
                   'ar'  => ['name' => $city['name']],
                   'en'  => ['name' => $city['name']],
               ]);
            }
               
       }
    }
}
