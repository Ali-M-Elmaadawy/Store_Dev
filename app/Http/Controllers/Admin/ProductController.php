<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\SubCategory;
use App\Product;
use App\ProductDetails;
use App\ProductImages;
class ProductController extends Controller
{

    public function __construct() {

        $this->middleware('auth');
    }

    public function getaddproduct() {


        if(\Auth::user()->type != '1') {

            return redirect('/homepage');
            
        }

    	$allCategory = Category::get();
    	return view('admin.add_product' , compact('allCategory'));
    }



    public function postaddproduct(Request $request) {


        if(\Auth::user()->type != '1') {

            return redirect('/homepage');
            
        }


        $validator = \Validator::make($request->all() , [
            'productImage'      => 'required',   
            'productName'       => 'required|regex:/(^(([a-zA-Z]+)([0-9]+)?(\s+)?)+$)/u', // Accepts strings and spaces and string with numbers(test test123)
            'quantity'          => 'required|integer',
            'price'             => 'required|integer',
            'category_id'       => 'required|integer|exists:categories,id',
            'subcategory_id'    => 'nullable|exists:sub_categories,id',
            'description'       => 'required|string'
        ]);

        $error_array = [];
        if($validator->fails()) {
            foreach ($validator->messages()->getmessages() as $messages) {
              $error_array[]= $messages;
                 return $error_array;
            }
        }

        $images         = $request->productImage;       
        $productName    = $request->productName;       
        $quantity       = $request->quantity;       
        $price          = $request->price;       
        $category_id    = $request->category_id;       
        $subcategory_id = $request->subcategory_id;       
        $description    = $request->description;  


        // Start Insert New product In Table products

        $insertTheProduct = new Product;

        $insertTheProduct->name = $productName;
        $insertTheProduct->category_id = $category_id;
        $insertTheProduct->subcategory_id = $subcategory_id;
        $insertTheProduct->save();

        // Start Get category name to make folder for the product in folder of category name
        $categoryName = Category::where('id' , $category_id)->select('name')->first();

        $categoryName = $categoryName->name;

        // Start Get subcategory name to make folder for the product in folder of subcategory name
        if($subcategory_id != null) {

            $subcategoryName = SubCategory::where('id' , $subcategory_id)->select('name')->first();
            $subcategoryName = $subcategoryName->name;

            $folderPath = public_path('imgs').'/'.$categoryName.'/subcategories/'.$subcategoryName;
            mkdir($folderPath.'/'.$productName);
            $folderOfProduct = public_path('imgs').'/'.$categoryName.'/subcategories/'.$subcategoryName.'/'.$productName;


            $imagesArrayName = [];
            foreach($images as $image) {
                $imagesArrayName[] = '1020304050'.$image->getClientOriginalName();
                $image->move($folderOfProduct ,'1020304050'.$image->getClientOriginalName());
            }

                // Start insert First Image In Table product_details
                $firstImageName = $imagesArrayName[0];

                $insertFirstImage = new ProductDetails;

                $insertFirstImage->product_id = $insertTheProduct->id;
                $insertFirstImage->image = $firstImageName;
                $insertFirstImage->price = $price;
                $insertFirstImage->quantity = $quantity;
                $insertFirstImage->description = $description;
                $insertFirstImage->save();


                // Start Insert Other Images In Table product_images
                if(count($images) > 0) {
                    $otherImagesNames = array_slice($imagesArrayName , 1);
                    foreach($otherImagesNames as $otherimage) {
                        $insertOtherImage = new ProductImages;
                        $insertOtherImage->product_id = $insertTheProduct->id;
                        $insertOtherImage->image = $otherimage;
                        $insertOtherImage->save();
                    }
                }
            return 'Success Inserted';
        } else {
        //     No SubCategory
            $folderPath = public_path('imgs').'/'.$categoryName;
            mkdir($folderPath.'/'.$productName);
            $folderOfProduct = public_path('imgs').'/'.$categoryName.'/'.$productName;

            $imagesArrayName = [];
            foreach($images as $image) {
                $imagesArrayName[] = '1020304050'.$image->getClientOriginalName();
                $image->move($folderOfProduct ,'1020304050'.$image->getClientOriginalName());
            }

                // Start insert First Image In Table product_details
                $firstImageName = $imagesArrayName[0];

                $insertFirstImage = new ProductDetails;

                $insertFirstImage->product_id = $insertTheProduct->id;
                $insertFirstImage->image = $firstImageName;
                $insertFirstImage->price = $price;
                $insertFirstImage->quantity = $quantity;
                $insertFirstImage->description = $description;
                $insertFirstImage->save();

                if(count($images) > 0) {
                    $otherImagesNames = array_slice($imagesArrayName , 1);
                    foreach($otherImagesNames as $otherimage) {
                        $insertOtherImage = new ProductImages;
                        $insertOtherImage->product_id = $insertTheProduct->id;
                        $insertOtherImage->image = $otherimage;
                        $insertOtherImage->save();
                    }
                }            
            return 'Success Inserted';
        }


    }

    // Start Get Subcategories List Using Ajax
    public function getsubcategory(Request $request) {

        if(\Auth::user()->type != '1') {

            return redirect('/homepage');
            
        }

        $validator = \Validator::make($request->all() , [
            
            'category_id'     => 'required|exists:categories,id'
        ]);

        if($validator->fails()) {

        	 return 'Error';
        }

        $category_id = $request->category_id;

        if($request->ajax()) {
        	// Get subcategory of this category
        	$startGetSubcats = SubCategory::where('category_id' , $category_id)->get();
			$options = [];
        	if(count($startGetSubcats) > 0) {
        		// Means There Is SubCats
        			 
        			foreach($startGetSubcats as $subcat) {

        				$options[] = "<option value='$subcat->id'>".$subcat->name."</option>";
        			}	
        			return $options;
        	} else {
        		// Means No Sub Cat
        		$options[] = '<option value="">No SubCategory</option>';
				return $options;
        	}
        }
    }

    public function allproduct(Request $request) {



        $getAllPro = Product::with('productdetails','productimages' , 'category' , 'subcategory')
        ->get();
        // $getAllCategories = Category::with('subcategory')->get();
        $allCategory = Category::get();
        // if($request->ajax()) {

        //     return [
        //         'products' => view('admin.all_product_ajax' , compact('getAllPro'))->render(),
        //         'total'    => $getAllPro->total()
        //     ];
        // }

        // not ajax
        return view('admin.all_product' , compact(['getAllPro','allCategory']));
    }


    public function editproduct(Request $request) {

        // Start Check If Not Admin
        if(\Auth::user()->type != '1') {

            return redirect('/homepage');
            
        }
  


        if($request->ajax()) {

            $validator = \Validator::make($request->all() , [
                
                'productimages'     => 'nullable|array',
                'productimages.*'   => 'image|mimes:jpg,jpeg,png,jif',
                'productname'       =>'required|regex:/(^(([a-zA-Z]+)([0-9]+)?(\s+)?)+$)/u',
                'quantity'          => 'required|integer',
                'price'             => 'required|integer',
                'category_id'       => 'required|integer|exists:categories,id',
                'subcategory_id'    => 'nullable|exists:sub_categories,id',
                'description'       => 'required|string',
                'product_id'        => 'required|exists:products,id'


            ]);

                $images             = $request->productimages;   
                $productName        = $request->productname;       
                $quantity           = $request->quantity;       
                $price              = $request->price;       
                $newCategory_id     = $request->category_id;       
                $newSubcategory_id  = $request->subcategory_id;  
                $description        = $request->description;  
                $product_id         = $request->product_id;    
                $error_array = [];
            if($validator->fails()) {
                foreach ($validator->messages()->getmessages() as $messages) {
                  $error_array[]= $messages;    
                }
                return $error_array;
            }

            // Start Get The Old Product Details From Database And Start Delete Images And Folder
            $getOldProductDetails = Product::find($request->product_id);


            // Start Get category name to make folder for the product in folder of category name
            $newCategoryName = Category::where('id' , $newCategory_id)->select('name')->first();
            $newCategoryName = $newCategoryName->name;

            // Check If New Images Has Not Uploaded From Input 
            if($images == null) {

                // Start Update In Database 
                $updateInDataBase = Product::where('id' , $request->product_id)->update(['name'=>$productName ,'category_id'=> $newCategory_id , 'subcategory_id' => $newSubcategory_id]);


                $updateProductDetails = ProductDetails::where('product_id' , $product_id)->update(['price' => $price , 'quantity' => $quantity , 'description' => $description]);      

                // Start Get Old Category Name
                $oldCategoryName = Category::where('id' , $getOldProductDetails->category_id)->select('name')->first();
                $oldCategoryName = $oldCategoryName->name;

                // Start Get Old Subcategory Name
                if($getOldProductDetails->subcategory_id != null) {

                    $oldSubcategoryName = SubCategory::where('id' , $getOldProductDetails->subcategory_id)->select('name')->first();
                    $oldSubcategoryName = $oldSubcategoryName->name;


                    $OldfolderPath = public_path('imgs').'/'.$oldCategoryName.'/subcategories/'.$oldSubcategoryName.'/'.$getOldProductDetails->name;

                    $addFolderName = public_path('imgs').'/'.$oldCategoryName.'/subcategories/'.$oldSubcategoryName;
                } else {

                    $OldfolderPath = public_path('imgs').'/'.$oldCategoryName.'/'.$getOldProductDetails->name;

                    $addFolderName = public_path('imgs').'/'.$oldCategoryName;
                }


                if($newCategory_id == $getOldProductDetails->category_id && $newSubcategory_id == $getOldProductDetails->subcategory_id) {


                    rename($addFolderName.'/'.$getOldProductDetails->name, $addFolderName.'/'.$productName);

                    // Get Ajax Page
                    $getAllPro = Product::with('productdetails','productimages' , 'category' , 'subcategory')
                    ->get();
                    $allCategory = Category::get();

                    return ['message' => 'Success Updated' , 'all_product'=>view('admin.all_product_ajax' , compact('getAllPro','allCategory'))->render()];    

                    
                }

                if($newSubcategory_id != null) {
                    // If There Is Subcategory 

                    // Start Get Old Category Name
                    // $oldCategoryName = Category::where('id' , $getOldProductDetails->category_id)->select('name')->first();
                    // $oldCategoryName = $oldCategoryName->name;


                    $newSubcategoryName = SubCategory::where('id' , $newSubcategory_id)->select('name')->first();
                    $newSubcategoryName = $newSubcategoryName->name;

                    $folderPath = public_path('imgs').'/'.$newCategoryName.'/subcategories/'.$newSubcategoryName;
                    mkdir($folderPath.'/'.$productName);

                    $folderOfProduct = public_path('imgs').'/'.$newCategoryName.'/subcategories/'.$newSubcategoryName.'/'.$productName;


                    // Start Check The Images In Folder And Remove It
                    $checkImgInProductFolder = array_slice(scandir($OldfolderPath), 2);

                    if(count($checkImgInProductFolder) > 0) {
                        foreach($checkImgInProductFolder as $img) {
                            rename($OldfolderPath.'/'.$img, $folderOfProduct.'/'.$img);

                        }
                        rmdir($OldfolderPath);
                    }



                } else {

                    // If There Is No Subcategory In The Request

                    // Start Get Old Category Name
                    $oldCategoryName = Category::where('id' , $getOldProductDetails->category_id)->select('name')->first();
                    $oldCategoryName = $oldCategoryName->name;

                    // Check If Old Product Has subcategory Or Not

                    if($getOldProductDetails->subcategory_id == null) {

                        $OldfolderPath = public_path('imgs').'/'.$oldCategoryName.'/'.$getOldProductDetails->name;

                    } else {

                        // Start Get Old Subcategory Name
                        $oldSubcategoryName = SubCategory::where('id' , $getOldProductDetails->subcategory_id)->select('name')->first();
                        $oldSubcategoryName = $oldSubcategoryName->name;

                        $OldfolderPath = public_path('imgs').'/'.$oldCategoryName.'/subcategories/'.$oldSubcategoryName.'/'.$getOldProductDetails->name;

                    }

                    // Start Make New Folder In The newCategoryName
                    $folderPath = public_path('imgs').'/'.$newCategoryName;
                    mkdir($folderPath.'/'.$productName);

                    $folderOfProduct = public_path('imgs').'/'.$newCategoryName.'/'.$productName;


                    // Start Check The Images In Folder And Remove It
                    $checkImgInProductFolder = array_slice(scandir($OldfolderPath), 2);

                    if(count($checkImgInProductFolder) > 0) {

                        foreach($checkImgInProductFolder as $img) {

                            rename($OldfolderPath.'/'.$img, $folderOfProduct.'/'.$img);
                        }

                        rmdir($OldfolderPath);
                    }

                }
                    // Get Ajax Page
                    $getAllPro = Product::with('productdetails','productimages' , 'category' , 'subcategory')
                    ->get();
                    $allCategory = Category::get();

                    return ['message' => 'Success Updated' , 'all_product'=>view('admin.all_product_ajax' , compact('getAllPro','allCategory'))->render()]; 


            } else {
                // There Is Images In Input

                // Start Update In Database 
                $updateInDataBase = Product::where('id' , $request->product_id)->update(['name'=>$productName ,'category_id'=> $newCategory_id , 'subcategory_id' => $newSubcategory_id]);

                if($newSubcategory_id != null) {
                    // If There Is Subcategory 

                    // Start Get Old Category Name
                    $oldCategoryName = Category::where('id' , $getOldProductDetails->category_id)->select('name')->first();
                    $oldCategoryName = $oldCategoryName->name;

                    // Start Get Old Subcategory Name
                    if($getOldProductDetails->subcategory_id != null) {

                        $oldSubcategoryName = SubCategory::where('id' , $getOldProductDetails->subcategory_id)->select('name')->first();
                        $oldSubcategoryName = $oldSubcategoryName->name;


                        $OldfolderPath = public_path('imgs').'/'.$oldCategoryName.'/subcategories/'.$oldSubcategoryName.'/'.$getOldProductDetails->name;

                    } else {


                        $OldfolderPath = public_path('imgs').'/'.$oldCategoryName.'/'.$getOldProductDetails->name;


                    }
                    // Start Check The Images In Folder And Remove It
                    $checkImgInProductFolder = array_slice(scandir($OldfolderPath), 2);

                    if(count($checkImgInProductFolder) > 0) {
                        foreach($checkImgInProductFolder as $img) {
                            unlink($OldfolderPath.'/'.$img);
                        }
                        rmdir($OldfolderPath);

                    }

                    $newSubcategoryName = SubCategory::where('id' , $newSubcategory_id)->select('name')->first();
                    $newSubcategoryName = $newSubcategoryName->name;

                    $folderPath = public_path('imgs').'/'.$newCategoryName.'/subcategories/'.$newSubcategoryName;
                    mkdir($folderPath.'/'.$productName);

                    $folderOfProduct = public_path('imgs').'/'.$newCategoryName.'/subcategories/'.$newSubcategoryName.'/'.$productName;

                    $imagesArrayName = [];
                    foreach($images as $image) {
                        $imagesArrayName[] = '1020304050'.$image->getClientOriginalName();
                        $image->move($folderOfProduct ,'1020304050'.$image->getClientOriginalName());
                    }

                    // Start Update First Image In Table product_details
                    $firstImageName = $imagesArrayName[0];


                    $updateFirstImage = ProductDetails::where('product_id' , $product_id)->update(['image'=>$firstImageName , 'price' => $price , 'quantity' => $quantity , 'description' => $description]);

                    // Start Insert Other Images In Table product_images
                    if(count($images) > 1) {
                        $otherImagesNames = array_slice($imagesArrayName , 1);

                        // DeleteProductImages And Insert Again
                        $deleteProductImages = ProductImages::where('product_id' , $product_id)->get();
                        //Check If There Is ProductImages Of The Old Product Or Not 
                        if(count($deleteProductImages) > 0) {

                            foreach($deleteProductImages as $deleteProduct) {
                                $deleteTheProduct = ProductImages::find($deleteProduct->id);
                                $deleteTheProduct->delete();
                            }
                        }

                        foreach($otherImagesNames as $otherimage) {

                            $insertOtherImage = new ProductImages;
                            $insertOtherImage->product_id = $product_id;
                            $insertOtherImage->image = $otherimage;
                            $insertOtherImage->save();
                        }
                    } else {
                        
                        // If You Got One Image Only 
                        // DeleteProductImages
                        $deleteProductImages = ProductImages::where('product_id' , $product_id)->get();
                        //Check If There Is ProductImages Of The Old Product Or Not 
                        if(count($deleteProductImages) > 0) {

                            foreach($deleteProductImages as $deleteProduct) {
                                $deleteTheProduct = ProductImages::find($deleteProduct->id);
                                $deleteTheProduct->delete();
                            }
                        }
                    }

                    return 'Success Inserted';

                    // rename("user/image1.jpg", "user/del/image1.jpg");
                    // rename("user/image1.jpg", $folderOfProduct);
                } else {

                    // If There Is No Subcategory In The Request

                    // Start Get Old Category Name
                    $oldCategoryName = Category::where('id' , $getOldProductDetails->category_id)->select('name')->first();
                    $oldCategoryName = $oldCategoryName->name;

                    // Check If Old Product Has subcategory Or Not

                    if($getOldProductDetails->subcategory_id == null) {

                        $OldfolderPath = public_path('imgs').'/'.$oldCategoryName.'/'.$getOldProductDetails->name;

                    } else {

                        // Start Get Old Subcategory Name
                        $oldSubcategoryName = SubCategory::where('id' , $getOldProductDetails->subcategory_id)->select('name')->first();
                        $oldSubcategoryName = $oldSubcategoryName->name;

                        $OldfolderPath = public_path('imgs').'/'.$oldCategoryName.'/subcategories/'.$oldSubcategoryName.'/'.$getOldProductDetails->name;

                    }

                    // Start Check The Images In Folder And Remove It
                    $checkImgInProductFolder = array_slice(scandir($OldfolderPath), 2);

                    if(count($checkImgInProductFolder) > 0) {
                        foreach($checkImgInProductFolder as $img) {

                            unlink($OldfolderPath.'/'.$img);
                        }
                        rmdir($OldfolderPath);

                    }

                    // Start Make New Folder In The newCategoryName
                    $folderPath = public_path('imgs').'/'.$newCategoryName;
                    mkdir($folderPath.'/'.$productName);

                    $folderOfProduct = public_path('imgs').'/'.$newCategoryName.'/'.$productName;

                    $imagesArrayName = [];
                    foreach($images as $image) {
                        $imagesArrayName[] = '1020304050'.$image->getClientOriginalName();
                        $image->move($folderOfProduct ,'1020304050'.$image->getClientOriginalName());
                    }

                    // Start Update First Image In Table product_details
                    $firstImageName = $imagesArrayName[0];


                    $updateFirstImage = ProductDetails::where('product_id' , $product_id)->update(['image'=>$firstImageName , 'price' => $price , 'quantity' => $quantity , 'description' => $description]);

                    // Start Insert Other Images In Table product_images
                    if(count($images) > 1) {
                        $otherImagesNames = array_slice($imagesArrayName , 1);

                        // DeleteProductImages And Insert Again
                        $deleteProductImages = ProductImages::where('product_id' , $product_id)->get();
                        //Check If There Is ProductImages Of The Old Product Or Not 
                        if(count($deleteProductImages) > 0) {

                            foreach($deleteProductImages as $deleteProduct) {
                                $deleteTheProduct = ProductImages::find($deleteProduct->id);
                                $deleteTheProduct->delete();
                            }
                        }

                        foreach($otherImagesNames as $otherimage) {

                            $insertOtherImage = new ProductImages;
                            $insertOtherImage->product_id = $product_id;
                            $insertOtherImage->image = $otherimage;
                            $insertOtherImage->save();
                        }
                    } else {
                        // If You Got One Image Only 

                        // DeleteProductImages
                        $deleteProductImages = ProductImages::where('product_id' , $product_id)->get();
                        //Check If There Is ProductImages Of The Old Product Or Not 
                        if(count($deleteProductImages) > 0) {

                            foreach($deleteProductImages as $deleteProduct) {
                                $deleteTheProduct = ProductImages::find($deleteProduct->id);
                                $deleteTheProduct->delete();
                            }
                        }

                    }
                    // return 'Success Inserted';
                }
            }


        }

    }

    public function searchproduct(Request $request) {

        if($request->ajax()) {

            $validator = \Validator::make($request->all() , [
                'search' => 'required|string'
            ]);

            $search = $request->search;

            $error_array = [];

            if($validator->fails()) {
                foreach ($validator->messages()->getmessages() as $messages) {
                  $error_array[]= $messages;    
                }
                return $error_array;
            }


            $catchProducts = Product::where('name' , 'like' , '%'.$search.'%')->pluck('name');

            // Notes != null For only Vairables And empty() only For Vairables Too

            if(count($catchProducts) > 0) {

                foreach($catchProducts as $product) {

                    echo $product."<br>";
                }

           
            } else {

                return 'No Results Found';
            }



        }

    }

}
