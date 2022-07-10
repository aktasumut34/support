<?php
use App\Models\Setting;

use App\Models\SocialAuthSetting;
use App\Models\customizeerror;
use App\Models\Customcssjs;

function setting($key){
	return  Setting::where('key', '=',  $key)->first()->value ?? '' ;
}

function settingpages($errorname){
	return  customizeerror::where('errorname', '=',  $errorname)->first()->errorvalue ?? '' ;
}

function customcssjs($name){
	return Customcssjs::where('name', '=', $name)->first()->value ?? '';
}

function getLanguages()
{

	$scanned_directory = array_diff(scandir( resource_path('lang') ), array('..', '.'));

	return $scanned_directory;
}

function getName($entity) {
    $lang = app()->getLocale();
    if($lang != 'Turkce') {
        return $entity->name_english;
    }
    return $entity->name;
}
