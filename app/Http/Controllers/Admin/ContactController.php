<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class ContactController extends Controller
{
    public function index()
    {
        // Пока считаем, что все сотрудники — контакты
        $contacts = Employee::orderBy('full_name')->get();

        return view('admin.contacts.index', compact('contacts'));
    }
}