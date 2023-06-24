<?php

namespace App\Http\Controllers;

use App\Models\SearchEngines;
use Illuminate\Http\Request;

class SearchEnginesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SearchEngines::all();

        return $this->render(false, $data, 'Success', 200);
    }
}
