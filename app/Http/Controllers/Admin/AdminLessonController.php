<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// example created with the Lesson model
// further implementation requires all models

class AdminLessonController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function lesson_index(): View
    {
        $viewData = [
            'title' => __('messages.list_lessons'),
            'subtitle' => __('navbar.list_lessons'),
            'lessons' => Lesson::all(),
        ];

        return view('admin.lesson.index')->with('viewData', $viewData);
    }

    public function lesson_create(): View
    {
        $viewData = [
            'title' => __('navbar.create_lesson'),
        ];

        return view('admin.lesson.create')->with('viewData', $viewData);
    }

    public function lesson_save(Request $request): RedirectResponse
    {
        $lesson = new Lesson;
        $validatedData = $lesson->validate($request->all());
        Lesson::create($validatedData);

        $viewData['message'] = 'Lesson successfully created!';

        return redirect()->route('admin.index')->with('message', $viewData['message']);
    }

    public function lesson_show(string $id, Request $request): View|RedirectResponse
    {
        $lesson = Lesson::findOrFail($id);

        $viewData = [
            'title' => $lesson['name'].' - AGS',
            'subtitle' => $lesson['name'].' - lesson information',
            'lesson' => $lesson,
        ];

        return view('admin.lesson.show')->with('viewData', $viewData);
    }

    public function lesson_delete($id): RedirectResponse
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return redirect()->route('admin.index')->with('success', 'Lesson deleted successfully.');
    }
}
