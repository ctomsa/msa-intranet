<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Knowledge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KnowledgeController extends Controller
{
    private const CATEGORIES = [
        'ved'            => 'ВЭД',
        'fundraising'    => 'Привлечение финансирования',
        'legal'          => 'Юридические услуги',
        'growth'         => 'Развитие',
        'private_office' => 'Private office',
    ];

    public function index()
    {
        $items = Knowledge::latest('created_at')->paginate(20);

        return view('admin.knowledge.index', [
            'items'      => $items,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function create()
    {
        return view('admin.knowledge.create', [
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string|in:' . implode(',', array_keys(self::CATEGORIES)),
            'excerpt'        => 'nullable|string',
            'content'        => 'required|string',
            'author_name'    => 'nullable|string|max:255',
            'author_position'=> 'nullable|string|max:255',
            'attachment'     => 'nullable|file|max:20480', // до 20 МБ
        ]);
        $data['created_by'] = auth()->id();
        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('knowledge', 'public');
        }

        Knowledge::create($data);

        return redirect()
            ->route('admin.knowledge.index')
            ->with('status', 'Материал базы знаний создан');
    }

    public function edit(Knowledge $knowledge)
    {
        return view('admin.knowledge.edit', [
            'knowledge'  => $knowledge,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, Knowledge $knowledge)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string|in:' . implode(',', array_keys(self::CATEGORIES)),
            'excerpt'        => 'nullable|string',
            'content'        => 'required|string',
            'author_name'    => 'nullable|string|max:255',
            'author_position'=> 'nullable|string|max:255',
            'attachment'     => 'nullable|file|max:20480',
        ]);

        if ($request->hasFile('attachment')) {
            if ($knowledge->attachment_path) {
                Storage::disk('public')->delete($knowledge->attachment_path);
            }

            $data['attachment_path'] = $request->file('attachment')->store('knowledge', 'public');
        }

        $knowledge->update($data);

        return redirect()
            ->route('admin.knowledge.index')
            ->with('status', 'Материал базы знаний обновлён');
    }

    public function destroy(Knowledge $knowledge)
    {
        if ($knowledge->attachment_path) {
            Storage::disk('public')->delete($knowledge->attachment_path);
        }

        $knowledge->delete();

        return redirect()
            ->route('admin.knowledge.index')
            ->with('status', 'Материал удалён');
    }
}