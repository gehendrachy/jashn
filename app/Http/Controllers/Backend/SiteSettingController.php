<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Services\ModelHelper;

class SiteSettingController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::findOrFail(1);
        return view('backend.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = SiteSetting::findOrFail('1');
        $validatedData = $request->validate([
            'email' => 'required|max:225|email',
        ]);

        $setting->title = $request->title;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->mobile = $request->mobile;
        $setting->mobile_viber = $request->mobile_viber;
        $setting->mobile_whatsapp = $request->mobile_whatsapp;
        $setting->address = $request->address;
        $setting->facebookurl = $request->facebookurl;
        $setting->instagramurl = $request->instagramurl;
        $setting->twitterurl = $request->twitterurl;
        $setting->youtubeurl = $request->youtubeurl;
        $setting->how_to_order_link = $request->how_to_order_link;
        $setting->aboutus = $request->aboutus;
        $setting->googlemapurl = $request->googlemapurl;
        $setting->og_title = $request->og_title;
        $setting->og_description = $request->og_description;
        $setting->meta_title = $request->meta_title;
        $setting->meta_description = $request->meta_description;
        $setting->meta_keywords = $request->meta_keywords;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            $oldlogo = $setting->logo;
            $validatedData = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg|max:1000',
            ]);

            Storage::putFileAs('public/setting/logo', new File($logo), $filename);

            $setting->logo = $filename;

            ModelHelper::resize_crop_images(200, 200, $logo, "public/setting/logo/thumb_" . $filename);
            if ($oldlogo != null) {
                //deleting exiting logo
                Storage::delete('public/setting/logo/' . $oldlogo);
                Storage::delete('public/setting/logo/thumb_' . $oldlogo);
            }
        }
        if ($request->hasFile('favicon')) {
            $logo = $request->file('favicon');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            $oldfavicon = $setting->favicon;
            $validatedData = $request->validate([
                'favicon' => 'image|mimes:jpeg,png,jpg|max:1000',
            ]);

            Storage::putFileAs('public/setting/favicon', new File($logo), $filename);

            $setting->favicon = $filename;

            ModelHelper::resize_crop_images(200, 200, $logo, "public/setting/favicon/thumb_" . $filename);
            if ($oldfavicon != null) {
                //deleting exiting logo
                Storage::delete('public/setting/favicon/' . $oldfavicon);
                Storage::delete('public/setting/favicon/thumb_' . $oldfavicon);
            }
        }
        if ($request->hasFile('og_image')) {
            $logo = $request->file('og_image');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            $oldog_image = $setting->og_image;
            $validatedData = $request->validate([
                'og_image' => 'image|mimes:jpeg,png,jpg|max:1000',
            ]);

            Storage::putFileAs('public/setting/og_image', new File($logo), $filename);

            $setting->og_image = $filename;

            ModelHelper::resize_crop_images(200, 200, $logo, "public/setting/og_image/thumb_" . $filename);
            if ($oldog_image != null) {
                //deleting exiting logo
                Storage::delete('public/setting/og_image/' . $oldog_image);
                Storage::delete('public/setting/og_image/thumb_' . $oldog_image);
            }
        }
        $setting->save();

        return redirect(route('admin.setting'))->with('status', 'Setting Update Successfully.');
    }
}
