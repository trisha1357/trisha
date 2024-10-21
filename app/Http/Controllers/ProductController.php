<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function allproduct()
    {
        $products=Product::all();
        return view('allproduct',compact('products'));
    }
    

    public function addproduct()
    {
        return view('addproduct');
    }

    public function storeproduct(Request $request)
    {

       

        $products=new Product();

        // $image = $request->file('product_img');
        // $img_name=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        // $request->product_img->move(public_path('upload'),$img_name);
        // $img_url='upload/'.$img_name;

        if(isset($request->product_img)){
            $filename = time().'.'.$request->product_img->extension();
            $upload_path = public_path('upload/productphoto');
            $request->product_img->move($upload_path,$filename);
            $products->product_img = $filename;
        }

        $products->product_name=$request->product_name;
        
        $products->save();

        // Product::insert([
            //'product_name'=>$request->product_name
            
        // ]);
        return redirect()->route('allproduct');
    }

     public function editproduct($id){
        $products=Product::find($id);
        return view('editproduct',compact('products'));
    }
    
    public function updateproduct(Request $request,$id){
        $products=Product::find($id);
        $products->product_name=$request->product_name;

        if(isset($request->product_img)){
            $filename = time().'.'.$request->product_img->extension();
            $upload_path = public_path('upload/productphoto');
            $request->product_img->move($upload_path,$filename);
            $products->product_img = $filename;
        }




        $products->save();
        return redirect()->route('allproduct');
    }    

    public function deleteproduct($id)
    {
        $products=Product::find($id);
        $products->delete();
        return redirect()->route('allproduct');
    }
}
