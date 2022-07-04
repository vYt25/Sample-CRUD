<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.quantity',
            'products.category as category_id',
            'c.name as category'
        )
        ->join('categories as c', 'c.id', 'products.category');

        if(!is_null($request->input('category'))){
            $query->where('products.category', $request->input('category'));
        }

        if($request->input('stock') == 'with stock'){
            $query->where('products.quantity', '>', 0);
        }

        if($request->input('stock') == 'no stock'){
            $query->where('products.quantity', 0);
        }

        $query->get();

        if($request->input('searchString') || $request->input('searchString') != 'null'){
            $query->where(function($query) use ($request){
                $query->where('products.name', 'LIKE', '%' . $request->input('searchString') . '%')
                    ->orWhere('products.description', 'LIKE', '%' . $request->input('searchString') . '%')
                    ->orWhere('products.price', 'LIKE', '%' . $request->input('searchString') . '%');
            });
        }

        return $query->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product = Product::findOrNew($request->input('id'));
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->category = $request->input('category');
        $product->saveOrFail();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
    }
}
