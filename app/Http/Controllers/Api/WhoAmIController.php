<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhoAmIController extends Controller
{
    public function index()
    {
        return Auth::user();
    }
}
