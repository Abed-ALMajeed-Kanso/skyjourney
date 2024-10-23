<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedSort;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(ShowUsersRequest $request)
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                'name',
                'email',
            ])
            ->defaultSort('-updated_at')
            ->allowedSorts(['name', 'email', 'created_at', 'updated_at'])
            ->paginate($request->input('per_page', 10));

            return response(['success' => true, 'data' => $users], Response::HTTP_OK);
    }
    
    public function show(Request $request, $id)
    {
        return response(['success' => true, 'data' => $user], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users', 
            'password' => 'required|string|min:8|confirmed', 
        ]);
    
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['created_at'] = now();
        $validatedData['updated_at'] = now();    
        $user = User::create($validatedData);
    
        return response(['success' => true, 'data' => $user], Response::HTTP_CREATED);
    }
    
    
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|uunique:users,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', 
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $validatedData['updated_at'] = now();
        $user->update($validatedData);

        return response(['success' => true, 'data' => $user], Response::HTTP_OK);
    }

    
    public function destroy(User $user)
    {
        $user->delete(); 
        return response(['success' => true, 'data' => null], Response::HTTP_NO_CONTENT);
    }

    public function import()
    {
        $filePath = storage_path('app/uploads/users.csv');
        $data = Excel::toArray(new UsersImport, $filePath);
        return response(['success' => true, 'data' => $data[0]], Response::HTTP_OK);
    }
}
