<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LessonController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request): View
    {
        $viewData = [
            'title' => __('messages.list_lessons'),
            'subtitle' => __('navbar.list_lessons'),
            'message' => Session::get('message'),
            'lessons' => Lesson::paginate(4),
        ];

        Session::forget('message');

        return view('lesson.index')->with('viewData', $viewData);
    }

    public function show(string $id, Request $request): View|RedirectResponse
    {
        $lesson = Lesson::findOrFail($id);

        $viewData = [
            'title' => $lesson['name'].' - AGS',
            'subtitle' => $lesson['name'].' - lesson information',
            'lesson' => $lesson,
        ];

        return view('lesson.show')->with('viewData', $viewData);
    }
}
