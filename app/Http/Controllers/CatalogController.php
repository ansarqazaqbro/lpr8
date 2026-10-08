<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Статический массив из 5 блюд (вариант 9 — Ресторан).
     *
     * @return array<int, array{id: int, code: string, name: string, menu_section: string, weight_g: int, price: float, calories: int, is_vegan: bool, image: string, description: string}>
     */
    private function dishes(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'DSH-001',
                'name' => 'КАЛЕ ЦЕЗАРЬ',
                'menu_section' => 'Салаты',
                'weight_g' => 280,
                'price' => 3200.00,
                'calories' => 420,
                'is_vegan' => false,
                'image' => 'https://images.ctfassets.net/eum7w7yri3zr/5418ra5b4TcMHRxOIobxUx/708a4c5778892e8504a4358b68aa8f3f/SG_Web_Image_Salad_KaleCaesar-2.0.png?w=600&fm=avif&q=75',
                'description' => 'Капуста кале, салат ромэн, жареная курица, панировочные сухари, пармезановые чипсы, лимонный сок, заправка «Цезарь».',
            ],
            [
                'id' => 2,
                'code' => 'DSH-002',
                'name' => 'ЗЕЛЕНЬ ДЛЯ ГУАКАМОЛЕ',
                'menu_section' => 'Салаты',
                'weight_g' => 310,
                'price' => 3500.00,
                'calories' => 480,
                'is_vegan' => false,
                'image' => 'https://images.ctfassets.net/eum7w7yri3zr/3Z3fW9JhznhFDphzlHNmRx/ccf2bde9a2f37be9eb3966ada129a4a6/SG_Web_Image_Salad_GuacamoleGreens-2.0.png?w=600&fm=avif&q=75',
                'description' => 'Жареная курица, авокадо, маринованный лук, нашинкованная капуста, кукурузная сальса, соус из лайма и кинзы.',
            ],
            [
                'id' => 3,
                'code' => 'DSH-003',
                'name' => 'КУРИЦА ПО-БУФФАЛО',
                'menu_section' => 'Горячие блюда',
                'weight_g' => 350,
                'price' => 4200.00,
                'calories' => 560,
                'is_vegan' => false,
                'image' => 'https://images.ctfassets.net/eum7w7yri3zr/DiHNAYmlek0vUQrUcfjST/d48fa92629fa033f9a165979d67a41e1/SG_Web_Image_Salad_BuffaloChicken.png?w=600&fm=avif&q=75',
                'description' => 'Курица обжаренная, маринованный лук, помидоры, фета, панировочные сухари, острый соус Sweetgreen.',
            ],
            [
                'id' => 4,
                'code' => 'DSH-004',
                'name' => 'ШРУМАМИ',
                'menu_section' => 'Горячие блюда',
                'weight_g' => 330,
                'price' => 3800.00,
                'calories' => 390,
                'is_vegan' => true,
                'image' => 'https://images.ctfassets.net/eum7w7yri3zr/57c1vaLIB4WtuQXQblhUa5/5bbbf55c178b7985a03f994749445040/SG_Web_Image_Bowl_Shroomami.png?w=600&fm=avif&q=75',
                'description' => 'Жареный тофу, грибы портобелло, огурцы, базилик, дикий рис, мисо-кунжутно-имбирный соус.',
            ],
            [
                'id' => 5,
                'code' => 'DSH-005',
                'name' => 'ТОМАТНЫЙ КРЕМ-СУП',
                'menu_section' => 'Супы',
                'weight_g' => 300,
                'price' => 2600.00,
                'calories' => 240,
                'is_vegan' => true,
                'image' => 'https://images.ctfassets.net/eum7w7yri3zr/57c1vaLIB4WtuQXQblhUa5/5bbbf55c178b7985a03f994749445040/SG_Web_Image_Bowl_Shroomami.png?w=600&fm=avif&q=75',
                'description' => 'Классический суп из спелых томатов с базиликом и оливковым маслом.',
            ],
        ];
    }

    /**
     * Список блюд с поиском и сортировкой.
     */
    public function index(Request $request)
    {
        $q = $request->query('q', '');
        $sort = $request->query('sort', '');

        $items = $this->dishes();

        if ($q !== '') {
            $items = array_values(array_filter(
                $items,
                fn ($dish) => mb_stripos($dish['name'], $q) !== false
            ));
        }

        if (in_array($sort, ['name', 'price', 'calories'], true)) {
            usort($items, fn ($a, $b) => $a[$sort] <=> $b[$sort]);
        }

        return view('catalog.index', compact('items', 'q', 'sort'));
    }

    /**
     * Детальная карточка блюда по id.
     */
    public function show(int $id)
    {
        $dish = collect($this->dishes())->firstWhere('id', $id);
        abort_if(! $dish, 404);

        return view('catalog.show', compact('dish'));
    }

    /**
     * Поиск блюда по коду формата ABC-123.
     */
    public function byCode(string $code)
    {
        $dish = collect($this->dishes())->firstWhere('code', $code);
        abort_if(! $dish, 404);

        return view('catalog.show', compact('dish'));
    }

    /**
     * Фильтрация блюд по разделу меню.
     */
    public function bySection(?string $section = null)
    {
        // Декодируем URL-encoded параметр (поддержка кириллицы)
        if ($section) {
            $section = urldecode($section);
        }

        $all = $this->dishes();

        $items = $section !== null
            ? array_values(array_filter($all, fn ($dish) => $dish['menu_section'] === $section))
            : $all;

        $sections = collect($all)
            ->pluck('menu_section')
            ->unique()
            ->sort()
            ->values()
            ->all();

        return view('catalog.section', compact('items', 'section', 'sections'));
    }
}
