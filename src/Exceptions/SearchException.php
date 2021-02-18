<?php

namespace Fennecio\SearchInModel\Exceptions;

use Exception;
use Inertia\Inertia;

class SearchException extends Exception
{
    //

     /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return Inertia::render('Exception/searchException');
    }
}
