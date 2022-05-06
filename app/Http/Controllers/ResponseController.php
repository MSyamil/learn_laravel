<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response
    {
        return response("Hello response"); //default status code is 200
    }

    public function header(Request $request): Response
    {
        $body = [
            'first_name' => 'Ancrit',
            'last_name' => 'Dek'
        ];

        return response(json_encode($body), 200)
            ->header('Content-Type', 'application/json')
            ->withHeaders([
                'Author' => 'nivek',
                'App' => 'learn laravel'
            ]);
    }

    public function responseView(Request $request): Response
    {
        return response()
            ->view('hello', ['name' => 'Ancrit']);
    }

    public function responseJson(Request $request): JsonResponse
    {
        $body = [
            'first_name' => 'Ancrit',
            'last_name' => 'Dek'
        ];
        return response()
            ->json($body);
    }

    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()
            ->file(storage_path('app/public/test.txt'));
    }

    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()
            ->download(storage_path('app/public/test.txt'));
    }
}
