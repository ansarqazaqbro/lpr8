<?php

namespace App\Http\Requests\Api;

use App\Models\Dish;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DishApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $dish = $this->route('dish');
        $dishId = $dish instanceof Dish ? $dish->id : $dish;

        // Для PATCH все поля необязательны (sometimes), для POST/PUT — обязательны
        $req = $this->isMethod('PATCH') ? ['sometimes', 'required'] : ['required'];

        // При PATCH без menu_section_id берём раздел из текущего блюда
        $sectionId = $this->input('menu_section_id', $dish instanceof Dish ? $dish->menu_section_id : null);

        return [
            'menu_section_id' => [...$req, 'integer', 'exists:menu_sections,id'],
            'name' => [
                ...$req,
                'string',
                'min:2',
                'max:127',
                Rule::unique('dishes')->where('menu_section_id', $sectionId)->ignore($dishId),
            ],
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'weight_g' => [...$req, 'integer', 'min:10', 'max:2000'],
            'price' => [...$req, 'numeric', 'min:0'],
            'calories' => [...$req, 'integer', 'min:0', 'max:3000'],
            'is_vegan' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'menu_section_id' => 'раздел меню',
            'name' => 'название',
            'description' => 'описание',
            'weight_g' => 'вес (в граммах)',
            'price' => 'цена',
            'calories' => 'калорийность',
            'is_vegan' => 'вегетарианское блюдо',
        ];
    }
}
