<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserApiController extends Controller
{

//    public function postUserRead()
//    {
//        $user = UserLogin::all();
//        return response()->json([
//            'message' => 'success',
//            'data' => $user,
//            'status' => true
//        ], 200);
//    }


    public function postUserRegister(Request $request)
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email:rfc,dns|unique:user_logins,email',
            'password' => 'required|min:8',
            'image' => ($request->input('id') == null ? 'required|image' : ''),

        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the following errors',
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }

        // Creating a new user
        $user = new UserLogin();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $file->move('api-images/', $imageName);
            $user->image = $imageName;
        }
        $message = 'User added successfully';

        // Assign values to user object
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->access_token = Str::random(8);
        $user->save();

        return response()->json([
            'message' => $message,
            'id' => $user->id,
            'access_token' => $user->access_token,
            'status' => true
        ], 200);
    }

    public function postUserLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the following errors',
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }

        $ff = UserLogin::where(['email' => $request->email])->first();
        if (!$ff) {
            return response()->json([
                'message' => 'Invalid Email Address',
                'status' => false
            ], 200);
        }

        if (UserLogin::where(['id' => $ff['id']])->first()) {
            $user = UserLogin::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                $user->access_token = Str::random(8);
                $user->save();
                return response()->json([
                    'message' => 'User Login successfully',
                    'id' => $user->id,
                    'access_token' => $user->access_token,
                    'status' => true
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid EmailAddress or Password',
                    'status' => false
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'Invalid id or access token',
                'status' => false
            ], 200);
        }


    }

    public function postUserEdit(Request $request)
    {
        $id = $request->input('id');
        $rules = [
            'id' => 'required',
            'access_token' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email:rfc,dns|unique:user_logins,email,' . $id . ',id',
            'password' => 'required|min:8',
            'image' => ($id === null ? 'required|image' : '')
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the following errors',
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }
        $user = UserLogin::findByIdAndAccessToken($request->id, $request->access_token);
        if($decoded['status'] = json_decode($user) == false){
            return $user;
        }
        $useremail = UserLogin::where('id', $request->id)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'status' => false
            ], 200);
        } else {
            $user = UserLogin::find($id);
            if ($request->hasFile('image')) {
                $userimage = $user->image;
                $imagepath = public_path('api-images/' . $userimage);
                if (file_exists($imagepath)) {
                    unlink($imagepath);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $image = time() . '.' . $extension;
                $file->move('api-images/', $image);
                $user->image = $image;
            }
            $message = 'User updated successfully';
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            return response()->json([
                'message' => $message,
                'id' => $user->id,
                'access_token' => $user->access_token,
                'status' => true
            ], 200);
        }


    }

    public function postUserLogout(Request $request)
    {
        $rules = [
            'id' => 'required',
            'access_token' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the following errors',
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }
        $users = UserLogin::findByIdAndAccessToken($request->id, $request->access_token);
        if($decoded['status'] = json_decode($users) == false){
            return $users;
        }
        $id = $request->input('id');
        $user = UserLogin::find($id);
        if (!$users) {
            return response()->json([
                'message' => 'User not found',
                'status' => false
            ], 200);
        }
        $user->access_token = null;
        $user->save();
        return response()->json([
            'message' => 'User logout successfully',
            'status' => true
        ], 200);
    }

    public function postUserDelete(Request $request)
    {
        $rules = [
            'id' => 'required',
            'access_token' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if (!$validator) {
            return response()->json([
                'message' => 'Please fix the following errors',
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }
        $users = UserLogin::findByIdAndAccessToken($request->id, $request->access_token);
        if($decoded['status'] = json_decode($users) == false){
            return $users;
        }
        $id = $request->input('id');
        $user = UserLogin::find($id);
        $deleteuserimage = $user->image;
        $deleteuserimagepath = public_path('api-images/' . $deleteuserimage);
        if (file_exists($deleteuserimagepath)) {
            unlink($deleteuserimagepath);
        }
        if (!$users) {
            return response()->json([
                'message' => 'User not found',
                'status' => false
            ], 200);
        }
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
            'status' => true
        ], 200);

    }
}
