<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return view("manager.review.index", ['reviews' => $reviews]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('manager.review.index')->with('success', 'Review deleted successfully');
    }
}
