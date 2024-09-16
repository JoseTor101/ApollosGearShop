<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Util\CartUtility;
use App\Models\Lesson;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
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
            'title' => __('messages.lessons'),
            'subtitle' => __('messages.list_lessons'),
            'message' => Session::get('message'),
            'Lessons' => Lesson::all(),
        ];

        return view('lesson.index')->with('viewData', $viewData);
    }

    public function show(string $id, Request $request): View|RedirectResponse
    {
        $lesson = Lesson::findOrFail($id);

        if ($request->isMethod('post') && $request->has('add_to_cart')) {

            CartUtility::addItemToCart($id, 'lesson', $request, 0);

            return redirect()->route('cart.index')->with('message', 'Lesson added to cart!');
        }

        $viewData = [
            'title' => __('messages.Lessons'),
            'subtitle' => __('messages.information_lessons'),
            'lesson' => $lesson,
        ];

        return view('lesson.show')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [
            'title' => __('messages.Lessons'),
        ];

        return view('lesson.create')->with('viewData', $viewData);
    }

    public function save(Request $request): RedirectResponse
    {
        $lesson = new Lesson;

        try {
            $validatedData = $lesson->validate($request->all());

            $lesson = Lesson::create($validatedData);

            $viewData = [
                'id' => $lesson->id,
                'name' => $lesson->name,
                'description' => $lesson->description,
                'difficulty' => $lesson->difficulty,
                'schedule' => $lesson->schedule,
                'totalHours' => $lesson->totalHours,
                'location' => $lesson->location,
                'price' => $lesson->price,
                'teacher' => $lesson->teacher,
            ];

            return redirect()->route('lesson.success', $viewData);

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function addToCart(string $id, Request $request): RedirectResponse
    {
        $lesson = Lesson::findOrFail($id);

        CartUtility::addItemToCart($id, 'lesson', $request, 0);

        return redirect()->route('cart.index')->with('message', 'Lesson added to cart!');
    }

    public function success(Request $request): View|RedirectResponse
    {
        $lesson = $request->only([
            'id', 'name', 'description', 'difficulty',
            'schedule', 'totalHours', 'location', 'price', 'teacher',
        ]);

        if (empty($lesson['id']) || empty($lesson['name']) || empty($lesson['description'])) {
            return redirect()->route('home.index');
        }

        $viewData = [
            'title' => __('messages.Lessons'),
            'subtitle' => __('messages.Success_lessons'),
            'lesson' => $lesson,
        ];

        return view('lesson.success')->with('viewData', $viewData);
    }

    public function delete($id): RedirectResponse
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return redirect()->route('lesson.index')->with('success', 'Lesson deleted successfully.');
    }
}
