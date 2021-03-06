<?php

use Illuminate\Validation;
use Illuminate\Filesystem;
use Illuminate\Translation;

require_once  __DIR__ . '/../vendor/autoload.php';

$filesystem = new Filesystem\Filesystem();
$fileLoader = new Translation\FileLoader($filesystem, '');
$translator = new Translation\Translator($fileLoader, 'ja_JP');
$factory = new Validation\Factory($translator);

$messages = [
    'required' => ':attribute は入力必須です.',
];

$dataToValidate = ['title' => 'Some title'];
$rules = [
    'title' => 'required',
    'body' => 'required'
];

$validator = $factory->make($dataToValidate, $rules, $messages);

if ($validator->fails()) {
    $errors = $validator->errors();
    foreach ($errors->all() as $message) {
        var_dump($message);
    }
}
