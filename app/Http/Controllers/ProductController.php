<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        // $products = Product:: where('user_id', $userId)->orderBy('id', 'desc')->paginate(5);
        if ($request->ajax()) {
            $data = Product::where('user_id', $userId)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function ($product) {
                        return '<img src="' . asset('/image/' . $product->image) . '" width="100px" />';
                    })   
                    ->addColumn('description', function($row) {
                        $truncated = Str::limit($row->description, 50, ' ... ');
                        return $truncated;
                    })              
                    ->addColumn('action', function($row){
                        $form = '<form action="' . route('products.destroy', $row->id) . '" method="POST">';
                        $form .= '<input type="hidden" name="_method" value="DELETE">';
                        $form .= '<a href="' . route('products.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                        $form .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete?\')">Delete</button>';
                        $form .= csrf_field();
                        $form .= '</form>';

return $form;

                    })
                    ->rawColumns(['image','action'])
                    ->make(true);
        }
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'type' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
        Product::create($input);
        return redirect()->route('home')->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'type' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";

        }else{
            unset($input['image']);
        }
        $product->update($input);

        return redirect()->route('home')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('home')->with('success','Product deleted successfully');
    }
}
