<?php

namespace App\Http\Controllers;

use App\Jobs\ActiveUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function list(Request $request) {
        $userId = auth()->user()->id;
        $userList = User::where('id', '<>', $userId)->select();

        if ($request->has('name')) {
            $userList->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('email')) {
            $userList->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->has('role')) {
            $userList->where('role', 'like', '%' . $request->role . '%');
        }
        if ($request->has('created_at')) {
            $userList->where('created_at', 'like', '%' . $request->created_at . '%');  
        }
        if ($request->has('updated_at')) {
            $userList->where('updated_at', 'like', '%' . $request->updated_at . '%');
        }

        $userList = $userList->orderBy('updated_at', 'desc')->paginate(10);
        $data = [
            'entry_list' => $userList,
        ];

        return view('user.list', $data);
    }

    public function create() {
        return view('user.create');
    }

    public function store(Request $request) {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $checkedUser = User::where('email', $request->email)->first();

        if ($checkedUser) {
            return response()->json(['message' => 'Emai is exist'], 400);
        }

        $data = $request->all();
        $user = new User();
        $user['password'] = bcrypt($data['password']);
        $user['name'] = $data['name'];
        $user['email'] = $data['email'];
        $user['role'] = $data['role'];
        $user['active'] = 1;
        $user->save();
        $user = $user->toArray();
        $user['id'] = Crypt::encrypt($user['id']);

        return response()->json(['message' => 'Create user success', 'data' => $user], 200);
    }

    public function detail($id) {
        $idDecode = Crypt::decrypt($id);
        $user = User::where('id', $idDecode)->first();
        $user = $user->toArray();
        $user['id'] = Crypt::encrypt($user['id']);
        $data = [
            'entry_data' => $user,
        ];

        return view('user.detail', $data);
    }

    public function edit($id) {
        $idDecode = Crypt::decrypt($id);
        $user = User::where('id', $idDecode)->first();
        $user = $user->toArray();
        $user['id'] = Crypt::encrypt($user['id']);
        $data = [
            'entry_data' => $user,
        ];

        return view('user.edit', $data);
    }

    public function update($id, Request $request) {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $idDecode = Crypt::decrypt($id);
        $user = User::find($idDecode);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        $user = $user->toArray();
        $user['id'] = Crypt::encrypt($user['id']);

        return response()->json(['message' => 'Update user success', 'data' => $user], 200);
    }

    public function info() {
        $userId = auth()->user()->id;
        $user = User::where('id', $userId)->first();
        $user = $user->toArray();
        $user['id'] = Crypt::encrypt($user['id']);
        $data = [
            'entry_data' => $user,
        ];

        return view('user.detail', $data);
    }

    public function changePassword() {
        return view('user.change_password');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
    
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'The current password is incorrect'], 400);
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
        $user = $user->toArray();
        $user['id'] = Crypt::encrypt($user['id']);
    
        return response()->json(['message' => 'Update password success', 'data' => $user], 200);
    }

    public function activeAccount($id) {
        $idDecode = Crypt::decrypt($id);
        $user = User::find($idDecode);
        $isActive = $user['active'] == 1;
        $user['active'] = $isActive ? 0 : 1;
        $user->save();
        $isActive && dispatch(new ActiveUser($user));
    
        return redirect()->back();
    }
}
