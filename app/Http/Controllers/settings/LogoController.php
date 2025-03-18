<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Logo_title;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:logo.list'])->only(['list']);
        $this->middleware(['permission:logo.create'])->only(['create','store']);
        $this->middleware(['permission:logo.edit'])->only(['edit','update']);
        $this->middleware(['permission:logo.delete'])->only(['delete']);
    }

    public function list()
    {
        $data['pre_logo'] = Logo_title::orderBy('id','desc')->get();
        $data['active'] = count(Logo_title::where('status','1')->get());
        $data['inactive'] = count(Logo_title::where('status','!=','1')->get());
        return view('dashboard.setting.logo.logo_list')->with($data);
    }

    public function create()
    {

        $logo_count = count(Logo_title::orderBy('id', 'desc')->get());

        if($logo_count>0){
            return redirect()->back()->with('error', 'New logo Title Added Failed');
        }else{
            return view('dashboard.setting.logo.create_logo');
        }

    }


    public function store(Request $request)
    {
        $request->validate([
            'logo_image' => 'mimes:jpg,png|max:1024',
            'favicon' => 'mimes:ico,png|max:1024',
            'website_name' => 'max:100',
            'address' => 'max:100',
            'contact_number' => 'max:16|min:10|nullable',
        ]);
        $filename='';
        $pre_logo = new Logo_title();
        if (isset($request->logo_image)) {
            $filename = time() . '.' . $request->file('logo_image')->getClientOriginalExtension();
            Storage::putFileAs('public/logo_image', $request->file('logo_image'), $filename);
        }
        $pre_logo->logo_image = $filename;

        $filename_favicon = '';
        if (isset($request->favicon)) {
            $filename_favicon = time() . '.' . $request->file('favicon')->getClientOriginalExtension();
            Storage::putFileAs('public/favicon', $request->file('favicon'), $filename_favicon);
        }
        $pre_logo->favicon = $filename_favicon;

        $pre_logo->website_name = $request->website_name;
        $pre_logo->address = $request->address;
        $pre_logo->contact_number = $request->contact_number;
        $pre_logo->email = $request->email;
        $pre_logo->web_url = $request->web_url;
        $pre_logo->validity_date = $request->validity_date;

        $pre_logo->added_by = Auth::user()->id;
        $pre_logo->updated_by = Auth::user()->id;
        $pre_logo->status = ( $request->status !='' ? '1':'0');
        $pre_logo->save();

        if ($pre_logo) {
            return redirect()->route('setting.logo_list')->with('success', 'Logo added Successfully');
        } else {
            return redirect()->back()->with('error', 'Logo added Failed');
        }
    }


    public function edit($id)
    {
        $pre_logo = Logo_title::find($id);
        return view('dashboard.setting.logo.create_logo', compact('pre_logo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo_image' => 'mimes:jpg,png|max:1024',
            'favicon' => 'mimes:ico,png|max:1024',
            'website_name' => 'max:100',
            'address' => 'max:100',
            'contact_number' => 'max:16|min:10|nullable',
        ]);

        $pre_logo = Logo_title::find($id);
        if (isset($request->logo_image)) {

            $filename = time() . '.' . $request->file('logo_image')->getClientOriginalExtension();

            Storage::putFileAs('public/logo_image', $request->file('logo_image'), $filename);
            //remove old image
            if ($request->previous_image) {
                $old_filename = public_path("storage\logo_image\\" . $request->previous_image);
                if (file_exists($old_filename) != false) {
                    unlink($old_filename);
                }
            }
        } else {
            $filename = $request->previous_image;
        }
        $pre_logo->logo_image = $filename;

        // favicon

        if (isset($request->favicon)) {

            $filename_favicon = time() . '.' . $request->file('favicon')->getClientOriginalExtension();

            Storage::putFileAs('public/favicon', $request->file('favicon'), $filename_favicon);
            //remove old image
            if ($request->previous_favicon) {
                Storage::delete('public/favicon/' . $request->previous_favicon);
            }
        } else {
            $filename_favicon = $request->previous_favicon;
        }
        $pre_logo->favicon = $filename_favicon;

        $pre_logo->website_name = $request->website_name;
        $pre_logo->address = $request->address;
        $pre_logo->contact_number = $request->contact_number;
        $pre_logo->email = $request->email;
        $pre_logo->web_url = $request->web_url;
        $pre_logo->validity_date = $request->validity_date;

        $pre_logo->updated_by = Auth::user()->id;
        $pre_logo->status = ( $request->status !='' ? '1':'0');
        $pre_logo->update();

        if ($pre_logo) {
            return redirect()->route('setting.logo_list')->with('success', 'Logo Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Logo Updated Failed');
        }
    }


    public function delete($id)
    {
        $pre_logo = Logo_title::find($id)->first();

        if ($pre_logo->logo_image) {
            $old_filename = public_path("storage\logo_image\\" . $pre_logo->logo_image);
            if (file_exists($old_filename) != false) {
                unlink($old_filename);
            }
        }
        // favicon

        if (!is_null($pre_logo)) {
            Storage::delete('public/favicon/' . $pre_logo->favicon);
        }
        $pre_logo->delete();

        if ($pre_logo) {
            return redirect()->route('setting.logo_list')->with('success', 'Logo Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Deleted added Failed');
        }
    }
}

