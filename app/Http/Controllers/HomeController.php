<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\Knowledge;
use App\Models\Employee;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        // --- Новости ---
        $newsQuery = News::query();

        if ($q !== '') {
            $newsQuery->where('title', 'like', "%{$q}%");
        }

        $news = $newsQuery
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // --- Мероприятия ---
        $eventsQuery = Event::whereNotNull('start_at');

        if ($q !== '') {
            $eventsQuery->where('title', 'like', "%{$q}%");
        }

        $events = $eventsQuery
            ->orderBy('start_at', 'asc')
            ->limit(3)
            ->get();

        // --- Материалы базы знаний ---
        $knowledgeQuery = Knowledge::query();

        if ($q !== '') {
            $knowledgeQuery->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            });
        }

        $knowledge = $knowledgeQuery
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // --- Категории базы знаний для главной ---
        $baseCategories = collect([
            ['code' => 'ved',            'label' => 'ВЭД'],
            ['code' => 'fundraising',    'label' => 'Привлечение финансирования'],
            ['code' => 'legal',          'label' => 'Юридические услуги'],
            ['code' => 'growth',         'label' => 'Развитие'],
            ['code' => 'private_office', 'label' => 'Private office'],
        ]);

        // количество материалов по категориям
        $counts = Knowledge::selectRaw('category, COUNT(*) as cnt')
            ->groupBy('category')
            ->pluck('cnt', 'category')
            ->toArray();

        // приводим к объектам с code / label / items_count
        $knowledgeCategories = $baseCategories->map(function ($cat) use ($counts) {
            return (object) [
                'code'        => $cat['code'],
                'label'       => $cat['label'],
                'items_count' => $counts[$cat['code']] ?? 0,
            ];
        });

        // --- Сотрудники ---
        $employeesQuery = Employee::query();

        if ($q !== '') {
            $employeesQuery->where(function ($sub) use ($q) {
                $sub->where('full_name', 'like', "%{$q}%")
                    ->orWhere('position', 'like', "%{$q}%");
            });
        }

        $employees = $employeesQuery
            ->orderBy('full_name')
            ->limit(5)
            ->get();

        // Контакты (ключевые сотрудники)
        $contacts = Employee::where('is_contact', true)
            ->orderBy('full_name')
            ->limit(3)
            ->get();

        return view('home', [
            'news'                => $news,
            'events'              => $events,
            'knowledge'           => $knowledge,
            'employees'           => $employees,
            'contacts'            => $contacts,
            'knowledgeCategories' => $knowledgeCategories,
            'q'                   => $q,
        ]);
    }
}