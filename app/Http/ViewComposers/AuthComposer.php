<?php

namespace App\Http\ViewComposers;

use Auth;
use Illuminate\Contracts\View\View;

class AuthComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = app('current_user');
        $allowedModules = array();
        if(session()->has('allowedModules')){
            $allowedModules = session()->get('allowedModules');
        }
        $view->with([
            'user' => $user,
            'allowedmodules' => $allowedModules
        ]);
    }

}
