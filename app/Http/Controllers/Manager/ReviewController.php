<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function event()
    {
        return Review::all();
    }
    public function index()
    {
        $reviews = Review::all();
        return view("manager.review.index", ['reviews' => $reviews]);
    }

    public function show(Review $review)
    {
        return view("manager.review.show", ['review' => $review]);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return '<script>
        window.parent.postMessage("review deleted", "*")
        </script>';
    }
}
