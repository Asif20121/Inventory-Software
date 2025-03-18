<?php
namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Auth;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:category.list'])->only(['list']);
        $this->middleware(['permission:category.create'])->only(['create','store']);
        $this->middleware(['permission:category.edit'])->only(['edit','update']);
        $this->middleware(['permission:category.delete'])->only(['delete']);
    }

    public function list(){
        $data['category'] = Category::orderBy('id','desc')->get();
        $data['active'] = count(Category::where('status','1')->get());
        $data['inactive'] = count(Category::where('status','!=','1')->get());
        return view('dashboard.setting.category.category_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.category.create_category');
    }

    public function store(Request $request){
        $request->validate([
            'category_name' => 'required|max:100|nullable',
        ]);
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->added_by = Auth::user()->id;
        $category->updated_by = Auth::user()->id;
        $category->status = ( $request->status !='' ? '1':'0');
        $category->save();

        if ($category) {
            return redirect()->route('invoice_setting.category_list')->with('success', 'Category added Successfully');
        } else {
            return redirect()->back()->with('error', 'Category added Failed');
        }
    }

    public function edit($id){
        $category = Category::find($id);
        return view('dashboard.setting.category.create_category',compact('category'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'category_name' => 'required|max:100|nullable',
        ]);
        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->updated_by = Auth::user()->id;
        $category->status = ( $request->status !='' ? '1':'0');
        $category->update();

        if ($category) {
            return redirect()->route('invoice_setting.category_list')->with('success', 'Category updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Category updated Failed');
        }

    }

    public function delete($id){
        $count = Product::where('unit_id', $id)->get()->count();
        if ($count == 0) {
            $category = Category::find($id)->delete();
            if ($category) {
                return redirect()->route('invoice_setting.category_list')->with('success', 'Category Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Category Deleted Failed');
            }
        }
        return redirect()->back()->with('error', 'Category Already Use in Another Module');
    }
}

