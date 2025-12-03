<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Event;
use App\Models\Knowledge;   // это твоя модель для knowledge_items
use App\Models\Employee;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        // если пустой запрос — возвращаем на главную
        if ($q === '') {
            return redirect()->route('home');
        }

        // Новости
        $news = News::query()
            ->where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Мероприятия
        $events = Event::query()
            ->where('title', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->orderByDesc('start_at')
            ->limit(10)
            ->get();

        // База знаний
        $knowledge = Knowledge::query()
            ->where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Сотрудники
        $employees = Employee::query()
            ->where('full_name', 'like', "%{$q}%")
            ->orWhere('position', 'like', "%{$q}%")
            ->orWhere('department', 'like', "%{$q}%")
            ->orderBy('full_name')
            ->limit(10)
            ->get();

        return view('search.index', [
            'q'          => $q,
            'news'       => $news,
            'events'     => $events,
            'knowledge'  => $knowledge,
            'employees'  => $employees,
        ]);
    }
}