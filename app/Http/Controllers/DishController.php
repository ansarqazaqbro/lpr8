<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\MenuSection;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q', '');

        $query = Dish::with('menuSection');

        if ($q !== '') {
            $query->where('name', 'like', '%'.$q.'%');
        }

        $dishes = $query->orderBy('name', 'asc')
            ->paginate(4)
            ->withQueryString();

        return view('dishes.index', compact('dishes', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuSections = MenuSection::orderBy('sort_order')->orderBy('name')->get();
        $dish = new Dish;

        return view('dishes.form', compact('dish', 'menuSections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Will be wired in Step 5 with DishRequest
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        $menuSections = MenuSection::orderBy('sort_order')->orderBy('name')->get();

        return view('dishes.form', compact('dish', 'menuSections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dish $dish)
    {
        // Will be wired in Step 5 with DishRequest
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();

        return redirect()->route('dishes.index')
            ->with('status', 'Блюдо «'.$dish->name.'» успешно удалено.');
    }
}
