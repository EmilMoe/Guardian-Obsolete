<?php

namespace EmilMoe\Guardian\Http;

use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Guardian
{
    /**
     * Method called when user tries to access a page without permission.
     *
     * @return HttpException|Redirect
     */
    public static function restricted()
    {
        return config('guardian.redirect') == null
            ? abort(403, 'Unauthorized access.')
            : Redirect::to(config('guardian.redirect'));
    }
}