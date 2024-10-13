<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;

    }

    public function index()
    {
        $depots = $this->settingRepository->selectDepots();

        $settings =  Setting::get(['key', 'value']);

        return view('settings.edit', compact('depots','settings'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $array = [];
        foreach ($data as $key => $value) {

            $array[]=$value;
            $setting = Setting::firstOrCreate(['key' => $key]);
            $setting->value = $value;
            $setting->save();
        }

        dd($array);

        return redirect()->route('settings.index');
    }
}
