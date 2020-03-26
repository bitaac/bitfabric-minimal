<?php

namespace Bitaac\Admin\Http\Controllers\Misc;

use Bitaac;
use Illuminate\Http\Request;
use Bitaac\Laravel\Http\Controllers\Controller;

class TermsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * [GET] /admin/terms
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return view('admin::misc.terms');
    }

    /**
     * [POST] /admin/terms
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        Bitaac::set([
            'terms_of_service' => $request->terms_of_service,
            'rules' => $request->rules,
        ]);

        return redirect()->route('admin.terms')->withSuccess('The terms of service and rules has been updated.');
    }
}
