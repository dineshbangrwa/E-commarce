<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Yajra\DataTables\DataTables;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Review::with(['product', 'user'])->select('reviews.*');

            return DataTables::of($data)
                ->addColumn('product_name', function ($row) {
                    return $row->product->name ?? 'N/A';
                })
                ->addColumn('reviewer', function ($row) {
                    return $row->user ? $row->user->name : $row->reviewer_name;
                })
                ->addColumn('approved', function ($row) {
                    return $row->approved ? 'Yes' : 'No';
                })
                ->addColumn('action', function ($row) {
                    $approveForm = '';
                    if (!$row->approved) {
                        $approveForm = '
                        <form method="POST" action="' . route('reviews.update', $row->id) . '" style="display:inline-block; margin-right:5px;">
                            ' . csrf_field() . method_field('PUT') . '
                            <input type="hidden" name="approved" value="1">
                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                        </form>';
                    }
                    $btn = '
                        <div class="d-flex align-items-center" style="gap:5px;">
                            ' . $approveForm . '
                            <button class="btn btn-sm btn-info btn-edit" data-id="' . $row->id . '">Edit</button>
                            <button class="btn btn-sm btn-success btn-update d-none" data-id="' . $row->id . '">Update</button>
                            <form method="POST" action="' . route('reviews.destroy', $row->id) . '" style="display:inline;" onsubmit="return confirm(\'Delete this review?\');">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.Review.index');
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'rating' => 'required|integer|min:1|max:5',
        //     'comment' => 'nullable|string|max:2000',
        //     'reviewer_name' => 'required_if:auth,false|string|max:100',
        //     'reviewer_email' => 'required_if:auth,false|email|max:100',
        // ]);


        $product = Product::findOrFail($request->product_id);


        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'reviewer_name' => auth()->check() ? null : $request->reviewer_name,
            'reviewer_email' => auth()->check() ? null : $request->reviewer_email,
            'approved' => false,
        ]);


        return redirect()->back()->with('success', 'Review submitted and waiting for approval!');
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);


        if ($request->has('approved')) {
            $review->approved = true;
            $review->save();
            return redirect()->back()->with('success', 'Review approved successfully!');
        }


        if ($request->has('comment')) {
            $request->validate([
                'comment' => 'required|string|max:2000',
            ]);
            $review->comment = $request->comment;
            $review->save();
            return response()->json(['success' => true]);
        }


        return redirect()->back();
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
