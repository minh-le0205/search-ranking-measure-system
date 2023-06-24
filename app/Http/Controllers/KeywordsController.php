<?php

namespace App\Http\Controllers;

use App\Models\Keywords;
use Illuminate\Http\Request;

class KeywordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Keywords::all();

        return $this->render(false, $data, 'Success', 200);
    }
}
