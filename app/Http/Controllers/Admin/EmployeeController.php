<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
{
    $employees = \App\Models\Employee::orderBy('full_name')->paginate(50);

    return view('admin.employees.index', compact('employees'));
}

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required',
            'position'  => 'required',
            'department' => 'nullable',
            'email' => 'nullable',
            'phone_internal' => 'nullable',
            'phone_mobile' => 'nullable',
            'responsibilities' => 'nullable',
            'avatar' => 'nullable|image',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        Employee::create($data);

        return redirect()->route('admin.employees.index');
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'full_name' => 'required',
            'position'  => 'required',
            'department' => 'nullable',
            'email' => 'nullable',
            'phone_internal' => 'nullable',
            'phone_mobile' => 'nullable',
            'responsibilities' => 'nullable',
            'avatar' => 'nullable|image',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index');
    }
}