<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            // Jika user belum login, redirect ke login
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
            }

            // Jika user sudah login, bisa redirect ke halaman sebelumnya atau dashboard
            return redirect()->back()->withInput()->with('error', 'Sesi Anda telah habis. Silakan coba lagi.');
        }

        return parent::render($request, $exception);
    }
}