<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Url;

class UrlsController extends Controller
{
    public function Create(){
    	 return view('welcome');
    }
    /////////////////////////////////////////////////////////

    public function Store(Request $request)
    {
	    $data  = ['url'=> request('url')];

		/*Validator::make($data, 
			['url' => 'required|url'],
			['required' => 'Ce champs est requis',
			'url' => 'URL invalide']
		)->validate();*/

		$this->validate($request, ['url' => 'required|url']);

		/*if($validation->fails()){
			dd('Failed');
		}else{
			dd('success');
		}*/
		//dd();

		//Verifier si url a été raccourcie
		$url = Url::where('url',request()->get('url'))->first();

		if ($url){
			return view('result')->with('shortened', $url->shortened);
		}

		function getUniqueShortUrl(){
			$shortened = str_random(5);
			if(Url::where('shortened', $shortened)->count() != 0){
				return getUniqueShortUrl();
			}
			return $shortened;
		}
		//Creer un nouvel url à raccourcir
		$url = Url::create([
			'url' => request('url'),
			'shortened' => getUniqueShortUrl()
		]);

		if($url){
			return view('result')->with('shortened', $url->shortened);
		}
    }

    //////////////////////////////////////////////////////////

    public function show($shortened){
    	$url = Url::where('shortened', $shortened) ->first();

	   if (!$url){
	   		return redirect('/');
	   }
	   else{
	   	return redirect($url->url);
	   }
    }
    //////////////////////////////////////////////////////////
}
