<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{

	/**
	 *  returns financialreviews news
	 * @return view
	 */
	public function financialreview()
	{
		return view('news.financialreview');
	}

	/**
	 *  returns startupsmart news
	 * @return view
	 */
	public function startupsmart()
	{
		return view('news.startupsmart');
	}

	/**
	 *  returns crowdfundinsider news
	 * @return view
	 */
	public function crowdfundinsider()
	{
		return view('news.crowdfundinsider');
	}

	/**
	 *  returns realestatebusiness news
	 * @return view
	 */
	public function realestatebusiness()
	{
		return view('news.realestatebusiness');
	}

	/**
	 *  returns startup88 news
	 * @return view
	 */
	public function startup88()
	{
		return view('news.startup88');
	}

	/**
	 *  returns startupdaily news
	 * @return view
	 */
	public function startupdaily()
	{
		return view('news.startupdaily');
	}

}
