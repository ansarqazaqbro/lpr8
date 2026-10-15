<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DishApiRequest;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use App\Support\ApiFormat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DishController extends Controller
{
    private const PER_PAGE = 4;

    private const SORTABLE = ['id', 'name', 'price', 'calories', 'weight_g', 'created_at'];

    /**
     * Список блюд: фильтр q, сортировка sort (по умолчанию name asc), пагинация.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Dish::query()->with('menuSection');

        if ($q = trim((string) $request->query('q', ''))) {
            $query->where('name', 'like', "%{$q}%");
        }

        $sort = (string) $request->query('sort', '');
        $desc = str_starts_with($sort, '-');
        $column = ltrim($sort, '-');

        if (in_array($column, self::SORTABLE, true)) {
            $query->orderBy($column, $desc ? 'desc' : 'asc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $dishes = $query->paginate(self::PER_PAGE)->withQueryString();

        return ApiFormat::success(
            DishResource::collection($dishes->getCollection())->resolve(),
            200,
            [
                'number' => $dishes->currentPage(),
                'size' => $dishes->perPage(),
                'total_items' => $dishes->total(),
                'total_pages' => $dishes->lastPage(),
            ],
        );
    }

    /**
     * Создание блюда.
     */
    public function store(DishApiRequest $request): JsonResponse
    {
        $dish = Dish::create($request->validated());
        $dish->refresh()->load('menuSection');

        return ApiFormat::success(
            (new DishResource($dish))->resolve(),
            201,
            null,
            ['Location' => route('api.dishes.show', $dish)],
        );
    }

    /**
     * Просмотр блюда.
     */
    public function show(Dish $dish): JsonResponse
    {
        return ApiFormat::success((new DishResource($dish->load('menuSection')))->resolve());
    }

    /**
     * Обновление блюда (PUT/PATCH).
     */
    public function update(DishApiRequest $request, Dish $dish): JsonResponse
    {
        $dish->update($request->validated());

        return ApiFormat::success((new DishResource($dish->load('menuSection')))->resolve());
    }

    /**
     * Удаление блюда.
     */
    public function destroy(Dish $dish): Response
    {
        $dish->delete();

        return response()->noContent();
    }
}
