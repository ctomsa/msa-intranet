<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('created_at')->paginate(20);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $news = new News();

        return view('admin.news.form', [
            'news' => $news,
            'mode' => 'create',
        ]);
    }

public function store(Request $request)
{
    $data = $this->validatedData($request);
    $data['author_id'] = auth()->id();

    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $data['attachment_path'] = $file->store('news', 'public');
        $data['attachment_name'] = $file->getClientOriginalName();
    }

    News::create($data);

    return redirect()->route('admin.news.index')->with('success', 'Новость создана');
}
    public function edit(News $news)
    {
        return view('admin.news.form', [
            'news' => $news,
            'mode' => 'edit',
        ]);
    }

public function update(Request $request, News $news)
{
    $data = $this->validatedData($request);

    if ($request->hasFile('attachment')) {
        if ($news->attachment_path) {
            Storage::disk('public')->delete($news->attachment_path);
        }

        $file = $request->file('attachment');
        $data['attachment_path'] = $file->store('news', 'public');
        $data['attachment_name'] = $file->getClientOriginalName();
    }

    $news->update($data);

    return redirect()->route('admin.news.index')->with('success', 'Новость обновлена');
}
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Новость удалена');
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'label'        => ['nullable', 'string', 'max:50'],
            'audience'     => ['nullable', 'string', 'max:100'],
            'department'   => ['nullable', 'string', 'max:100'],
            'excerpt'      => ['nullable', 'string'],
            'content'      => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
