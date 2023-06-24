<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Keywords;
use App\Models\Rankings;
use App\Models\SearchResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Domain::all();

        return $this->render(false, $data, 'Success', 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $result = [];
        try {
            $data = Domain::where('id', $request->id)->get();

            if (count($data) == 0)
                throw new \Exception("Data with the ID $request->id is not found");
            $result = $this->render(false, $data, 'Success');
        } catch (\Exception $e) {
            $result = $this->render(true, [], $e->getMessage(), 404);
        }

        return $result;
    }

    public function getUrlRankings(Request $request)
    {
        $formData = $request->all();
        $rules = [
            'url' => 'required|url',
            'keywords' => 'required|array|max:5',
        ];

        $messages = [
            'url.required' => 'Please enter a specific url',
            'url.url' => 'Please enter a correct url format',
            'keywords.required' => 'Please enter specific keywords',
            'keywords.max' => 'The maximum number of keywords is 5',
        ];

        $validator = Validator::make($formData, $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->messages();
            $errors = $messages->all();
            return $this->render(true, [], $errors, 500);
        }

        $result = [];
        $data = [];

        try {
            $urlValidate = Domain::query()->where('content', $formData['url'])->get(['id', 'domain_name', 'content']);
            if (count($urlValidate) == 0)
                throw new Exception("The URL is not found");
            $keywordResult = DB::table('keywords as k')
                ->join('rankings as r', 'r.keyword_id', '=', 'k.id')
                ->join('search_results as sr', 'sr.keyword_id', '=', 'k.id')
                ->join('search_engines as se', function ($join) {
                    $join->on('se.id', '=', 'r.search_engine_id');
                    $join->on('se.id', '=', 'sr.search_engine_id');
                })
                ->join('urls as u', 'u.id', '=', 'k.url_id')
                ->whereIn('k.value', $formData['keywords'])
                ->select(
                    'k.value as keyword',
                    'se.name as search_engine_name',
                    DB::raw('IF ( r.`value` > 20, "out of rank", r.`value` ) AS rank_value'),
                    'sr.volume as search_volume'
                )
                ->get()->toArray();
            $data['url_info'] = $urlValidate;
            $data['keywords_results'] = $keywordResult;

            $result = $this->render(false, $data, 'Success', '200');
        } catch (Exception $e) {
            $result = $this->render(true, [], $e->getMessage(), 404);
        }

        return $result;
    }
}
