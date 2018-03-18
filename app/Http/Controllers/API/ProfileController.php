<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'user' => Auth::guard('api')->user()
        ], 200);
    }

    /**
     * Show the application dashboard.
     *
     * @param UpdateUserProfileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserProfileRequest $request)
    {
        $user = Auth::guard('api')->user();
        $user->fill($request->all());
        if ($user->save()) {
            return response()->json([
                'message' => 'user updated',
                'user' => $user,
            ], 200);

        }

        return response()->json([
            'message' => 'unable to update user. please try again'
        ], 405);
    }

}
