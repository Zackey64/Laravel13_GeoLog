<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('user:create', function () {
    $validator = Validator::make([
        'name' => $this->ask('名前'),
        'email' => $this->ask('メールアドレス'),
        'password' => $this->secret('パスワード'),
        'password_confirmation' => $this->secret('パスワード（確認）'),
    ], [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:12', 'confirmed'],
    ]);

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $message) {
            $this->error($message);
        }

        return 1;
    }

    $data = $validator->validated();

    User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    $this->info('ユーザーを作成しました。');

    return 0;
});