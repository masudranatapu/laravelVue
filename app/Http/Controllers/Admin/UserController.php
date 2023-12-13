<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'massage' => $e->getMessage(),
            ]);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $users = new User();
            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = Hash::make($request->password);
            $users->phone = $request->phone;
            $users->address = $request->address;
            $users->save();
            DB::commit();

            return response()->json([
                'type' => 'Success',
                'massage' => 'User successfully created',
                'data' => $users,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'type' => 'Error',
                'massage' => $e->getMessage(),
            ]);
        }
    }
}
