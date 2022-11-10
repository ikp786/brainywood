<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Blog;


class BlogController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Blog::where('deleted',0)->orderBy('id', 'DESC')->get();

		return view('admin.blogs.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.blogs.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// print_r($request->all());die;
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'description' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//print_r($request->all());die;
			$file = $request->file('image');
			if($file){
				$destinationPath = public_path().'/upload/blogs/';
				$originalFile = $file->getClientOriginalName();
				$filename_image = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename_image);
			}

			$slug_url = Str::slug($request->get('title'));
			$checkslug = Blog::where('slug_url', $slug_url)->first();
			if (!empty($checkslug)) {
				$slug_url = $slug_url.'-'.time();
			}
			$blog = new Blog();
			$blog->title = $request->get('title');
			$blog->slug_url = $slug_url;
			$blog->image = $filename_image;
			$blog->description = $request->get('description');
			$blog->author = 'Admin'; //$request->get('author');
			$blog->meta_title = ($request->get('meta_title')) ? $request->get('meta_title') : $request->get('title');
			$blog->meta_description = $request->get('meta_description');
			$blog->status = 1;
			$blog->save();
			$blogId=$blog->id;
			
			\Session::flash('msg', 'Blog Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Blog $blogs
	 * @return \Illuminate\Http\Response
	 */
	public function show(Blog $blogs)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Blog $blogs
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Blog $blogs, $id)
	{
		$blog = Blog::findOrFail($id);

		return view('admin.blogs.edit',compact('blog'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Blog $blogs
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Blog $blogs, $id)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'description' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {
			$blog = Blog::findOrFail($id);

			$file = $request->file('image');
			if($file){
				$destinationPath = public_path().'/upload/blogs/';
				$originalFile = $file->getClientOriginalName();
				$filename_image = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename_image);
			}else{
				$filename_image = $blog->image;  
			}

			$slug_url = Str::slug($request->get('title'));
			$checkslug = Blog::where('id', '!=', $id)->where('slug_url', $slug_url)->first();
			if (!empty($checkslug)) {
				$slug_url = $slug_url.'-'.time();
			}
			$blog->title = $request->get('title');
			$blog->slug_url = $slug_url;
			$blog->image = $filename_image;
			$blog->description = $request->get('description');
			$blog->author = 'Admin'; //$request->get('author');
			$blog->meta_title = $request->get('meta_title');
			$blog->meta_description = $request->get('meta_description');
			$blog->status = 1;
			$blog->save();
			$blogId=$id;
			
			\Session::flash('msg', 'Blog Updated Successfully.');
			return redirect('/admin/blogs');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Blog $blogs
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$blog = Blog::findOrFail($id);
		$blog->deleted=1;
		$blog->update();

	   return redirect('/admin/blogs');
	}

	public function updateStatus($id,$status)
	{
		//echo "string";die;
		$blog = Blog::findOrFail($id);
		$blog->status=$status;
		$blog->update();

	   return redirect('/admin/blogs');
	}

	public function imgremove($id)
	{
		$blog = Blog::findOrFail($id);
		if(file_exists( public_path().'/upload/blogs/'.$blog->image )) {
			unlink( public_path().'/upload/blogs/'.$blog->image );
		}
		$blog->image = NULL;
		$blog->update();

		\Session::flash('msg', 'Blog Image Removed Successfully.');
	    return redirect()->back();
	}

}