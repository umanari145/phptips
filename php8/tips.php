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
echo  "\n";
$test3 = null;

$test3?->echoHobby();
/* test3の? がないと当然以下のようなエラーでおちる
Fatal error: Uncaught Error: Call to a member function echoHobby() on null in /var/www/html/php8/tips.php:27
Stack trace:
#0 {main}
*/

$test4 = new Test(
    name: 'kondou saburou',
    email: 'test3@gmail.com',
    age: 30,
    hobby: null
);

$test4->summonHobby()?->getHobby();
/* summonHobbyの? がないと当然以下のようなエラーでおちる
Fatal error: Uncaught Error: Call to a member function getHobby() on null in /var/www/html/php8/tips.php:40
Stack trace:
#0 {main}
*/

$test5 = null;

// nullだったときに??の中のものがでる(null以外でつかえないので注意)
echo $test5?->summonHobby()?->getHobby() ?? '存在しません';

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

    public function summonHobby(): ?Hobby
    {
        return $this->hobby;
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