<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaxRateSetting;

class TaxRateSettingController extends Controller
{
    public function index()
    {
        $setting = TaxRateSetting::first();
        return view('admin.settings.tax-rate', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tax_rate' => 'required|numeric|min:0|max:100'
        ]);

        $setting = TaxRateSetting::first();
        if ($setting) {
            $setting->update(['tax_rate' => $request->tax_rate]);
        } else {
            TaxRateSetting::create(['tax_rate' => $request->tax_rate]);
        }

        return redirect()->back()->with('success', 'Tax rate updated successfully!');
    }
}
