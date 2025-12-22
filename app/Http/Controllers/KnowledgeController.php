<?php

namespace App\Http\Controllers;

use App\Models\Knowledge;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index(Request $request)
    {
        // Жёстко заданные категории
        $categoriesConfig = collect([
            ['code' => 'ved',            'label' => 'ВЭД'],
            ['code' => 'fundraising',    'label' => 'Привлечение финансирования'],
            ['code' => 'legal',          'label' => 'Юридические услуги'],
            ['code' => 'growth',         'label' => 'Развитие'],
            ['code' => 'private_office', 'label' => 'Private office'],
        ]);

        // базовый запрос по материалам
        $query = Knowledge::query()->orderByDesc('created_at');

        // фильтр по категории ?category=...
        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        // материалы с пагинацией
        $items = $query->paginate(15);

        // подсчёт количества материалов по категориям
        $counts = Knowledge::selectRaw('category, COUNT(*) as cnt')
            ->groupBy('category')
            ->pluck('cnt', 'category');

        // собираем объекты категорий с кодом / названием / числом материалов
        $knowledgeCategories = $categoriesConfig->map(function ($cat) use ($counts) {
            return (object) [
                'code'        => $cat['code'],
                'label'       => $cat['label'],
                'items_count' => $counts[$cat['code']] ?? 0,
            ];
        });

        return view('knowledge.index', [
            'items'               => $items,
            'knowledgeCategories' => $knowledgeCategories,
            'currentCategory'     => $request->get('category'),
        ]);
    }

   public function show(Knowledge $knowledge)
{
    $knowledge->load('attachments');

    return view('knowledge.show', [
        'item' => $knowledge,
    ]);
}}
