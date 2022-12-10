<?php


// 名前付き引数
$test = new Test(
    name: 'yamada tarou',
    email: 'test@gmail.com',
    age: 20,
    hobby: null
);
$test->testEcho();
$test->echoHobby();

// 名前付き引数
$test2 = new Test(
    name: 'suzuki jirou',
    email: 'test2@gmail.com',
    age: 30,
    hobby: new Hobby('baseball')
);

$test2->testEcho();
$test2->echoHobby();

class Test
{
    public function __construct(
        private string $name,
        private string $email,
        private int $age,
        private ?Hobby $hobby
    ) {
    }

    public function testEcho(): void
    {
        echo 'My name is ' . $this->name . "\n";
        echo 'email is ' . $this->email . "\n";
        echo 'age is ' . $this->age . "\n";
    }

    public function echoHobby(): void
    {
        // Null安全オペレーター
        echo 'hobby  ' . $this->hobby?->getHobby();
    }
}

Class Hobby
{
    public function __construct(private string $hobby)
    {
    }

    public function getHobby(): string
    {
        return $this->hobby;
    }
}