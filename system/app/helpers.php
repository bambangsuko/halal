<?php

use Illuminate\Support\Str;
use App\Menu;
use App\Post;
use App\Permission;
use App\PrivilegeCode;
use App\Setting;
use Illuminate\Support\Facades\Crypt;

function generateFileName($title, $file)
{
    return Str::limit(Str::slug($title), 50, '') . '-' . strtotime('now') . '.' . $file->getClientOriginalExtension();
}

function removeFile($path)
{
    if (file_exists($path)) {
        unlink($path);
    }
}

function generateUrl($slug)
{
    $route = url(app()->getLocale() . '/');
    return $route . '/' . $slug;
}

function generateUrlByPostId($id)
{
    $post = Post::findOrFail($id);
    $route = url(app()->getLocale() . '/');
    return $route . '/' . $post->slug;
}

/**
 * [activeLink description]
 * @param  [type] $route  [description]
 * @param  string $output [description]
 * @return [type]         [description]
 */
function activeLink($route, $resource = true, $output = 'active')
{
    $listResource = ['index', 'create', 'store', 'edit', 'update', 'show', 'destroy'];

    if (is_array($route)) {
        foreach ($route as $r) {
            if ($resource) {
                foreach ($listResource as $list) {
                    if (Route::current()->getName() == $r . '.' . $list)
                        return $output;
                }
            } else {
                if (Route::current()->getName() == $r)
                    return $output;
            }
        }
    } else {
        if ($resource) {
            foreach ($listResource as $list) {
                if (Route::current()->getName() == $route . '.' . $list)
                    return $output;
            }
        } else {
            if (Route::current()->getName() == $route)
                return $output;
        }
    }
}
function activeLinkUriSegment($route)
{
    if (Request::segment(2) == $route) {
        return 'active';
    }
}
function user()
{
    return Auth::user();
}

function checkPermission($user, $code)
{
    $privilegecode = PrivilegeCode::where('name', $code)->first();
    //    $permission = Permission::with([
    //                'privilegecode' => function ($query) use ($code) {
    //                    $query->where('name', $code);
    //                }
    //            ])
    //            ->where('role_id', $user->role_id)
    //            ->first();
    $permission = Permission::where('role_id', $user->role_id)
        ->where('privilege_code_id', $privilegecode->id)
        ->first();
    if ($permission) {
        return TRUE;
    } else {
        return abort(404);
    }
}

function getSidebar($code)
{
    $privilegecode = PrivilegeCode::where('name', $code)->first();
    $permission = Permission::where('role_id', user()->role_id)
        ->where('privilege_code_id', $privilegecode->id)
        ->first();
    if ($permission) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function encryptString($string)
{
    return Crypt::encryptString($string);
}

function decryptString($encryption)
{
    try {
        return Crypt::decryptString($encryption);
    } catch (\Exception $e) {
        return $encryption;
    }
}

function getAge($birth_date)
{
    $date1 = new DateTime($birth_date);
    $date2 = new DateTime();
    $interval = $date1->diff($date2);
    // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
    return $interval->y;
}

function countMaxLoan($age, $salary)
{
    $credit_age = Setting::where('key', 'credit_age')->first();
    $credit_time = Setting::where('key', 'credit_time')->first();
    $credit_percentage = Setting::where('key', 'credit_percentage')->first();
    $credit_interest_rate = Setting::where('key', 'credit_interest_rate')->first();
    $credit_max_plafond = Setting::where('key', 'credit_max_plafond')->first();
    $wk = $credit_age->value - $age;
    if ($wk > $credit_time->value) {
        $max_loan = ($salary * ($credit_time->value * 12) * ($credit_percentage->value / 100)) / (1 + (($credit_time->value * 12) * ($credit_interest_rate->value / 100)));
    } else {
        $max_loan = ($salary * ($wk * 12) * ($credit_percentage->value / 100)) / (1 + (($wk * 12) * ($credit_interest_rate->value / 100)));
    }

    if ($max_loan > $credit_max_plafond->value) {
        $max_loan = $credit_max_plafond->value;
    }
    return $max_loan;
}

function checkAge($age)
{
    $credit_age = Setting::where('key', 'credit_age')->first();
    if ($age >= ($credit_age->value - 1)) {
        return false;
    } else {
        return true;
    }
}

function getJson($url)
{
    try {
        $response = file_get_contents($url);
        return json_decode($response);
    } catch (Exception $e) {
        return false;
    }
}

function getIdCategory($categories, $slug)
{
    foreach ($categories as $category) {
        if ($category->slug == $slug) {
            return $category->id;
        }
    }
}

function getFileExtension($file){
    $explode = explode('.',$file);
    return $explode[1];
}