<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Models\UserModel;
use http\Env\Response;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function detail()
    {
        return view('detail');
    }

    public function form()
    {
        return view('form');
    }

    public function displayusers()
    {
        return view('displayuser');
    }

    public function userlist(Request $request)
    {
        if ($request->ajax()) {
            $data = UserModel::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="d-flex justify-content-center"> <a href="' . route('edit', $row['id']) . '" class="edit btn btn-primary btn-sm edit-user" data-id="' . $row['id'] . '" title="Edit User"><i class="bi bi-pencil-square me-1 "></i>Edit</a>
                                  <a><button class="delete btn btn-danger btn-sm delete ms-2" data-id="' . $row['id'] . '" title="Delete User"><i class="bi bi-trash-fill me-1"></i>Delete</button></a>
                                  </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function save(UserRequest $request)
    {
        $id = $request->id;
        if ($id === null) {
            $hobbies = implode(",", $request->hobbies);
            if ($request->hasFile('image')) {

                //resize image manager
                $manager = new ImageManager(new Driver());

                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $imageName = time() . '.' . $extension;

                //resize image with intervention image
                $filetostore = $manager->read($request->file('image'));
                $filetostore = $filetostore->resize(500, 500);
                $filetostore->save('images/resizeimages/' . $imageName);
                $file->move('images/', $imageName);
            }
            $haspassword = Hash::make($request->password);
            $users = new UserModel();
            $users->username = $request->username;
            $users->useremail = $request->email;
            $users->userpassword = $haspassword;
            $users->usercontact = $request->contactnumber;
            $users->useraddress = $request->address;
            $users->usergender = $request->gender;
            $users->userhobbies = $hobbies;
            $users->usercountry = $request->country;
            $users->userimage = $imageName;
            $users->location = $request->search;
            $users->lat = $request->lat;
            $users->lon = $request->lng;
            $users->save();
            if ($users) {
//                return response()->json(['message' => 'success']);
                return redirect()->route('displayusers');
            } else {
                echo "Error";
            }

        } else {
            $hobbies = implode(",", $request->hobbies);
            if ($request->hasFile('image')) {
                $user_img = UserModel::find($id);
                $userimg = $user_img->userimage;
                $imagepath = public_path('images/' . $userimg);
                $resizeimagepath = public_path('images/resizeimages/' . $userimg);
                if (file_exists($imagepath) && file_exists($resizeimagepath)) {
                    unlink($imagepath);
                    unlink($resizeimagepath);
                }
                //resize image manager
                $manager = new ImageManager(new Driver());

                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $image = time() . '.' . $extension;

                //resize image with intervention image
                $filetostore = $manager->read($request->file('image'));
                $filetostore = $filetostore->resize(500, 500);
                $filetostore->save('images/resizeimages/' . $image);
                $file->move('images/', $image);


            } else {
                $student = UserModel::find($id);
                $image = $student->userimage;
            }
            $users = UserModel::find($id);
            $users->username = $request->username;
            $users->useremail = $request->email;
            $users->userpassword = Hash::make($request->password);
            $users->usercontact = $request->contactnumber;
            $users->useraddress = $request->address;
            $users->usergender = $request->gender;
            $users->userhobbies = $hobbies;
            $users->usercountry = $request->country;
            $users->userimage = $image;
            $users->location = $request->search;
            $users->lat = $request->lat;
            $users->lon = $request->lng;
            $users->save();
            if ($users) {
//                return response()->json(['message' => 'success']);
                return redirect()->route('displayusers');
            } else {
                echo "Error";
            }
        }
    }

    public function edit(Request $req)
    {
        $student = $req->id;
//        dd($student);
        $students = UserModel::find($student);
        return view('form', ['student' => $students]);
    }

    public function delete($id)
    {
        $delete_image = UserModel::find($id);
        $deleteimage = $delete_image->userimage;
        $deleteimagepath = public_path('images/' . $deleteimage);
        $deleteresizeimagepath = public_path('images/resizeimages/' . $deleteimage);
        if (file_exists($deleteimagepath) && file_exists($deleteresizeimagepath)) {
            unlink($deleteimagepath);
            unlink($deleteresizeimagepath);
        }
        UserModel::find($id)->delete();
        return response()->json(['message' => 'success']);

    }
}
