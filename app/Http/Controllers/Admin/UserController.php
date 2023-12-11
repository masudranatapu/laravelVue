<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    //

    public function index()
    {
        try {
            $users = User::latest()->paginate(30);
            return UserResource::collection($users);
        } catch (Exception $e) {
            return response()->json([
                'type' => 'Error',
                // 'massage'=> $e->getMassage(),
            ]);
        }
    }
}
