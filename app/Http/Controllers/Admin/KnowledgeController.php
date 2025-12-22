<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Knowledge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\KnowledgeAttachment;
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
    'title'            => 'required|string|max:255',
    'category'         => 'required|string|in:' . implode(',', array_keys(self::CATEGORIES)),
    'excerpt'          => 'nullable|string',
    'content'          => 'required|string',
    'author_name'      => 'nullable|string|max:255',
    'author_position'  => 'nullable|string|max:255',

    'attachments'      => 'nullable|array|max:5',
    'attachments.*'    => 'file|max:20480', // 20 MB каждый
]);
        $data['created_by'] = auth()->id();
        
$knowledge = Knowledge::create($data);

if ($request->hasFile('attachments')) {
    foreach ($request->file('attachments') as $file) {
        $path = $file->store('knowledge', 'public');

        $knowledge->attachments()->create([
            'path'          => $path,
            'original_name' => $file->getClientOriginalName(),
            'size'          => $file->getSize(),
            'mime'          => $file->getMimeType(),
        ]);
    }
}
        
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
            'attachments'   => 'nullable|array|max:5',
	'attachments.*' => 'file|max:20480', 
       ]);


$knowledge->update($data);
        if ($request->hasFile('attachments')) {
    foreach ($request->file('attachments') as $file) {
        $path = $file->store('knowledge', 'public');

        $knowledge->attachments()->create([
            'path'          => $path,
            'original_name' => $file->getClientOriginalName(),
            'size'          => $file->getSize(),
            'mime'          => $file->getMimeType(),
        ]);
    }
}
        return redirect()
            ->route('admin.knowledge.index')
            ->with('status', 'Материал базы знаний обновлён');
    }

    public function destroyAttachment(KnowledgeAttachment $attachment)
{
    // удалить файл с диска
    if ($attachment->path) {
        Storage::disk('public')->delete($attachment->path);
    }

    // удалить запись из БД
    $attachment->delete();

    return back()->with('status', 'Вложение удалено');
}
}
