<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\SubCategory;
class CategoryController extends Controller
{

    public function addcategory(Request $request) {


        if(\Auth::user()->type != '1') {

        	return redirect('/homepage');
        	
        }

        $validator = \Validator::make($request->all() , [
            
            'categoryname'     => 'required|regex:/(^(([a-zA-Z]+)([0-9]+)?(\s+)?)+$)/u', // Accepts strings and spaces and string with numbers(test test123)
            'subcat'      => 'nullable|array', 
            'subcat.*'    => 'nullable|regex:/(^(([a-zA-Z]+)([0-9]+)?(\s+)?)+$)/u'
        ]);

        if($validator->fails()) {

        	 return ['message'=>'Please Fill The Inputs In Right Way'];
        }



        // Start make Folder For Category
        if($request->ajax()) {
	        $category 	= $request->categoryname;
	        if($request->multi_subcat != '0') {
	        	//Then Theres is subcategories
	        	$subcat = explode('-', $request->multi_subcat);

	        } else {
	        	$subcat = '0';
	        }
	        $theFolder = public_path('imgs').'/'.$category;

	        if(is_dir($theFolder)) {

	        	return ['message' => 'This Category Is Already Exists'];

	        } else {
	         	// return ['message' => 'continue'];
	        	$makeCategoryFolder = mkdir($theFolder);
	        	$insertCatNameInDB = new Category;
	        	$insertCatNameInDB->name = $category;
	        	$insertCatNameInDB->save();

	        	if($request->multi_subcat != '0') {
	        		mkdir($theFolder.'/subcategories');
	        		$subFolder = public_path('imgs').'/'.$category.'/subcategories';
	        		foreach($subcat as $sub) {
		        		$insideSubFolder = $subFolder.'/'.$sub;
		        		$makeSubCategoryFolder = mkdir($insideSubFolder);
			        	$insertSubCatNameInDB = new SubCategory;
			        	$insertSubCatNameInDB->name = $sub;
			        	$insertSubCatNameInDB->category_id = $insertCatNameInDB->id;
			        	$insertSubCatNameInDB->save();	        		
	        		}
	        	} 

	        	$allCats = Category::with('subcategory')->get();
	        	return ['message'=>'Success Inserted' , 'getcategoryajax' => view('admin.getcategories_ajax' , compact('allCats'))->render()];
	        }        	
        }
    }


    public function delete_category(Request $request) {


        if(\Auth::user()->type != '1') {

        	return redirect('/homepage');
        	
        }


        $validator = \Validator::make($request->all() , [
            
            'category_id'     => 'required|integer|exists:categories,id'
        ]);

        if($validator->fails()) {

        	 return 'error';
        }

        $catId = $request->category_id;

        // Start Find Category From Database 

        $getCat = Category::find($catId);

        if($getCat != null) {

			$theFolder = public_path('imgs').'/'.$getCat->name;

			if(is_dir($theFolder)) {
				// Check If There Is Subcategories
				$checkSub =  array_slice(scandir($theFolder), 2);
				if(count($checkSub) == 1 && $checkSub[0] == 'subcategories') {
					//Means There Is Subcategories
					$theSubCatFolder = public_path('imgs').'/'.$getCat->name.'/subcategories';
					if(is_dir($theSubCatFolder)) {
						// Get Subcategories Names
						$subNames =  array_slice(scandir($theSubCatFolder), 2);
						// return $subNames;
						foreach($subNames as $catName) {
							$subcatsFolder = public_path('imgs').'/'.$getCat->name.'/subcategories/'.$catName;

							$checkProductsInSub =  array_slice(scandir($subcatsFolder), 2);
							foreach($checkProductsInSub as $productfolder) {
								$oneProductFolder = public_path('imgs').'/'.$getCat->name.'/subcategories/'.$catName.'/'.$productfolder;
								$checkImgInProductFolder = array_slice(scandir($oneProductFolder), 2);

								if(count($checkImgInProductFolder) > 0) {
									foreach($checkImgInProductFolder as $img) {
										unlink($oneProductFolder.'/'.$img);
									}
									rmdir($oneProductFolder);
								} else {
									//Means Folder is Empty 
									rmdir($oneProductFolder);
								}
							}
							//Remove SubCategory Folder
							rmdir($subcatsFolder);
						}
						// Remove The Folder Named subcategories
						rmdir($theSubCatFolder);

					}
					//Remove The Category Folder
					rmdir($theFolder);
					$getCat->delete();
					
		        	$allCats = Category::with('subcategory')->get();
		        	return ['getcategoryajax' => view('admin.getcategories_ajax' , compact('allCats'))->render()];
				} else {
					// Means No Subcategories 
					// return $checkSub;
					foreach($checkSub as $productfolder) {
						// Start Get Directory Of Every Product
						$everyProductFolder = public_path('imgs').'/'.$getCat->name.'/'.$productfolder;

						// get Every Product Folder Details
						$checkImgInProductFolder =  array_slice(scandir($everyProductFolder), 2);

						// return $checkImgInProductFolder;
						if(count($checkImgInProductFolder) > 0) {

								foreach($checkImgInProductFolder as $img) {
									unlink($everyProductFolder.'/'.$img);
								}
								//Remove Product Folder 
								rmdir($everyProductFolder);
													
						} else {
								//Remove Product Folder 
								rmdir($everyProductFolder);
						}
					}
					// Delete The Category Folder
					rmdir($theFolder);
					// Delete Category From Database	
					$getCat->delete();

		        	$allCats = Category::with('subcategory')->get();
		        	return ['getcategoryajax' => view('admin.getcategories_ajax' , compact('allCats'))->render()];

				}
			}


        }
    	
    }

    public function addsubcat(Request $request) {


        if(\Auth::user()->type != '1') {

        	return redirect('/homepage');
        	
        }


         $validator = \Validator::make($request->all() , [
            
            'category_id'	=> 'required|integer|exists:categories,id',
            'subcatname'	=> 'required|string'		
        ]);

        if($validator->fails()) {

        	 return 'error';
        }

        if($request->ajax()) {

	        $catId = $request->category_id;

	        // Start Find Category From Database 
	        $getCat = Category::find($catId);

	        if($getCat != null) {
	        	$insertSub = SubCategory::create([
	        		'name' => $request->subcatname,
	        		'category_id' => $request->category_id
	        	]);

	        	if($insertSub) {
	        		$subcatFolderPath = public_path('imgs').'/'.$getCat->name.'/subcategories/'.$request->subcatname;
	        		$checksubcategoriesFolder = public_path('imgs').'/'.$getCat->name.'/subcategories';

	        		if(! is_dir($checksubcategoriesFolder)) {
	        			mkdir($checksubcategoriesFolder);
	        		}

	        		$createSubcatFolder = mkdir($subcatFolderPath);


		        	$allCats = Category::with('subcategory')->get();
		        	return ['getcategoryajax' => view('admin.getcategories_ajax' , compact('allCats'))->render()];
	        	}
	        }

        }  
         	
    }



    public function deletesubcat(Request $request) {


        if(\Auth::user()->type != '1') {

        	return redirect('/homepage');
        	
        }


         $validator = \Validator::make($request->all() , [
            
            'subcat_id'	=> 'required|integer|exists:sub_categories,id',
            'categoryname' => 'required|string|exists:categories,name'
        ]);

        if($validator->fails()) {

        	 return 'error';
        }

        if($request->ajax()) {

        	$subcat_id = $request->subcat_id;
        	$categoryname = $request->categoryname;
        	// Start Remove Sub Category From Database 

        	$remove = SubCategory::find($subcat_id);

        	if($remove) {
        	// Start Remove Sub Category Folder 
 				$subcatFolderPath = public_path('imgs').'/'.$categoryname.'/subcategories/'.$remove->name;

 				if(is_dir($subcatFolderPath)) {
					// checkImgInProductFolder
					$checkImgInProductFolder =  array_slice(scandir($subcatFolderPath), 2);

					if(count($checkImgInProductFolder) > 0) {

						foreach($checkImgInProductFolder as $img) {
							unlink($subcatFolderPath."/".$img);
						}
						rmdir($subcatFolderPath);
					} else {
						rmdir($subcatFolderPath);
					}
 				}

				$remove->delete();
        	}

	        	$allCats = Category::with('subcategory')->get();
	        	return ['getcategoryajax' => view('admin.getcategories_ajax' , compact('allCats'))->render()];


        }
    }

 }
