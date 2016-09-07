<?php

use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nationalities = [
            [
                'name'     => 'سعودي',
                'eng_name' => 'Saudi',
            ],
            [
                'name'     => 'فلسطيني بوثيقة مصرية',
                'eng_name' => 'Palestine Eg paper',
            ],
            [
                'name'     => 'فلسطيني بوثيقة لبناني',
                'eng_name' => 'Palestine LB Paper',
            ],
            [
                'name'     => 'فلسطيني بوثيقة اردنية',
                'eng_name' => 'Palestine AU Paper',
            ],
            [
                'name'     => 'فلسطيني بوثيقة عراقية',
                'eng_name' => 'Palestine IR Paper',
            ],
            [
                'name'     => 'فلسطيني بوثيقة سوربة',
                'eng_name' => 'Palestine SR Paper',
            ],
            [
                'name'     => 'تيمور الشرقية',
                'eng_name' => 'West Taimor',
            ],
            [
                'name'     => 'أفريقيا الوسطى',
                'eng_name' => 'Middle Africa',
            ],
            [
                'name'     => 'جزر سيشل',
                'eng_name' => 'Sessiel islands',
            ],
            [
                'name'     => 'بوفثاتسواني',
                'eng_name' => 'Bofthatsonya',
            ],
            [
                'name'     => 'رينيون',
                'eng_name' => 'Renion',
            ],
            [
                'name'     => 'سانت هيلانة',
                'eng_name' => 'Sant Helanh',
            ],
            [
                'name'     => 'جزيرة مايوت',
                'eng_name' => 'Mayot Island',
            ],
            [
                'name'     => 'إماراتي',
                'eng_name' => 'UAE',
            ],
            [
                'name'     => 'بحريني',
                'eng_name' => 'Bahraini',
            ],
            [
                'name'     => 'عماني',
                'eng_name' => 'OmanI',
            ],
            [
                'name'     => 'قطرى',
                'eng_name' => 'QATARI',
            ],
            [
                'name'     => 'كويتي',
                'eng_name' => 'Kuwaiti',
            ],
            [
                'name'     => 'مقيم',
                'eng_name' => 'Resident',
            ],
            [
                'name'     => 'أردني',
                'eng_name' => 'Jordanian',
            ],
            [
                'name'     => 'تونسي',
                'eng_name' => 'Tunisian',
            ],
            [
                'name'     => 'جزائري',
                'eng_name' => 'Algerian',
            ],
            [
                'name'     => 'جزر القمر',
                'eng_name' => 'Comoros',
            ],
            [
                'name'     => 'جيبوتي',
                'eng_name' => 'Djibouti',
            ],
            [
                'name'     => 'سوداني',
                'eng_name' => 'Sudanese',
            ],
            [
                'name'     => 'سوري',
                'eng_name' => 'Syrian',
            ],
            [
                'name'     => 'صومالي',
                'eng_name' => 'Somali',
            ],
            [
                'name'     => 'عراقي',
                'eng_name' => 'Iraqi',
            ],
            [
                'name'     => 'فلسطيني',
                'eng_name' => 'Palestinian',
            ],
            [
                'name'     => 'لبناني',
                'eng_name' => 'Lebanese',
            ],
            [
                'name'     => 'ليبي',
                'eng_name' => 'Libby',
            ],
            [
                'name'     => 'مصري',
                'eng_name' => 'EGYPTIAN',
            ],
            [
                'name'     => 'مغربي',
                'eng_name' => 'Moroccan',
            ],
            [
                'name'     => 'موريتاني',
                'eng_name' => 'Mauritanian',
            ],
            [
                'name'     => 'يمني',
                'eng_name' => 'Yemeni',
            ],
            [
                'name'     => 'اذربيجاني',
                'eng_name' => 'Azeri',
            ],
            [
                'name'     => 'اريتيري',
                'eng_name' => 'Eritrean',
            ],
            [
                'name'     => 'أفغانستاني',
                'eng_name' => 'Ofganstani',
            ],
            [
                'name'     => 'ألباني',
                'eng_name' => 'Albanian',
            ],
            [
                'name'     => 'أندونيسي',
                'eng_name' => 'Indonesian',
            ],
            [
                'name'     => 'أوزبكستاني',
                'eng_name' => 'Uzbek',
            ],
            [
                'name'     => 'إيراني',
                'eng_name' => 'Iranian',
            ],
            [
                'name'     => 'باكستاني',
                'eng_name' => 'Pakistani',
            ],
            [
                'name'     => 'برونايي',
                'eng_name' => 'Prunaie',
            ],
            [
                'name'     => 'بنجلادشي',
                'eng_name' => 'Bengali',
            ],
            [
                'name'     => 'بوسني',
                'eng_name' => 'Bosnian',
            ],
            [
                'name'     => 'تركمانستاني',
                'eng_name' => 'Turkmenstani',
            ],
            [
                'name'     => 'تركى',
                'eng_name' => 'Turkish',
            ],
            [
                'name'     => 'تشادي',
                'eng_name' => 'Chadian',
            ],
            [
                'name'     => 'تنزاني',
                'eng_name' => 'Tanzanian',
            ],
            [
                'name'     => 'جزر الملاديف',
                'eng_name' => 'Maldivian',
            ],
            [
                'name'     => 'سنغالي',
                'eng_name' => 'Senegalese',
            ],
            [
                'name'     => 'طاجاكستاني',
                'eng_name' => 'Tajackstani',
            ],
            [
                'name'     => 'غيني',
                'eng_name' => 'Guinean',
            ],
            [
                'name'     => 'قازاخستاني',
                'eng_name' => 'Khazakistany',
            ],
            [
                'name'     => 'قرعيزي',
                'eng_name' => 'Kyrgyzstan',
            ],
            [
                'name'     => 'مالي',
                'eng_name' => 'Mali',
            ],
            [
                'name'     => 'ماليزي',
                'eng_name' => 'Malaysian',
            ],
            [
                'name'     => 'نيجري',
                'eng_name' => 'Naigri',
            ],
            [
                'name'     => 'نيجري',
                'eng_name' => 'Nigerian',
            ],
            [
                'name'     => 'اتحاد ماينمار',
                'eng_name' => 'Union of Myanmar',
            ],
            [
                'name'     => 'تايلاندي',
                'eng_name' => 'Thai',
            ],
            [
                'name'     => 'سنغافوري',
                'eng_name' => 'Singapore',
            ],
            [
                'name'     => 'سيريلانكي',
                'eng_name' => 'Sri Lankan',
            ],
            [
                'name'     => 'الصين الشعبية',
                'eng_name' => 'chinese',
            ],
            [
                'name'     => 'الصين الوطنية',
                'eng_name' => 'chinese',
            ],
            [
                'name'     => 'فلبيني',
                'eng_name' => 'Filipino',
            ],
            [
                'name'     => 'فياتنامي',
                'eng_name' => 'Vietnamese',
            ],
            [
                'name'     => 'قبرصي',
                'eng_name' => 'Cyprus',
            ],
            [
                'name'     => 'كمبودي',
                'eng_name' => 'Cambodian',
            ],
            [
                'name'     => 'كوري جنوبي',
                'eng_name' => 'South Korean',
            ],
            [
                'name'     => 'كوري شمالي',
                'eng_name' => 'North Korean',
            ],
            [
                'name'     => 'لاوسي',
                'eng_name' => 'Laose',
            ],
            [
                'name'     => 'منغولي',
                'eng_name' => 'Mongo',
            ],
            [
                'name'     => 'نيبالي',
                'eng_name' => 'Nepalese',
            ],
            [
                'name'     => 'هندي',
                'eng_name' => 'Indian',
            ],
            [
                'name'     => 'ياباني',
                'eng_name' => 'Japanese',
            ],
            [
                'name'     => 'كاميروني',
                'eng_name' => 'Cameroon',
            ],
            [
                'name'     => 'أنقولي',
                'eng_name' => 'Onicoli',
            ],
            [
                'name'     => 'أوغندي',
                'eng_name' => 'Ugandan',
            ],
            [
                'name'     => 'بنيني',
                'eng_name' => 'Benin',
            ],
            [
                'name'     => 'بوتسواني',
                'eng_name' => 'Botswana',
            ],
            [
                'name'     => 'بورندي',
                'eng_name' => 'Burundi',
            ],
            [
                'name'     => 'توجوي',
                'eng_name' => 'Tojoi',
            ],
            [
                'name'     => 'جابوني',
                'eng_name' => 'Jaboni',
            ],
            [
                'name'     => 'جامبي',
                'eng_name' => 'Jambi',
            ],
            [
                'name'     => 'جزر الرأس الأخضر',
                'eng_name' => 'Cape Verde',
            ],
            [
                'name'     => 'جزر الكناري',
                'eng_name' => 'Canary Islands',
            ],
            [
                'name'     => 'جنوب أفريقي',
                'eng_name' => 'South African',
            ],
            [
                'name'     => 'رواندي',
                'eng_name' => 'Rwandan',
            ],
            [
                'name'     => 'زائيري',
                'eng_name' => 'Zairian',
            ],
            [
                'name'     => 'زامبي',
                'eng_name' => 'Zambian',
            ],
            [
                'name'     => 'زمبابوي',
                'eng_name' => 'Zimbabwe',
            ],
            [
                'name'     => 'ساحل العاج',
                'eng_name' => 'Ivory Coast',
            ],
            [
                'name'     => 'ساوتومي وبرنسيبي',
                'eng_name' => 'Sao Tome and Principe',
            ],
            [
                'name'     => 'سوزاي لاند',
                'eng_name' => 'Sozai Land',
            ],
            [
                'name'     => 'سيراليوني',
                'eng_name' => 'Sierra Leonean',
            ],
            [
                'name'     => 'سيشلي',
                'eng_name' => 'Sihley',
            ],
            [
                'name'     => 'غاني',
                'eng_name' => 'Gani',
            ],
            [
                'name'     => 'غينيا الإستوائية',
                'eng_name' => 'Equatorial Guinea',
            ],
            [
                'name'     => 'غينيا بيساو',
                'eng_name' => 'Guinea-Bissau',
            ],
            [
                'name'     => 'كونغوي',
                'eng_name' => 'Congolese',
            ],
            [
                'name'     => 'كيني',
                'eng_name' => 'Kenny',
            ],
            [
                'name'     => 'لوسوتوي',
                'eng_name' => 'To Osuthui',
            ],
            [
                'name'     => 'ليبيري',
                'eng_name' => 'Liberian',
            ],
            [
                'name'     => 'مالاوي',
                'eng_name' => 'Malawi',
            ],
            [
                'name'     => 'مدغشقري',
                'eng_name' => 'Malagasy',
            ],
            [
                'name'     => 'موريشيوسي',
                'eng_name' => 'Myryciossi',
            ],
            [
                'name'     => 'موزمبيقي',
                'eng_name' => 'Mozambicans',
            ],
            [
                'name'     => 'ناميبي',
                'eng_name' => 'Nambian',
            ],
            [
                'name'     => 'أثيوبي',
                'eng_name' => 'Ethiopian',
            ],
            [
                'name'     => 'أرجنتيني',
                'eng_name' => 'Argentine',
            ],
            [
                'name'     => 'أروجوايي',
                'eng_name' => 'Orojuwaye',
            ],
            [
                'name'     => 'إكوادوري',
                'eng_name' => 'Ecuadorian',
            ],
            [
                'name'     => 'باريادوسي',
                'eng_name' => 'Arriedosi',
            ],
            [
                'name'     => 'برازيلي',
                'eng_name' => 'Brazilian',
            ],
            [
                'name'     => 'براغويي',
                'eng_name' => 'Bragoye',
            ],
            [
                'name'     => 'بورتوريكوي',
                'eng_name' => 'Portorikoi',
            ],
            [
                'name'     => 'بنمي',
                'eng_name' => 'Panamanian',
            ],
            [
                'name'     => 'بوليفي',
                'eng_name' => 'Bolivian',
            ],
            [
                'name'     => 'بيروي',
                'eng_name' => 'Peruvian',
            ],
            [
                'name'     => 'بليزي',
                'eng_name' => 'BZ',
            ],
            [
                'name'     => 'ترينيداد وتوباجوي',
                'eng_name' => 'Trinidad and Topajui',
            ],
            [
                'name'     => 'تشيلي',
                'eng_name' => 'Chile',
            ],
            [
                'name'     => 'جامايكي',
                'eng_name' => 'Jamaican',
            ],
            [
                'name'     => 'جريناداي',
                'eng_name' => 'Jrenadai',
            ],
            [
                'name'     => 'جزر البهما',
                'eng_name' => 'Islands Albhma',
            ],
            [
                'name'     => 'جواتيمالي',
                'eng_name' => 'Vest',
            ],
            [
                'name'     => 'جياني',
                'eng_name' => 'Gianni',
            ],
            [
                'name'     => 'دومونيكاتي',
                'eng_name' => 'Domonicati',
            ],
            [
                'name'     => 'سلفادوري',
                'eng_name' => 'Salvadoran',
            ],
            [
                'name'     => 'سورينامي',
                'eng_name' => 'Surinamese',
            ],
            [
                'name'     => 'فنزويلي',
                'eng_name' => 'Venezuelan',
            ],
            [
                'name'     => 'كندي',
                'eng_name' => 'Canadian',
            ],
            [
                'name'     => 'كوبي',
                'eng_name' => 'Kobe',
            ],
            [
                'name'     => 'كوستاريكي',
                'eng_name' => 'Costa Rican',
            ],
            [
                'name'     => 'كولومبي',
                'eng_name' => 'Colombian',
            ],
            [
                'name'     => 'مكسيكي',
                'eng_name' => 'Mexican',
            ],
            [
                'name'     => 'نيكاراجوي',
                'eng_name' => 'Nekarajoi',
            ],
            [
                'name'     => 'هندوراسي',
                'eng_name' => 'Honduran',
            ],
            [
                'name'     => 'أمريكي',
                'eng_name' => 'American',
            ],
            [
                'name'     => 'إيرلندي',
                'eng_name' => 'Irish',
            ],
            [
                'name'     => 'أرميني',
                'eng_name' => 'Armenian',
            ],
            [
                'name'     => 'أسباني',
                'eng_name' => 'Spanish',
            ],
            [
                'name'     => 'أستوني',
                'eng_name' => 'Estonian',
            ],
            [
                'name'     => 'ألماني',
                'eng_name' => 'German',
            ],
            [
                'name'     => 'أوكراني',
                'eng_name' => 'Ukrainian',
            ],
            [
                'name'     => 'ايسلندي',
                'eng_name' => 'Icelandic',
            ],
            [
                'name'     => 'ايطالي',
                'eng_name' => 'Italian',
            ],
            [
                'name'     => 'برتغالي',
                'eng_name' => 'Portuguese',
            ],
            [
                'name'     => 'بريطاني',
                'eng_name' => 'British',
            ],
            [
                'name'     => 'بلجيكي',
                'eng_name' => 'Belgian',
            ],
            [
                'name'     => 'بلغاري',
                'eng_name' => 'Bulgarian',
            ],
            [
                'name'     => 'بولندي',
                'eng_name' => 'Polish',
            ],
            [
                'name'     => 'تشيكي',
                'eng_name' => 'Czech',
            ],
            [
                'name'     => 'جورجي',
                'eng_name' => 'Georgi',
            ],
            [
                'name'     => 'دانماركي',
                'eng_name' => 'Danish',
            ],
            [
                'name'     => 'روسي',
                'eng_name' => 'Russian',
            ],
            [
                'name'     => 'روسيا البيضاء',
                'eng_name' => 'Byelorussian',
            ],
            [
                'name'     => 'روماني',
                'eng_name' => 'Romanian',
            ],
            [
                'name'     => 'سلوفاكي',
                'eng_name' => 'Slovak',
            ],
            [
                'name'     => 'سلوفيني',
                'eng_name' => 'Slovenian',
            ],
            [
                'name'     => 'سويدي',
                'eng_name' => 'Swedish',
            ],
            [
                'name'     => 'سويسري',
                'eng_name' => 'swiss',
            ],
            [
                'name'     => 'فاتيكاني',
                'eng_name' => 'Fatykani',
            ],
            [
                'name'     => 'فرنسي',
                'eng_name' => 'French',
            ],
            [
                'name'     => 'فنلندي',
                'eng_name' => 'Finnish',
            ],
            [
                'name'     => 'كرواتي',
                'eng_name' => 'Croatian',
            ],
            [
                'name'     => 'لاتفي',
                'eng_name' => 'lativian',
            ],
            [
                'name'     => 'ليتواني',
                'eng_name' => 'Lithuanian',
            ],
            [
                'name'     => 'لكسمبورجي',
                'eng_name' => 'To Kasmborgi',
            ],
            [
                'name'     => 'مولدافي',
                'eng_name' => 'Moldovan',
            ],
            [
                'name'     => 'نرويجي',
                'eng_name' => 'Norwegian',
            ],
            [
                'name'     => 'نمساوي',
                'eng_name' => 'Austrian',
            ],
            [
                'name'     => 'هنغاري',
                'eng_name' => 'Hungarian',
            ],
            [
                'name'     => 'هولندي',
                'eng_name' => 'Dutch',
            ],
            [
                'name'     => 'يوناني',
                'eng_name' => 'Greek',
            ],
            [
                'name'     => 'يوغسلافيا',
                'eng_name' => 'Yugoslav',
            ],
            [
                'name'     => 'أسترالي',
                'eng_name' => 'Australian',
            ],
            [
                'name'     => 'بوثاني',
                'eng_name' => 'Bozani',
            ],
            [
                'name'     => 'تونجي',
                'eng_name' => 'Tongyi',
            ],
            [
                'name'     => 'جزر السولومون',
                'eng_name' => 'a Solomon Islander',
            ],
            [
                'name'     => 'غرب ساموا',
                'eng_name' => 'West Samoa',
            ],
            [
                'name'     => 'غينيا الجديدة',
                'eng_name' => 'New Guinean',
            ],
            [
                'name'     => 'جزر فيجي',
                'eng_name' => 'Fiji',
            ],
            [
                'name'     => 'نيوزلندي',
                'eng_name' => 'a New Zealander',
            ],
            [
                'name'     => 'تركستاني',
                'eng_name' => 'Turkestani',
            ],
            [
                'name'     => 'مالطي',
                'eng_name' => 'Maltese',
            ],
            [
                'name'     => 'برناوي',
                'eng_name' => 'Bernawi',
            ],
            [
                'name'     => 'مقيم بلوشي',
                'eng_name' => 'Bloushi',
            ],
            [
                'name'     => 'المجر',
                'eng_name' => 'Hungarian',
            ],
            [
                'name'     => 'تايوان',
                'eng_name' => 'Taiwanese',
            ],
            [
                'name'     => 'كازاخستان',
                'eng_name' => 'Kazakh',
            ],
            [
                'name'     => 'مقدوني',
                'eng_name' => 'Macedonian',
            ],
            [
                'name'     => 'بوركينافاسو',
                'eng_name' => 'Borkeinafaso',
            ],
            [
                'name'     => 'صربيا',
                'eng_name' => 'Serbia',
            ],
            [
                'name'     => 'اندورا',
                'eng_name' => 'Endora',
            ],
            [
                'name'     => 'الجبل الاسود',
                'eng_name' => 'Dark Mountain',
            ],
            [
                'name'     => 'جمهورية جنوب السودان',
                'eng_name' => 'South Sudan',
            ],
            [
                'name'     => 'ليختنشتين',
                'eng_name' => 'Lekhtnshen',
            ],
            [
                'name'     => 'موناكو',
                'eng_name' => 'Moncao',
            ],
            [
                'name'     => 'سان مورينو',
                'eng_name' => 'San moreno',
            ],
            [
                'name'     => 'جبل طارق',
                'eng_name' => 'Tarek Mountain',
            ],
            [
                'name'     => 'صربيا و الجبل الأسود',
                'eng_name' => 'Serbia',
            ],
            [
                'name'     => 'كوسوفوا',
                'eng_name' => 'Cosovo',
            ],
            [
                'name'     => 'جزر فيرو',
                'eng_name' => 'Vero Islands',
            ],
            [
                'name'     => 'جوانا',
                'eng_name' => 'Goana',
            ],
            [
                'name'     => 'جمهورية دمينكان',
                'eng_name' => 'Dominician',
            ],
            [
                'name'     => 'هايتي',
                'eng_name' => 'Hayeti',
            ],
            [
                'name'     => 'سانت لوسيا',
                'eng_name' => 'Sant Losia',
            ],
            [
                'name'     => 'سان فينسنت',
                'eng_name' => 'San Fensnt',
            ],
            [
                'name'     => ' بييري و ميكويلن',
                'eng_name' => 'Berry & mekweln',
            ],
            [
                'name'     => 'جرينلاند',
                'eng_name' => 'Gretland',
            ],
            [
                'name'     => 'بيرمودا',
                'eng_name' => 'Bermoda',
            ],
            [
                'name'     => 'جزر الترك و القوقاز',
                'eng_name' => 'Turk & Qoqaz Islands',
            ],
            [
                'name'     => 'انجويلا',
                'eng_name' => 'Angoila',
            ],
            [
                'name'     => 'جزر فيرجن البريطانية',
                'eng_name' => 'British version Islands',
            ],
            [
                'name'     => 'جزر كايمون',
                'eng_name' => 'Kaemon Islands',
            ],
            [
                'name'     => 'مونت سيرات',
                'eng_name' => 'Mont Cerat',
            ],
            [
                'name'     => 'جيودي لوب',
                'eng_name' => 'GeodyLop',
            ],
            [
                'name'     => 'مارتينيكو',
                'eng_name' => 'Martiniko',
            ],
            [
                'name'     => 'عروبا',
                'eng_name' => 'Arobia',
            ],
            [
                'name'     => 'جزر فيرجن الامريكية',
                'eng_name' => 'American version islands',
            ],
            [
                'name'     => 'جزر فاكلاند',
                'eng_name' => 'Fakland islands',
            ],
            [
                'name'     => 'جزر كوك',
                'eng_name' => 'Kok Islands',
            ],
            [
                'name'     => 'باربودا',
                'eng_name' => 'Barboda',
            ],
            [
                'name'     => 'هونج كونج',
                'eng_name' => 'HongKong',
            ],
            [
                'name'     => 'نيو',
                'eng_name' => 'NIO',
            ],
            [
                'name'     => 'انتاركتيكا',
                'eng_name' => 'Intarktica',
            ],
            [
                'name'     => 'جزر نورفولك',
                'eng_name' => 'Norvolk Islands',
            ],
            [
                'name'     => 'توكيلاو',
                'eng_name' => 'Tokelao',
            ],
            [
                'name'     => 'جزيرة كريسماس',
                'eng_name' => 'Chrismas Islands',
            ],
            [
                'name'     => 'بهوتاني',
                'eng_name' => 'Bahoaty',
            ],
            [
                'name'     => 'كيريباتي',
                'eng_name' => 'Kerebiaty',
            ],
            [
                'name'     => 'نورو',
                'eng_name' => 'Noro',
            ],
            [
                'name'     => 'ماكاوي',
                'eng_name' => 'Macay',
            ],
            [
                'name'     => 'توفالو',
                'eng_name' => 'Tofalo',
            ],
            [
                'name'     => 'فانيوتو',
                'eng_name' => 'Fanioto',
            ],
            [
                'name'     => 'ساموا الامريكية',
                'eng_name' => 'American Samo',
            ],
            [
                'name'     => 'جوام',
                'eng_name' => 'Goam',
            ],
            [
                'name'     => 'جزر ماريانا',
                'eng_name' => 'Mariana Islands',
            ],
            [
                'name'     => 'ميكرونيسيا',
                'eng_name' => 'Mekronisia',
            ],
            [
                'name'     => 'جزر ماريشال',
                'eng_name' => 'Marcial Islands',
            ],
            [
                'name'     => 'بيلو',
                'eng_name' => 'Belo',
            ],
            [
                'name'     => 'بولينيسيا الفرنسية',
                'eng_name' => 'French Bolenesia',
            ],
            [
                'name'     => 'جزر والس وفوتونا',
                'eng_name' => 'Wals Island',
            ],
            [
                'name'     => 'كاليدونيا الجديد',
                'eng_name' => 'New Kaledonia',
            ],
            [
                'name'     => 'ميانمار / مقيم',
                'eng_name' => 'Mainmar/ Moqem',
            ],
            [
                'name'     => 'القبائل النازحة',
                'eng_name' => 'No country',
            ],
            [
                'name'     => 'ميانمار / جواز بنجلادش',
                'eng_name' => 'Mainmar/ BG',
            ],
            [
                'name'     => 'ميانمار / جواز باكستان',
                'eng_name' => 'Mainmar/ NK',
            ],
            [
                'name'     => 'غير متوفر',
                'eng_name' => 'Not available',
            ],
        ];
        foreach ($nationalities as $key => $nationality) {
            \Tamkeen\Ajeer\Models\Nationality::create($nationality);
        }
    }
}
