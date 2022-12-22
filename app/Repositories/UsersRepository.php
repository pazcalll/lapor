<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Facility;
use App\Models\User;
use App\Models\UserAddressDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UsersRepository implements UserInterface
{
    public function register()
    {
        try {
            // dd(request()->all());
            $validated = request()->validate(
                [
                    'name' => 'required|min:4|max:40|regex:/^[a-zA-Z ]+$/u',
                    'username' => 'required|unique:users|max:12|min:4|regex:/^[a-zA-Z0-9]+$/u',
                    'password' => 'required|max:16|min:6',
                    'address' => 'nullable',
                    // 'role' => 'required|in:admin,opd,customer',
                    'phone' => 'nullable|min:10|max:12'
                ],
                [
                    'username.min' => 'Atribut Username minimal 4 karakter',
                    'username.max' => 'Atribut Username maksimal 12 karakter',
                    'username.regex' => 'Atribut Username hanya boleh buruf dan angka saja',
                    'username.unique' => 'Username sudah dipakai',
                    'username.required' => 'Atribut Username wajib diisi',
                    'password.min' => 'Atribut Password minimal 6 karakter',
                    'password.max' => 'Atribut Password maksimal 16 karakter',
                    'password.required' => 'Atribut Password wajib diisi',
                    'name.min' => 'Atribut Nama Lengkap minimal 4 karakter',
                    'name.max' => 'Atribut Nama Lengkap maksimal 40 karakter',
                    'name.required' => 'Atribut Nama Lengkap wajib diisi',
                    'name.regex' => 'Atribut Nama Lengkap hanya boleh diisi huruf',
                    // 'role.in' => 'Isi tidak sesuai ketentuan',
                    // 'role.required' => 'Atribut :attribute wajib diisi',
                    'phone.min' => 'Atribut Nomor Telepon minimal 10 karakter',
                    'phone.max' => 'Atribut Nomor Telepon maksimal 12 karakter',
                ]
            );
            $validated['password'] = Hash::make($validated['password']);
            $validated['role'] = "customer";
            User::create($validated);

            return response()->json(['success' => 'register success', 'status' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->errors(), 'status' => 400], 400);
            // return response()->json(['error' => $th, 'status' => 400], 400);
        }
    }

    public function login()
    {
        try {
            $validated = request()->validate(
                [
                    'username' => 'required|max:12|min:4|regex:/^[a-zA-Z0-9]+$/u',
                    'password' => 'required|max:16|min:6',
                ],
                [
                    'username.min' => 'Atribut Username minimal 4 karakter',
                    'username.max' => 'Atribut Username maksimal 12 karakter',
                    'username.regex' => 'Atribut Username hanya boleh buruf dan angka saja',
                    'username.required' => 'Atribut Username wajib diisi',
                    'password.min' => 'Atribut Password minimal 6 karakter',
                    'password.max' => 'Atribut Password maksimal 16 karakter',
                    'password.required' => 'Atribut Password wajib diisi',
                ]
            );
            $credentials = request(['username', 'password']);

            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => ['login' => ['Username atau Password tidak sesuai']]], 401);
            }

            return $this->respondWithToken($token);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->errors(), 'status' => 400], 400);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function authenticator()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        if ($user['role'] == 'customer') {
            return view('customer.index');
        } else if ($user['role'] == 'admin') {
            return view('admin.index');
        } else if ($user['role'] == 'opd') {
            return view('opd.index');
        }
    }

    public function getProfile()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        return response()->json($user, 200);
    }

    public function getProfileDetail($auth)
    {
        $user = User::with(['userAddressDetail' => function ($query) {
            return $query->select('street', 'rt', 'rw', 'village', 'sub_district', 'user_id');
        }])->where('id', $auth->id)->where('username', $auth->username)->first();
        return response()->json($user, 200);
    }

    public function getFacilities()
    {
        $data = Facility::select(['id', 'name'])->get();
        return response()->json($data, 200);
    }

    public function updateProfile()
    {
        // DO NOT USE FORMDATA TO ANY 'PATCH' ROUTES
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'password' => 'nullable|min:6|max:16',
            'rt' => 'required',
            'rw' => 'required',
            'street' => 'required',
            'village' => 'required',
            'sub_district' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

        try {
            $user = JWTAuth::toUser(request()->bearerToken());
            $validator = $validator->validate();

            DB::beginTransaction();
            // return response()->json($validator['password'] == null, 200);
            $userUpdate = User::where('id', $user['id'])->update([
                'name' => $validator['name'],
                'phone' => $validator['phone'],
            ]);
            if ($validator['password'] != null) {
                $userPasswordUpdate = User::where('id', $user['id'])->update([
                    'password' => $validator['password']
                ]);
            }
            $userDetailUpdate = UserAddressDetail::where('user_id', $user['id'])->update([
                'rt' => $validator['rt'],
                'rw' => $validator['rw'],
                'street' => $validator['street'],
                'village' => $validator['village'],
                'sub_district' => $validator['sub_district'],
            ]);

            DB::commit();
            return response()->json([$userUpdate, $userDetailUpdate], 200);
        } catch (Exception $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function profilePage()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        if ($user['role'] == 'customer') {
            return view('customer.profile');
        } else if ($user['role'] == 'admin') {
            return view('admin.profile');
        } else if ($user['role'] == 'opd') {
            return view('opd.profile');
        }
    }

    public function respondWithToken($token)
    {
        return response()->json([
            '_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
}