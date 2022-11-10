<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Page;


class PageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Page::where('deleted',0)->orderBy('id', 'DESC')->get();

		return view('admin.pages.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.pages.create');
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
			'content' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//print_r($request->all());die;
				
			$page = new Page();
			$page->title = $request->get('title');
			$page->slug_url = Str::slug($request->get('title'));
			$page->content = $request->get('content');
			$page->meta_title = $request->get('meta_title');
			$page->meta_description = $request->get('meta_description');
			$page->status = 1;
			$page->save();
			$pageId=$page->id;
			
			\Session::flash('msg', 'Page Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Page  $pages
	 * @return \Illuminate\Http\Response
	 */
	public function show(Page $pages)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Page  $pages
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Page $pages, $id)
	{
		$page = Page::findOrFail($id);

		return view('admin.pages.edit',compact('page'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Page  $pages
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Page $pages, $id)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'content' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {
			$page = Page::findOrFail($id);
			$page->title = $request->get('title');
			$page->slug_url = Str::slug($request->get('title'));
			$page->content = $request->get('content');
			$page->meta_title = $request->get('meta_title');
			$page->meta_description = $request->get('meta_description');
			$page->status = 1;
			$page->save();
			$pageId=$id;
			
			\Session::flash('msg', 'Page Updated Successfully.');
			return redirect('/admin/pages');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Page  $pages
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$page = Page::findOrFail($id);
		$page->deleted=1;
		$page->update();

	   return redirect('/admin/pages');
	}

	public function updateStatus($id,$status)
	{
		//echo "string";die;
		$page = Page::findOrFail($id);
		$page->status=$status;
		$page->update();

	   return redirect('/admin/pages');
	}

}