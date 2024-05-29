<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            // dd($e->attributes);
            if (isset($e->attributes['message'])) {
                
                return redirect()->back()->with('error', $e->attributes['message']);
            }
            
            return redirect()->route('home');
            // return response()->json([
            //     'responseMessage' => 'You do not have the required authorization.',
            //     'responseStatus'  => 403,
            // ]);
        });


        $this->reportable(function (Throwable $e) {
            //
        });
    }
}