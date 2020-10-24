<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * To show the user creation form
     */
    public function createUser()
    {
        return view('create');
    }

    /**
     * User Listng Api
     */
    public function index()
    {
        try {
            // Get file data from our user file
            $fileData = file_get_contents(storage_path('app') . '/users.txt');

            // Get File Data as Collection from the file 
            $usersData = collect(json_decode($fileData, true));

            return response(['status' => true, 'data' => $usersData], 200);
        } catch (Exception $e) {
            info($e);

            return response(['status' => false, 'message' => 'Error'], 500);
        }
    }

    /**
     * New User save data api 
     */
    public function save(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'email' => 'required|email',
                'first_name' => 'required',
                'last_name' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['errors' => $validator->errors(), 'status' => false, 'message' => 'Error'], 422);
            }

            // Get User Data as Collection fron the file
            $usersData = collect(json_decode(file_get_contents(storage_path('app') . '/users.txt'), true));

            // Finding if email already exist in the collection.
            $existingEmail = $usersData->where('email', $request->email)->first();
            if ($existingEmail) {
                return response(['errors' => ['email' => 'Email already Exist'], 'status' => false, 'message' => 'Email already exist.'], 422);
            }

            $newIndexId = 1;
            if ($usersData && count($usersData) > 0) {
                $newIndexId = count($usersData) + 1;
            }


            $data = [
                'id' => $newIndexId,
                'username' => $request->username,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => bcrypt($request->password),
            ];

            $usersData[] = $data;

            Storage::disk('local')->put('users.txt', json_encode($usersData));

            return response(['status' => true, 'data' => $data['id']], 200);
        } catch (Exception $e) {
            info($e);

            return response(['status' => false, 'message' => 'Error'], 500);
        }
    }

    /**
     * Edit user Api
     */
    public function edit($id, $request)
    {
        try {
            // Get User Data as Collection fron the file
            $usersData = collect(json_decode(file_get_contents(storage_path('app') . '/users.txt'), true));

            // Finding the user iin the collection on the basis of id.
            $existingUser = $usersData->where('id', $id)->first();

            if (!$existingUser) {
                return response(['errors' => ['error' => 'Not Found'], 'status' => false, 'message' => 'Error'], 422);
            }


            //  Updating key as per the key exist in our payload.
            if ($request->username) {
                $existingUser['username'] = $request->username;
            }
            if ($request->email) {
                $existingUser['email'] = $request->email;
            }
            if ($request->first_name) {
                $existingUser['first_name'] = $request->first_name;
            }
            if ($request->last_name) {
                $existingUser['last_name'] = $request->last_name;
            }
            if ($request->password) {
                $existingUser['password'] = bcrypt($request->password);
            }

            // Replacing older collection user data with the new data for updated user.
            $usersData->map(function ($user) use ($id, $existingUser) {
                if ($user['id'] == $id) {
                    //Replace updated user data in the current collection
                    return $existingUser;
                }
                //return normakl data without any change.
                return $user;
            });

            // Storing back all data to the file
            Storage::disk('local')->put('users.txt', json_encode($usersData));

            return response()->json(['data' => $existingUser['id']], 200);
        } catch (Exception $e) {
            info($e);

            return response(['status' => false, 'message' => 'Error'], 500);
        }
    }
}
