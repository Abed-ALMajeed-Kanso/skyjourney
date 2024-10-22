<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest; 
use App\Http\Requests\UpdateUserRequest; 
use App\Http\Requests\ShowUsersRequest; 
use App\Http\Requests\ShowUserByIdRequest; 
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedSort;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Imports\DeleteUserRequest;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends Controller
{
    public function index(ShowUsersRequest $request)
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            ])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->paginate($request->input('per_page', 10));

        return response($users);
    }
    
    public function show(ShowUserByIdRequest $request, $id)
    {
        $user = User::findOrFail($id);
        return response($user);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        return response($user);
    }
    
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        if ($request->filled('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $user->update($request->only('name', 'email', 'password') + [
            'email_verified_at' => $request->email_verified_at ?? now(),
            'remember_token' => $request->remember_token ?? Str::random(10),
        ]);

        return response($user);
    }
    
    public function destroy(int $id)
    {
        $user = User::findOrFail($id); 
        $user->delete(); 
        return response(['message' => 'User deleted successfully']);
    }

    public function import()
    {
        $filePath = storage_path('app/uploads/users.csv');

        $data = Excel::toArray(new UsersImport, $filePath);

        return response($data[0]);
    }
}
