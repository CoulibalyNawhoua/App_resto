<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function passwordChangeView()
    {
        addJavascriptFile('shop/accounts/signin-methods.js');
        return view('pages.account.changePassword');
    }

    public function changePasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        auth()->user()->update(['password' => Hash::make($request->input('new_confirm_password'))]);

        if ($request->expectsJson()) {
            return response()->json($request->all());
        }

    }
}
