<?php

use Illuminate\Database\Seeder;

class PlaceDescriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('place_descriptions')->delete();
        
        \DB::table('place_descriptions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'place_id' => 1,
                'locale_id' => 1,
                'title' => 'Pidan mountain',
                'intro' => 'Pidan mountain',
                'description' => 'Pidan mountain',
            ),
            1 => 
            array (
                'id' => 2,
                'place_id' => 1,
                'locale_id' => 2,
            'title' => 'Гора Ливадийская (Пидан)',
            'intro' => 'Гора Ливадийская (Пидан)',
            'description' => 'Гора Ливадийская (Пидан)',
            ),
            2 => 
            array (
                'id' => 6,
                'place_id' => 5,
                'locale_id' => 2,
                'title' => 'Гора Холодильник',
                'intro' => 'Гора Холодильник',
                'description' => 'Гора Холодильник',
            ),
            3 => 
            array (
                'id' => 7,
                'place_id' => 6,
                'locale_id' => 2,
                'title' => 'Гора Лысая',
            'intro' => 'Гора Лысая (Партизанский р-н)',
                'description' => 'Гора Лысая
Высота: 1560 метров',
            ),
            4 => 
            array (
                'id' => 8,
                'place_id' => 7,
                'locale_id' => 2,
                'title' => 'Гора Ольховая',
                'intro' => 'Гора Ольховая',
                'description' => 'Гора Ольховая',
            ),
            5 => 
            array (
                'id' => 9,
                'place_id' => 8,
                'locale_id' => 2,
                'title' => 'Гора Облачная',
                'intro' => 'Гора Облачная',
                'description' => 'Гора Облачная',
            ),
            6 => 
            array (
                'id' => 10,
                'place_id' => 9,
                'locale_id' => 2,
                'title' => 'Гора Снежная',
                'intro' => 'Гора Снежная',
                'description' => 'Гора Снежная',
            ),
            7 => 
            array (
                'id' => 11,
                'place_id' => 10,
                'locale_id' => 2,
            'title' => 'Гора Литовка (Фалаза)',
                'intro' => 'Гора Фалаза',
                'description' => 'Гора Фалаза',
            ),
            8 => 
            array (
                'id' => 12,
                'place_id' => 11,
                'locale_id' => 2,
            'title' => 'Гора Скалистая (Читинза)',
            'intro' => 'Гора Скалистая (Читинза)',
            'description' => 'Гора Скалистая (Читинза)',
            ),
            9 => 
            array (
                'id' => 13,
                'place_id' => 12,
                'locale_id' => 2,
                'title' => 'Гора Аник',
                'intro' => 'Гора Аник',
                'description' => 'Гора Аник',
            ),
            10 => 
            array (
                'id' => 14,
                'place_id' => 13,
                'locale_id' => 2,
                'title' => 'Гора Воробей',
                'intro' => 'Гора Воробей',
                'description' => 'Гора Воробей',
            ),
            11 => 
            array (
                'id' => 15,
                'place_id' => 14,
                'locale_id' => 2,
                'title' => 'Гора Лысый Дед',
                'intro' => 'Гора Лысый Дед',
                'description' => 'Гора Лысый Дед',
            ),
            12 => 
            array (
                'id' => 16,
                'place_id' => 15,
                'locale_id' => 2,
                'title' => 'Гора Туманная',
                'intro' => 'Гора Туманная',
                'description' => 'Гора Туманная',
            ),
            13 => 
            array (
                'id' => 17,
                'place_id' => 16,
                'locale_id' => 2,
                'title' => 'Хребет Большой Воробей',
                'intro' => 'Хребет Большой Воробей',
                'description' => 'Хребет Большой Воробей',
            ),
            14 => 
            array (
                'id' => 18,
                'place_id' => 17,
                'locale_id' => 2,
            'title' => 'Гора Сестра(Находка)',
            'intro' => 'Гора Сестра(Находка)',
            'description' => 'Гора Сестра(Находка)',
            ),
            15 => 
            array (
                'id' => 19,
                'place_id' => 18,
                'locale_id' => 2,
                'title' => 'Гора Чандолаз',
                'intro' => 'Гора Чандолаз',
                'description' => 'Гора Чандолаз',
            ),
            16 => 
            array (
                'id' => 20,
                'place_id' => 19,
                'locale_id' => 2,
                'title' => 'Беневские водопады',
                'intro' => 'Беневские водопады',
                'description' => 'Беневские водопады',
            ),
            17 => 
            array (
                'id' => 21,
                'place_id' => 20,
                'locale_id' => 2,
                'title' => 'Кравцовские водопады',
                'intro' => 'Кравцовские водопады',
                'description' => 'Кравцовские водопады',
            ),
            18 => 
            array (
                'id' => 22,
                'place_id' => 21,
                'locale_id' => 2,
                'title' => 'Бухта Триозерье',
                'intro' => 'Бухта Триозерье',
                'description' => 'Бухта Триозерье',
            ),
            19 => 
            array (
                'id' => 23,
                'place_id' => 22,
                'locale_id' => 2,
                'title' => 'Бухта Окунева',
                'intro' => 'Бухта Окунева',
                'description' => 'Бухта Окунева',
            ),
            20 => 
            array (
                'id' => 24,
                'place_id' => 23,
                'locale_id' => 2,
                'title' => 'Бухта Спокойная',
                'intro' => 'Бухта Спокойная',
                'description' => 'Бухта Спокойная',
            ),
            21 => 
            array (
                'id' => 25,
                'place_id' => 24,
                'locale_id' => 2,
                'title' => 'Бухта Большая Ежовая',
                'intro' => 'Бухта Большая Ежовая, Врангель',
                'description' => 'Бухта Большая Ежовая, Врангель',
            ),
            22 => 
            array (
                'id' => 26,
                'place_id' => 25,
                'locale_id' => 2,
            'title' => 'Бухта Лазурная (Шамора)',
            'intro' => 'Бухта Лазурная (Шамора)',
            'description' => 'Бухта Лазурная (Шамора)',
            ),
            23 => 
            array (
                'id' => 27,
                'place_id' => 26,
                'locale_id' => 2,
                'title' => 'Бухта Шепалова',
                'intro' => 'Бухта Шепалова',
                'description' => 'Бухта Шепалова',
            ),
            24 => 
            array (
                'id' => 28,
                'place_id' => 27,
                'locale_id' => 2,
                'title' => 'Пляж Ливадия',
                'intro' => 'Пляж Ливадия',
                'description' => 'Пляж Ливадия',
            ),
            25 => 
            array (
                'id' => 29,
                'place_id' => 28,
                'locale_id' => 2,
                'title' => 'Мыс Гамомова',
                'intro' => 'Мыс Гамомова',
                'description' => 'Мыс Гамомова',
            ),
            26 => 
            array (
                'id' => 30,
                'place_id' => 29,
                'locale_id' => 2,
                'title' => 'Бухта Витязь',
                'intro' => 'Бухта Витязь',
                'description' => 'Бухта Витязь',
            ),
            27 => 
            array (
                'id' => 31,
                'place_id' => 30,
                'locale_id' => 2,
                'title' => 'Эльбрус',
            'intro' => 'Эльбрус (вершина)',
                'description' => 'Эльбрус',
            ),
            28 => 
            array (
                'id' => 32,
                'place_id' => 31,
                'locale_id' => 2,
                'title' => 'Бухта Теляковского',
                'intro' => 'Бухта Теляковского',
                'description' => 'Бухта Теляковского',
            ),
            29 => 
            array (
                'id' => 33,
                'place_id' => 32,
                'locale_id' => 2,
                'title' => 'Полуостров Краббе',
                'intro' => 'Полуостров Краббе',
                'description' => 'Полуостров Краббе',
            ),
            30 => 
            array (
                'id' => 34,
                'place_id' => 33,
                'locale_id' => 2,
                'title' => 'Бухта Бойсмана',
                'intro' => 'Бухта Бойсмана',
                'description' => 'Бухта Бойсмана
Фото
http://www.treefrog.ru/photo/category/180-ryazanovka',
            ),
            31 => 
            array (
                'id' => 35,
                'place_id' => 34,
                'locale_id' => 2,
                'title' => 'Долина атлантов',
                'intro' => 'Долина атлантов',
                'description' => 'Долина атлантов',
            ),
            32 => 
            array (
                'id' => 36,
                'place_id' => 35,
                'locale_id' => 2,
                'title' => 'Мыс Сосновый',
                'intro' => 'Мыс Сосновый',
                'description' => 'Мыс Сосновый',
            ),
            33 => 
            array (
                'id' => 37,
                'place_id' => 36,
                'locale_id' => 2,
                'title' => 'Мыс Лисученко',
                'intro' => 'Мыс Лисученко',
                'description' => 'Мыс Лисученко',
            ),
            34 => 
            array (
                'id' => 38,
                'place_id' => 37,
                'locale_id' => 2,
                'title' => 'Милоградовские водопады',
                'intro' => 'Милоградовские водопады',
                'description' => 'Милоградовские водопады',
            ),
            35 => 
            array (
                'id' => 39,
                'place_id' => 38,
                'locale_id' => 2,
                'title' => 'Водопад Черный Шаман',
                'intro' => 'Водопад Черный Шаман',
                'description' => 'Водопад Черный Шаман',
            ),
            36 => 
            array (
                'id' => 40,
                'place_id' => 39,
                'locale_id' => 2,
                'title' => 'Набережная ДВФУ',
                'intro' => 'Набережная ДВФУ',
                'description' => 'Набережная ДВФУ',
            ),
            37 => 
            array (
                'id' => 41,
                'place_id' => 40,
                'locale_id' => 2,
                'title' => 'Корабельная набережная',
                'intro' => 'Корабельная набережная',
                'description' => 'Корабельная набережная',
            ),
            38 => 
            array (
                'id' => 42,
                'place_id' => 41,
                'locale_id' => 2,
                'title' => 'Спортивная Набережная',
                'intro' => 'Спортивная Набережная',
                'description' => 'Спортивная Набережная',
            ),
            39 => 
            array (
                'id' => 43,
                'place_id' => 42,
                'locale_id' => 2,
                'title' => 'Маяк Токаревский',
                'intro' => 'Маяк Токаревский',
                'description' => 'Маяк Токаревский',
            ),
            40 => 
            array (
                'id' => 44,
                'place_id' => 43,
                'locale_id' => 2,
                'title' => 'Океанариум',
                'intro' => 'Океанариум на спортивной набережной',
                'description' => 'Океанариум на спортивной набережной',
            ),
            41 => 
            array (
                'id' => 48,
                'place_id' => 47,
                'locale_id' => 2,
                'title' => 'Мыс Кунгасный',
                'intro' => 'Мыс Кунгасный',
                'description' => 'Мыс Кунгасный',
            ),
            42 => 
            array (
                'id' => 49,
                'place_id' => 48,
                'locale_id' => 2,
                'title' => 'Приморский океанариум',
                'intro' => 'Приморский океанариум Научно-образовательный комплекс',
                'description' => 'Приморский океанариум Научно-образовательный комплекс',
            ),
            43 => 
            array (
                'id' => 50,
                'place_id' => 49,
                'locale_id' => 2,
                'title' => 'Остров Фуругельма',
                'intro' => 'Остров Фуругельма',
                'description' => 'Остров Фуругельма',
            ),
            44 => 
            array (
                'id' => 51,
                'place_id' => 50,
                'locale_id' => 2,
                'title' => 'Остров Аскольд',
                'intro' => 'Остров Аскольд',
                'description' => 'Остров Аскольд',
            ),
            45 => 
            array (
                'id' => 52,
                'place_id' => 51,
                'locale_id' => 2,
                'title' => 'Бухта Тунгус',
                'intro' => 'Бухта Тунгус',
                'description' => 'Бухта Тунгус',
            ),
            46 => 
            array (
                'id' => 53,
                'place_id' => 52,
                'locale_id' => 2,
                'title' => 'Мыс Пассека',
                'intro' => 'Мыс Пассека',
                'description' => 'Мыс Пассека',
            ),
            47 => 
            array (
                'id' => 54,
                'place_id' => 53,
                'locale_id' => 2,
                'title' => 'Смотровая площадка бухта Теляковского',
                'intro' => 'Смотровая площадка бухта Теляковского',
                'description' => 'Смотровая площадка бухта Теляковского',
            ),
            48 => 
            array (
                'id' => 56,
                'place_id' => 55,
                'locale_id' => 2,
                'title' => 'Центр отдыха Комета',
                'intro' => 'Центр отдыха Комета',
                'description' => 'Центр отдыха Комета',
            ),
            49 => 
            array (
                'id' => 57,
                'place_id' => 56,
                'locale_id' => 2,
                'title' => 'Горнолыжный комплекс "Синяя сопка"',
                'intro' => 'Горнолыжный комплекс "Синяя сопка"',
                'description' => 'Горнолыжный комплекс "Синяя сопка"',
            ),
            50 => 
            array (
                'id' => 58,
                'place_id' => 57,
                'locale_id' => 2,
                'title' => 'Горнолыжная база "Грибановка"',
                'intro' => 'Горнолыжная база "Грибановка"',
                'description' => 'Горнолыжная база "Грибановка"',
            ),
            51 => 
            array (
                'id' => 59,
                'place_id' => 58,
                'locale_id' => 2,
                'title' => 'Кайлас',
                'intro' => 'Кайлас',
                'description' => 'Кайлас',
            ),
            52 => 
            array (
                'id' => 60,
                'place_id' => 59,
                'locale_id' => 2,
                'title' => 'Музей Автомотостарины',
                'intro' => 'Музей Автомотостарины',
                'description' => 'Музей Автомотостарины',
            ),
            53 => 
            array (
                'id' => 61,
                'place_id' => 60,
                'locale_id' => 2,
                'title' => 'Форт №4',
                'intro' => 'Форт №4',
                'description' => 'Форт №4',
            ),
            54 => 
            array (
                'id' => 62,
                'place_id' => 61,
                'locale_id' => 2,
                'title' => 'Форт № 7',
                'intro' => 'Форт № 7',
                'description' => 'Форт № 7',
            ),
            55 => 
            array (
                'id' => 63,
                'place_id' => 62,
                'locale_id' => 2,
                'title' => 'Ботанический сад-институт ДВО РАН',
                'intro' => 'Ботанический сад-институт ДВО РАН',
                'description' => 'Ботанический сад и дендрарий с лесной тропой и тысячами видов растений со всего мира.',
            ),
            56 => 
            array (
                'id' => 64,
                'place_id' => 63,
                'locale_id' => 2,
                'title' => 'Ворошиловская батарея',
                'intro' => 'Ворошиловская батарея',
                'description' => 'Ворошиловская батарея',
            ),
            57 => 
            array (
                'id' => 65,
                'place_id' => 64,
                'locale_id' => 2,
                'title' => 'Мыс Тобизина',
                'intro' => 'Мыс Тобизина',
                'description' => 'Мыс Тобизина',
            ),
            58 => 
            array (
                'id' => 66,
                'place_id' => 65,
                'locale_id' => 2,
                'title' => 'Каракольские озера',
            'intro' => 'Каракольские озёра (южноалт. Кара-Кол — «Чёрное озеро») — группа из семи живописных горных озёр',
            'description' => 'Каракольские озёра (южноалт. Кара-Кол — «Чёрное озеро») — группа из семи живописных горных озёр в России, на территории Республики Алтай в Чемальском районе, расположенная на западном склоне хребта Иолго, водораздела рек Бия и Катунь у подножия перевала Багаташ.',
            ),
            59 => 
            array (
                'id' => 67,
                'place_id' => 66,
                'locale_id' => 2,
                'title' => 'Скала Четыре Брата',
                'intro' => 'Скала Четыре Брата',
                'description' => 'Скала Четыре Брата',
            ),
            60 => 
            array (
                'id' => 68,
                'place_id' => 67,
                'locale_id' => 2,
                'title' => 'Гора Белуха',
            'intro' => 'Гора Белуха (Уч-Сумер)',
            'description' => 'Гора Белуха (Уч-Сумер)',
            ),
            61 => 
            array (
                'id' => 69,
                'place_id' => 68,
                'locale_id' => 2,
                'title' => 'Семинский Хребет',
                'intro' => 'Семинский Хребет',
                'description' => 'Семинский Хребет',
            ),
            62 => 
            array (
                'id' => 70,
                'place_id' => 69,
                'locale_id' => 2,
                'title' => 'Гора Сарлык',
                'intro' => 'Гора Сарлык',
                'description' => 'Гора Сарлык',
            ),
        ));
        
        
    }
}