<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingSiteInfo;
use App\Models\SettingContactInfo;
use App\Models\SettingSocialInfo;
use App\Models\SettingMailConfig;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function getSiteInfo()
    {
        $site_info = SettingSiteInfo::all();

        return response()->json(['data' => $site_info], 200);
    }

    public function updateSiteInfo(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|exists:setting_site_infos,id',
            'site_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'meta_keywords' => 'required|string|max:255',
            'site_logo' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'site_favicon' => 'required|image|mimes:jpeg,jpg,png,gif,svg,ico|max:2048',
            'footer_text' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $site_info = SettingSiteInfo::find($request->id);
        $site_info->site_title = $request->site_title;
        $site_info->meta_description = $request->meta_description;
        $site_info->meta_keyword = $request->meta_keywords;
        if ($request->hasFile('site_logo')) { 
            $image = $request->file('site_logo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/settings/site-info');
            $image->move($destinationPath, $name);
            $site_info->site_logo = $name;
        }
        if ($request->hasFile('site_favicon')) { 
            $image = $request->file('site_favicon');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/settings/site-info');
            $image->move($destinationPath, $name);
            $site_info->site_favicon = $name;
        }
        $site_info->footer_text = $request->footer_text;
        $site_info->save();

        return response()->json(['message'=> 'Site info updated successfully'],200);
    }

    public function getContactInfo()
    {
        $contact_info = SettingContactInfo::all();

        return response()->json(['data' => $contact_info], 200);
    }

    public function updateContactInfo(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|exists:setting_contact_infos,id',
            'phone' => 'required|string|max:255',
            'contact_address' => 'required|string|max:255',
            'contact_mail' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $contact_info = SettingContactInfo::find($request->id);
        $contact_info->phone = $request->phone;
        $contact_info->contact_address = $request->contact_address;
        $contact_info->contact_mail = $request->contact_mail;
        $contact_info->save();

        return response()->json(['message'=> 'Contact info updated successfully'],200);
    }

    public function getSocialInfo()
    {
        $social_infos = SettingSocialInfo::all();

        return response()->json(['data' => $social_infos], 200);
    }

    public function updateSocialInfo(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|exists:setting_social_infos,id',
            'facebook_url' => 'required',
            'twitter_url' => 'required',
            'linkedin_url' => 'required',
            'youtube_url' => 'required',
            'skype_id' => 'required',
            'whatsapp_no' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $social_info = SettingSocialInfo::find($request->id);
        $social_info->facebook_url = $request->facebook_url;
        $social_info->twitter_url = $request->twitter_url;
        $social_info->linkedin_url = $request->linkedin_url;
        $social_info->youtube_url = $request->youtube_url;
        $social_info->skype_id = $request->skype_id;
        $social_info->whatsapp_no = $request->whatsapp_no;
        $social_info->save();

        return response()->json(['message'=> 'Social info updated successfully'],200);
    }

    public function mailInfo()
    {
        $mail_config = SettingMailConfig::all();

        return response()->json(['data' => $mail_config], 200);
    }

    public function updateMailConfig(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|exists:setting_mail_configs,id',
            'mail_driver' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $mail_config = SettingMailConfig::find($request->id);
        $mail_config->mail_driver = $request->mail_driver;
        $mail_config->mail_host = $request->mail_host;
        $mail_config->mail_port = $request->mail_port;
        $mail_config->mail_username = $request->mail_username;
        $mail_config->mail_password = Hash::make($request->mail_password);
        $mail_config->mail_encryption = $request->mail_encryption;
        $mail_config->mail_from_address = $request->mail_from_address;
        $mail_config->mail_from_name = $request->mail_from_name;
        $mail_config->save();

        return response()->json(['message'=> 'Email configation successfully'],200);
    }
}
