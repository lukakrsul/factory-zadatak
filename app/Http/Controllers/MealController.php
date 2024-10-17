<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    public function index(Request $request)
{
    // Validate query parameters
    $validator = Validator::make($request->all(), [
        'per_page' => 'integer|min:1|max:100',
        'tags' => 'nullable|integer',
        'lang' => 'required|string',
        'with' => 'nullable|string',
        'page' => 'integer|min:1'
    ]);

    // If validation fails, return error
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Extract query parameters
    $perPage = $request->input('per_page', 10);
    $tags = $request->input('tags');
    $lang = $request->input('lang');
    $with = $request->input('with'); 
    $page = $request->input('page', 1);

    // Initialize the base query for meals
    $query = Meal::query();

    // An array to store 'with' relations, if any
    $withRelations = [];

    if ($with) {
        $withArray = explode(',', $with); // Convert 'with' string into an array

        // Add relations if specified in 'with' parameter
        if (in_array('category', $withArray)) {
            $withRelations[] = 'category';
        }

        if (in_array('tags', $withArray)) {
            $withRelations[] = 'tags';
        }

        if (in_array('ingredients', $withArray)) {
            $withRelations[] = 'ingredients';
        }

        // Apply eager loading of relations if any were specified
        if (!empty($withRelations)) {
            $query->with($withRelations);
        }
    }

    // If a tag is specified, filter meals by that tag's id
    if ($tags) {
        $query->whereHas('tags', function ($q) use ($tags) {
            $q->where('tags.id', $tags);
        });
    }

    // Fetch the paginated meals
    $meals = $query->paginate($perPage);

    // Initialize response data array
    $responseData = [];

    // Loop through the meals and build the response manually
    foreach ($meals as $meal) {
        // Fetch translations for the specified language
        $translatedMeal = $meal->translate($lang);

        $mealData = [
            'id' => $meal->id,
            'title' => $translatedMeal ? $translatedMeal->title : null,
            'description' => $translatedMeal ? $translatedMeal->description : null,
            'status' => $meal->status,
        ];

        // Conditionally add category, tags, and ingredients based on 'withRelations'
        if (in_array('category', $withRelations)) {
            if($meal->category){  // Category can be NULL
                $mealData['category'] = [
                    'id' => $meal->category->id,
                    'title' => $meal->category->translate($lang)->title,
                    'slug' => $meal->category->slug,
                ];
            }else{
                $mealData['category'] = null;
            }
        }

        // Conditionally add tags if they exist
        if (in_array('tags', $withRelations)) {
            $mealData['tags'] = [];
            foreach ($meal->tags as $tag) {
                $mealData['tags'][] = [
                    'id' => $tag->id,
                    'title' => $tag->translate($lang)->title,
                    'slug' => $tag->slug,
                ];
            }
        }

        // Conditionally add ingredients if they exist
        if (in_array('ingredients', $withRelations)) {
            $mealData['ingredients'] = [];
            foreach ($meal->ingredients as $ingredient) {
                $mealData['ingredients'][] = [
                    'id' => $ingredient->id,
                    'title' => $ingredient->translate($lang)->title,
                    'slug' => $ingredient->slug,
                ];
            }
        }

        // Add mealData to response data array
        $responseData[] = $mealData;
    }

    // Build final response
    $response = [
        'meta' => [
            'currentPage' => $meals->currentPage(),
            'totalItems' => $meals->total(),
            'itemsPerPage' => $meals->perPage(),
            'totalPages' => $meals->lastPage(),
        ],
        'data' => $responseData,
        'links' => [
            'prev' => $meals->previousPageUrl(),
            'next' => $meals->nextPageUrl(),
            'self' => $meals->url($page),
        ],
    ];

    return response()->json($response);
}
}
