<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\Knowledge;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        // Новости
        $newsQuery = News::query();
        if ($q !== '') {
            $newsQuery->where('title', 'like', "%{$q}%");
        }
        $news = $newsQuery
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

// Мероприятия
$eventsQuery = Event::whereNotNull('start_at')
    ->whereDate('start_at', '>=', Carbon::today());

if ($q !== '') {
    $eventsQuery->where('title', 'like', "%{$q}%");
}

$events = $eventsQuery
    ->orderBy('start_at', 'asc')
    ->limit(3)
    ->get();

        // Материалы базы знаний
        $knowledgeQuery = Knowledge::query();
        if ($q !== '') {
            $knowledgeQuery->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                   ->orWhere('content', 'like', "%{$q}%");
            });
        }
        $knowledge = $knowledgeQuery
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Базовые категории базы знаний
        $baseCategories = collect([
            ['code' => 'ved',            'label' => 'ВЭД'],
            ['code' => 'fundraising',    'label' => 'Привлечение финансирования'],
            ['code' => 'legal',          'label' => 'Юридические услуги'],
            ['code' => 'growth',         'label' => 'Развитие'],
            ['code' => 'private_office', 'label' => 'Private office'],
        ]);

        // Кол-во материалов по категориям
        $counts = Knowledge::selectRaw('category, COUNT(*) as cnt')
            ->groupBy('category')
            ->pluck('cnt', 'category');

        // Превращаем в объекты с code/label/items_count (как в KnowledgeController)
        $knowledgeCategories = $baseCategories->map(function ($cat) use ($counts) {
            return (object) [
                'code'        => $cat['code'],
                'label'       => $cat['label'],
                'items_count' => $counts[$cat['code']] ?? 0,
            ];
        });

        // Сотрудники (левая часть)
        $employeesQuery = Employee::query();
        if ($q !== '') {
            $employeesQuery->where(function ($qq) use ($q) {
                $qq->where('full_name', 'like', "%{$q}%")
                   ->orWhere('position', 'like', "%{$q}%");
            });
        }
        $employees = $employeesQuery
            ->orderBy('id', 'asc')
            ->limit(5)
            ->get();

        // Контакты (правая колонка)
$contactIds = [2, 5, 14];       

$contacts = Employee::whereIn('id', $contactIds)
    ->orderByRaw('FIELD(id, '.implode(',', $contactIds).')')
    ->get();
// Дни рождения в текущем календарном месяце
$birthdays = Employee::query()
    ->whereNotNull('birthday')
    ->whereMonth('birthday', Carbon::now()->month)
    ->orderByRaw('DAY(birthday)')
    ->get();
        return view('home', [
            'news'                => $news,
            'events'              => $events,
            'knowledge'           => $knowledge,
            'employees'           => $employees,
            'contacts'            => $contacts,
            'knowledgeCategories' => $knowledgeCategories,
            'q'                   => $q,
            'birthdays'           => $birthdays,       
 ]);
    }
}
