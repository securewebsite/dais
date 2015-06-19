<?php
 
namespace Api\Controllers\Front\Catalog;
 
use Api\Models\Product;
use Api\Controllers\Controller;
use Illuminate\Http\Request;
 
 
class ProductController extends Controller {
 
    public function index() {
        return Product::all();
    }
 
    public function getProduct($id) {
        return Product::find($id);
    }
 
    public function createProduct(Request $request) {
        return Product::create($request->all());
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
