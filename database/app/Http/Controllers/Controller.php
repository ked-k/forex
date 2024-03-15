<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct() {
        $appName="Mutagooka-Entreprises";
    $bizcontact="+256-772 179638";
    $bizlocation="Kampala";
    $bizname="Mutagooka-Forex Ltd";
    $email="mutagooka@gmail.com";
    $currency="UGX";
    $bstate ='diabled';
    session(['branchid' => 1]);

       View::share('appName',$appName);
       View::share('bizcontact',$bizcontact);
       View::share('bizname',$bizname);
       View::share('bizlocation',$bizlocation);
       View::share('bizemail',$email);
       View::share('mycur',$currency);
       View::share('bstate',$bstate);
       View::share(session(['branchid' => 1]));

  }
}
