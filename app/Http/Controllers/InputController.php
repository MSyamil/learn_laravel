<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    public function hello(Request $request): string
    {
        $name = $request->input('name');
        // or
        // $name = $request->name;
        return "Hello $name";
    }

    public function helloFirstName(Request $request): string
    {
        $firstName = $request->input('name.first');
        return "Hello $firstName";
    }

    public function helloInput(Request $request): string
    {
        $input = $request->input();
        return json_encode($input);
    }

    public function helloArray(Request $request): string
    {
        $name = $request->input('products.*.name');
        return json_encode($name);
    }

    // input type

    public function inputType(Request $request): string
    {
        $name = $request->input('name');
        $developer = $request->boolean('developer');
        $birthDate = $request->date('birth_date', 'Y-m-d');
        return json_encode([
            'name' => $name,
            'developer' => $developer,
            'birth_date' => $birthDate->format('Y-m-d')
        ]);
    }

    //filter request input

    public function filterOnly(Request $request): string
    {
        $name = $request->only('name.first', 'name.last');
        return json_encode($name);
    }

    public function filterExcept(Request $request): string
    {
        $user = $request->except('admin');
        return json_encode($user);
    }

    public function filterMerge(Request $request): string //di timpa
    {
        $request->merge([
            'admin' => false
        ]);
        // or
        // $request->mergeIfMissing(
        //     'admin' => false
        // )
        $user = $request->input();
        return json_encode($user);
    }

}
