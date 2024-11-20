<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Services\ImageService;
use App\Util\Arrays;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// example created with the Lesson model
// further implementation requires all models

class AdminInstrumentController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create(): View
    {
        $viewData = [
            'title' => __('navbar.create_instrument'),
            'subtitle' => __('navbar.create_instrument'),
            'categories' => Arrays::getCategories(),
        ];

        return view('admin.instrument.create')->with('viewData', $viewData);
    }

    public function save(Request $request): RedirectResponse
    {
        $instrument = new Instrument;
        $imagePath = $this->imageService->store($request);
        Instrument::createInstrument($request->all(), $imagePath);

        $viewData['message'] = __('messages.created');

        return redirect()->route('admin.index')->with('message', $viewData['message']);
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $instrument = Instrument::findOrFail($id);
            $instrument->delete();
            $viewData['message'] = __('messages.deleted');
        } catch (Exception $e) {
            return redirect()->route('admin.index')->with('error', __('messages.delete_failed'));
        }

        return redirect()->route('admin.index')->with('message', $viewData['message']);
    }
}
