<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    /**
     * Display recipes belonging to the logged-in user.
     */
    public function index()
    {
        $recipes = Recipe::where('user_id', '=', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('pages.recipes', compact('recipes'));
    }

    /**
     * Store a newly created recipe.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'ingredients'  => 'required|string',
            'instructions' => 'required|string',
            'prep_time'    => 'required|integer|min:1',
        ]);

        Recipe::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'ingredients'  => $request->ingredients,
            'instructions' => $request->instructions,
            'prep_time'    => $request->prep_time,
            'user_id'      => Auth::id(),
        ]);

        return redirect()->route('recipes.index')->with('success', 'Recipe added successfully!');
    }

    /**
     * Update the specified recipe.
     */
    public function update(Request $request, Recipe $recipe)
    {
        // Ensure the user owns this recipe
        if ($recipe->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'ingredients'  => 'required|string',
            'instructions' => 'required|string',
            'prep_time'    => 'required|integer|min:1',
        ]);

        $recipe->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'ingredients'  => $request->ingredients,
            'instructions' => $request->instructions,
            'prep_time'    => $request->prep_time,
        ]);

        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully!');
    }

    /**
     * Remove the specified recipe.
     */
    public function destroy(Recipe $recipe)
    {
        // Ensure the user owns this recipe
        if ($recipe->user_id !== Auth::id()) {
            abort(403);
        }

        /** @disregard P1013 Intelephense: Model::delete() requires no arguments */
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted successfully!');
    }
}
