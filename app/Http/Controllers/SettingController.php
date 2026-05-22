<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function toggleRegistration()
    {
        $current = Setting::registrationOpen();
        Setting::set('registration_open', $current ? '0' : '1');

        $msg = $current
            ? 'Inscriptions fermées. Le formulaire public est désactivé.'
            : 'Inscriptions ouvertes. Le formulaire public est actif.';

        return back()->with('success', $msg);
    }
}
