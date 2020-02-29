<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponder;
use App\Users;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller;

class UsersController extends Controller
{
    use ApiResponder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $users = Users::all();

        return $this->validResponse($users, Response::HTTP_OK);
    }

    public function store(Request $request) :string
    {

        $rules = [
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ];

        $this->validate($request, $rules);
        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        $user = Users::create($fields);

        return $this->validResponse($user, Response::HTTP_CREATED);
    }

    public function show($book) :string
    {
        $user = Users::findOrFail($book);

        return $this->validResponse($book);
    }

    public function update(Request $request, $user) :string
    {
        $rules = [
            'name'     => 'max:255',
            'email'    => 'email|unique:user,email,'.$user,
            'password' => 'confirmed|min:8',
        ];

        $this->validate($request, $rules);
        $user = Users::findOrFail($user);

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->fill($request->all());

        if ($user->isClean()) {
            return $this->errorResponse('At least one value should change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->validResponse($user, Response::HTTP_CREATED);
    }

    public function destroy($user) :string
    {
        $user = Users::findOrFail($user);
        $user->delete();

        return $this->validResponse($user);
    }

    public function me(Request $request) :JsonResponse
    {
        return $this->validResponse($request->user());
    }
}
