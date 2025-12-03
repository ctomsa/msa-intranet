<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Список мероприятий
     */
public function index()
{
    $events = Event::orderBy('start_at', 'asc')->paginate(20); // или любое число на страницу

    return view('admin.events.index', compact('events'));
}

    /**
     * Форма создания
     */
    public function create()
    {
        // чтобы в форме удобно было подставлять old() / $event->...
        $event = new Event();

        return view('admin.events.create', compact('event'));
    }

    /**
     * Сохранение нового мероприятия
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'nullable|string|max:50',
            'location'    => 'nullable|string|max:255',
            'start_at'    => 'nullable|date',
        ]);

        // если тип не указан — считаем его general
        if (empty($data['type'])) {
            $data['type'] = 'general';
        }

        Event::create($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Мероприятие создано.');
    }

    /**
     * Форма редактирования
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Обновление мероприятия
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'nullable|string|max:50',
            'location'    => 'nullable|string|max:255',
            'start_at'    => 'nullable|date',
        ]);

        if (empty($data['type'])) {
            $data['type'] = 'general';
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Мероприятие обновлено.');
    }

    /**
     * Удаление мероприятия
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Мероприятие удалено.');
    }
}