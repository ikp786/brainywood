<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Portfolio;


class PortfolioController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Portfolio::where("deleted", 0)->orderBy("id", "DESC")->get();

		return view('admin.portfolios.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.portfolios.create');
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
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//print_r($request->all());die;
			$file = $request->file('image');

			if($file){
				$destinationPathfile = public_path().'/upload/portfolios/';
				$originalFile = $file->getClientOriginalName();
				$filename=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPathfile, $filename);
			}
				
			$portfolio = new Portfolio();
			$portfolio->title = $request->get('title');
			$portfolio->sub_title = $request->get('sub_title');
			$portfolio->image = $filename;
			$portfolio->select_row = $request->get('select_row');
			$portfolio->save();
			$portfolioId=$portfolio->id;
			
			\Session::flash('msg', 'Portfolio Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Portfolio $portfolio
	 * @return \Illuminate\Http\Response
	 */
	public function show(Portfolio $portfolio)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Portfolio $portfolio
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Portfolio $portfolio, $id)
	{
		$portfolio = Portfolio::findOrFail($id);

		return view('admin.portfolios.edit',compact('portfolio'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Portfolio $portfolio
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Portfolio $portfolio, $id)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {
			//echo '<pre />'; print_r($request->all()); die;
			$portfolio = Portfolio::findOrFail($id);

			$file = $request->file('image');

			if($file){
				$destinationPathfile = public_path().'/upload/portfolios/';
				$originalFile = $file->getClientOriginalName();
				$filename=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPathfile, $filename);
			}else{
			   $filename=$portfolio->image;
			}

			$portfolio->title = $request->get('title');
			$portfolio->sub_title = $request->get('sub_title');
			$portfolio->image = $filename;
			$portfolio->select_row = $request->get('select_row');
			$portfolio->save();
			$portfolioId=$id;
			
			\Session::flash('msg', 'Portfolio Updated Successfully.');
			return redirect('/admin/portfolios');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Portfolio $portfolio
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$portfolio = Portfolio::findOrFail($id);
		$portfolio->deleted=1;
		$portfolio->update();

	   return redirect('/admin/portfolios');
	}

	public function updateStatus($id,$status)
	{
		//echo "string";die;
		$portfolio = Portfolio::findOrFail($id);
		$portfolio->status=$status;
		$portfolio->update();

	   return redirect('/admin/portfolios');
	}

}