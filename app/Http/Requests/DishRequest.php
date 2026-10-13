<?php

namespace App\Http\Requests;

use App\Models\Dish;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_vegan' => $this->boolean('is_vegan'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $dish = $this->route('dish');
        $dishId = $dish instanceof Dish ? $dish->id : $dish;

        return [
            'menu_section_id' => ['required', 'integer', 'exists:menu_sections,id'],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:127',
                Rule::unique('dishes')->where('menu_section_id', $this->input('menu_section_id'))->ignore($dishId),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'weight_g' => ['required', 'integer', 'min:10', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0'],
            'calories' => ['required', 'integer', 'min:0', 'max:3000'],
            'is_vegan' => ['boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'menu_section_id' => 'раздел меню',
            'name' => 'название блюда',
            'description' => 'описание',
            'weight_g' => 'вес (в граммах)',
            'price' => 'цена',
            'calories' => 'калорийность',
            'is_vegan' => 'вегетарианское блюдо',
        ];
    }
}
