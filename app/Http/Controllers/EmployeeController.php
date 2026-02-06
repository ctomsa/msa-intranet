<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
$employees = Employee::orderBy('group')
    ->orderBy('full_name')
    ->get()
    ->groupBy(function($e) {
        return $e->group ?: 'Без группы';
    });

return view('employees.index', compact('employees'));    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }
}
