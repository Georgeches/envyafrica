<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $customer_id = [CustomerController::class, 'activeCustomer'];
        return view('products.index', [
            'products' => Product::latest()->filter(request(['category', 'minprice', 'maxprice', 'sort', 'search']))->get(),
        ]);
    }

    public function index2(){
        $categories = ['shoes', 'hoodies', 't-shirt', 'pants', 'shorts'];

        return view('products.productsPage',[
            'products' => Product::latest()->filter(request(['category', 'minprice', 'maxprice', 'sort', 'search']))->get(),
            'categories' => Category::all()
        ]);
    }

    public function show($id){
        $product = Product::findOrFail($id);
        $productImages = ProductImage::where('product_id', 'like', $id)->get();
        $category = Category::where('id', 'like', $product['category_id'])->get();
        return view('products.show', [
            'product' => $product,
            'product_images' => $productImages,
            'category' => $category
        ]);
    }

    public function create(){
        return view('admin.create');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'name' => 'required',
            'model' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'image' => 'required',
            'description' => 'required',
            'color' => 'required',
            'price' => 'required'
        ]);

        Product::create($formFields);

        return redirect('/adminpage')->with('success', 'Product added successfully!');
    }

    public function edit($id){
        $product = Product::findOrFail($id);

        return view('admin.edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, $id){
        $product = Product::findOrFail($id);
        
        $formFields = $request->validate([
            'name' => 'required',
            'model' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'image' => 'required',
            'description' => 'required',
            'color' => 'required',
            'price' => 'required'
        ]);
        $product->update($formFields);
        return redirect('/adminpage')->with('success', 'Product updated successfully!');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/adminpage')->with('success', 'Product deleted successfully!');
    }
}
