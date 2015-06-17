<?php
 
namespace App\Controllers\Front\Catalog;
 
use App\Models\Product;
use App\Controllers\Controller;
use Illuminate\Http\Request;
 
 
class ProductController extends Controller {
 
    public function index() {
        return Product::all();
    }
 
    public function getProduct($id) {
        $product  = Product::find($id);
 
        return response()->json($product);
    }
 
    public function createProduct(Request $request) {
        $product = Product::create($request->all());
 
        return response()->json($product);
    }
 
    public function deleteProduct($id) {
        $product = Product::find($id);
        $product->delete();

        return response()->json('success');
    }
 
    public function updateProduct(Request $request, $id) {
        $product         = Product::find($id);
        $product->title  = $request->input('title');
        $product->author = $request->input('author');
        $product->isbn   = $request->input('isbn');
        $product->save();
 
        return response()->json($product);
    }
}
