<?php

class CollectionsTest extends Underbar_TestCase
{
    /**
     * @dataProvider provider
     */
    public function testEach($_)
    {
        $_::each(array(1, 2, 3), function($num, $i) {
            PHPUnit_Framework_TestCase::assertEquals($num, $i + 1, 'each iterators provide value and iteration count');
        });

        $answers = array();
        $obj = array('one' => 1, 'two' => 2, 'three' => 3);
        $_::each($obj, function($value, $key) use (&$answers) {
            $answers[] = $key;
        });
        $this->assertEquals(array('one', 'two', 'three'), $answers, 'iterating over objects works.');

        $answer = false;
        $_::each(array(1, 2, 3), function($num, $index, $arr) use ($_, &$answer) {
            if ($_::contains($arr, $num)) $answer = true;
        });
        $this->assertTrue($answer, 'can reference the original collection from inside the iterator');
    }

    /**
     * @dataProvider provider
     */
    public function testMap($_)
    {
        $doubled = $_::map(array(1, 2, 3), function($num) {
            return $num * 2;
        });
        $this->assertEquals(array(2, 4, 6), $_::toArray($doubled), 'doubled numbers');

        $doubled = $_::collect(array(1, 2, 3), function($num) {
            return $num * 2;
        });
        $this->assertEquals(array(2, 4, 6), $_::toArray($doubled), 'aliased as "collect"');
    }

    /**
     * @dataProvider provider
     */
    public function testReduce($_)
    {
        $sum = function($acc, $n) {
            return $acc + $n;
        };

        $result = $_::reduce(array(1, 2, 3), $sum, 0);
        $this->assertEquals(6, $result, 'can sum up an array');

        $result = $_::inject(array(1, 2, 3), $sum, 0);
        $this->assertEquals(6, $result, 'aliased as "inject"');

        $result = $_::foldl(array(1, 2, 3), $sum, 0);
        $this->assertEquals(6, $result, 'aliased as "foldl"');
    }

    /**
     * @dataProvider provider
     */
    public function testReduceRight($_)
    {
        $list = $_::reduceRight(array('foo', 'bar', 'baz'), function($memo, $str) {
            return $memo . $str;
        }, '');
        $this->assertEquals($list, 'bazbarfoo', 'can perform right folds');

        $list = $_::foldr(array("foo", "bar", "baz"), function($memo, $str) {
            return $memo . $str;
        }, '');
        $this->assertEquals($list, 'bazbarfoo', 'aliased as "foldr"');

        $sum = $_::reduceRight(array('a' => 1, 'b' => 2, 'c' => 3), function($sum, $num) {
            return $sum + $num;
        }, 0);
        $this->assertEquals(6, $sum, 'on object');

        // Assert that the correct arguments are being passed.
        $args = null;
        $memo = array();
        $object = array('a' => 1, 'b' => 2);

        $_::reduceRight($object, function() use (&$args) {
            $args || ($args = func_get_args());
        }, $memo);
        $this->assertEmpty($args[0]);
        $this->assertEquals(2, $args[1]);

        $result = $_::reduceRight($_::range(10), function($x, $y) {
            return $x - $y;
        }, 0);
        $this->assertEquals(-45, $result);
    }

    /**
     * @dataProvider provider
     */
    public function testFind($_)
    {
        $array = array(1, 2, 3, 4);
        $this->assertEquals(3, $_::find($array, function($n) { return $n > 2; }), 'should return first found `value`');
        $this->assertNull($_::find($array, function() { return false; }), 'should return `undefined` if `value` is not found');

        $result = $_::find(array(1, 2, 3), function($num) { return $num * 2 == 4; });
        $this->assertEquals(2, $result, 'found the first "2" and broke the loop');

        $result = $_::detect(array(1, 2, 3), function($num) { return $num * 2 == 4; });
        $this->assertEquals(2, $result, 'alias as "detect"');
    }

    /**
     * @dataProvider provider
     */
    public function testFilter($_)
    {
        $evens = $_::filter(array(1, 2, 3, 4, 5, 6), function($num) { return $num % 2 == 0; });
        $this->assertEquals(array(2, 4, 6), $_::toList($evens), 'selected each even number');

        $evens = $_::select(array(1, 2, 3, 4, 5, 6), function($num) { return $num % 2 == 0; });
        $this->assertEquals(array(2, 4, 6), $_::toList($evens), 'aliased as "select"');
    }

    /**
     * @dataProvider provider
     */
    public function testWhere($_)
    {
        $list = array(
            array('a' => 1, 'b' => 2),
            array('a' => 2, 'b' => 2),
            array('a' => 1, 'b' => 3),
            array('a' => 1, 'b' => 4)
        );
        $result = $_::chain($list)->where(array('a' => 1))->toArray();
        $this->assertCount(3, $result);
        $this->assertEquals(array('a' => 1, 'b' => 4), $_::last($result));

        $result = $_::chain($list)->where(array('b' => 2))->toArray();
        $this->assertCount(2, $result);
        $this->assertEquals(array('a' => 1, 'b' => 2), $_::first($result));
    }

    /**
     * @dataProvider provider
     */
    public function testFindWhere($_)
    {
        $list = array(
            array('a' => 1, 'b' => 2),
            array('a' => 2, 'b' => 2),
            array('a' => 1, 'b' => 3),
            array('a' => 1, 'b' => 4),
            array('a' => 2, 'b' => 4)
        );

        $result = $_::findWhere($list, array('a' => 1));
        $this->assertEquals($list[0], $result);
        $result = $_::findWhere($list, array('b' => 4));
        $this->assertEquals($list[3], $result);
        $result = $_::findWhere($list, array('c' => 0));
        $this->assertNull($result);
    }

    /**
     * @dataProvider provider
     */
    public function testReject($_)
    {
        $odds = $_::reject(array(1, 2, 3, 4, 5, 6), function($num) { return $num % 2 == 0; });
        $this->assertEquals(array(1, 3, 5), $_::toList($odds), 'rejected each even number');
    }

    /**
     * @dataProvider provider
     */
    public function testEvery($_)
    {
        $this->assertTrue($_::every(array(), "$_::identity"), 'the empty set');
        $this->assertTrue($_::every(array(true, true, true), array($_, 'identity')), 'all true values');
        $this->assertFalse($_::every(array(true, false, true), array($_, 'identity')), 'one false value');
        $this->assertTrue($_::every(array(0, 10, 28), function($num) { return $num % 2 == 0; }), 'even numbers');
        $this->assertFalse($_::every(array(0, 11, 28), function($num) { return $num % 2 == 0; }), 'an odd number');
        $this->assertTrue($_::every(array(1), array($_, 'identity')) === true, 'cast to boolean - true');
        $this->assertTrue($_::every(array(0), array($_, 'identity')) === false, 'cast to boolean - false');
        $this->assertTrue($_::all(array(true, true, true), array($_, 'identity')), 'aliased as "all"');
        $this->assertFalse($_::every(array(null, null, null), array($_, 'identity')), 'works with arrays of null');
    }

    /**
     * @dataProvider provider
     */
    public function testSome($_)
    {
        $this->assertFalse($_::some(array()), 'the empty set');
        $this->assertFalse($_::some(array(false, false, false)), 'all false values');
        $this->assertTrue($_::some(array(false, false, true)), 'one true value');
        $this->assertTrue($_::some(array(null, 0, 'yes', false)), 'a string');
        $this->assertFalse($_::some(array(null, 0, '', false)), 'falsy values');
        $this->assertFalse($_::some(array(1, 11, 29), function($num) { return $num % 2 == 0; }), 'all odd numbers');
        $this->assertTrue($_::some(array(1, 10, 29), function($num) { return $num % 2 == 0; }), 'an even number');
        $this->assertTrue($_::some(array(1), array($_, 'identity')) === true, 'cast to boolean - true');
        $this->assertTrue($_::some(array(0), array($_, 'identity')) === false, 'cast to boolean - false');
        $this->assertTrue($_::any(array(false, false, true)), 'aliased as "any"');
    }

    /**
     * @dataProvider provider
     */
    public function testContains($_)
    {
        $this->assertTrue($_::contains(array(1, 2, 3), 2), 'two is in the array');
        $this->assertFalse($_::contains(array(1, 3, 9), 2), 'two is not in the array');
        $this->assertTrue($_::contains(array('moe' => 1, 'larry' => 3, 'curly' => 9), 3) === true, '$_::include on objects checks their values');
    }

    /**
     * @dataProvider provider
     */
    public function testInvoke($_)
    {
        $list = array($_::chain(array(5, 1, 7)), $_::chain(array(3, 2, 1)));
        $result = $_::chain($list)->invoke('sort')->map("$_::toArray");
        $this->assertEquals(array(array(1, 5, 7), array(1, 2, 3)), $_::toArray($result), 'first array sorted');
    }

    /**
     * @dataProvider provider
     */
    public function testPluck($_)
    {
        $people = array(
            array('name' => 'moe', 'age' => 30),
            array('name' => 'curly', 'age' => 50)
        );
        $result = $_::pluck($people, 'name');
        $this->assertEquals(array('moe', 'curly'), $_::toArray($result), 'pulls names out of arrays');

        $people = array(
            (object) array('name' => 'moe', 'age' => 30),
            (object) array('name' => 'curly', 'age' => 50)
        );
        $result = $_::pluck($people, 'name');
        $this->assertEquals(array('moe', 'curly'), $_::toArray($result), 'pulls names out of objects');
    }

    /**
     * @dataProvider provider
     */
    public function testMax($_)
    {
        $this->assertEquals(3, $_::max(array(1, 2, 3)), 'can perform a regular max()');

        $neg = $_::max(array(1, 2, 3), function($num) { return -$num; });
        $this->assertEquals(1, $neg, 'can perform a computation-based max');

        $this->assertEquals(-INF, $_::max(array()), 'Maximum value of an empty array');
        $this->assertEquals('a', $_::max(array('a' => 'a')), 'Maximum value of a non-numeric collection');

        $this->assertEquals(299999, $_::max($_::range(1, 300000)), 'Maximum value of a too-big array');
    }

    /**
     * @dataProvider provider
     */
    public function testMin($_)
    {
        $this->assertEquals(1, $_::min(array(1, 2, 3)), 'can perform a regular min()');

        $neg = $_::min(array(1, 2, 3), function($num) { return -$num; });
        $this->assertEquals(3, $neg, 'can perform a computation-based min');

        $this->assertEquals(INF, $_::min(array()), 'Minimum value of an empty object');
        $this->assertEquals('a', $_::min(array('a' => 'a')), 'Minimum value of a non-numeric collection');

        $now = new DateTime();
        $now->setTimestamp(9999999999);
        $then = new DateTime();
        $then->setTimestamp(0);
        $this->assertEquals($then, $_::min(array($now, $then)));
        $this->assertEquals($then, $_::min(array($then, $now)));

        $this->assertEquals(1, $_::min($_::range(1, 300000)), 'Minimum value of a too-big array');
    }

    /**
     * @dataProvider provider
     */
    public function testSum($_)
    {
        $this->assertEquals(45, $_::sum($_::range(10)), 'sum 0..9');
        $this->assertEquals(0, $_::sum(array()), 'sum empty array');
    }

    /**
     * @dataProvider provider
     */
    public function testProduct($_)
    {
        $this->assertEquals(362880, $_::product($_::range(1, 10)), 'product 1..9');
        $this->assertEquals(1, $_::product(array()), 'product empty array');
    }

    /**
     * @dataProvider provider
     */
    public function testAverage($_)
    {
        $this->assertEquals(4.5, $_::average($_::range(0, 10)), 'agverage between 0-9');
        $this->assertEquals(INF, $_::average(array()), 'average empty array');
    }

    /**
     * @dataProvider provider
     */
    public function testSortBy($_)
    {
        $people = array(
            array('name' => 'curly', 'age' => 50),
            array('name' => 'moe', 'age' => 30)
        );
        $people = $_::sortBy($people, function($person) { return $person['age']; });
        $result = $_::pluck($people, 'name');
        $this->assertEquals(array('moe', 'curly'), $_::toArray($result), 'stooges sorted by age');

        $list = array(null, 4, 1, null, 3, 2);
        $sorted = $_::sortBy($list, array($_, 'identity'));
        $this->assertEquals(array(null, null, 1, 2, 3, 4), $_::toArray($sorted), 'sortBy with undefined values');

        $list = array('one', 'two', 'three', 'four', 'five');
        $sorted = $_::sortBy($list, function($str) { return strlen($str); });
        $this->assertEquals(array('one', 'two', 'four', 'five', 'three'), $_::toArray($sorted), 'sorted by length');

        $collection = array(
            array(null, 1), array(null, 2),
            array(null, 3), array(null, 4),
            array(null, 5), array(null, 6),
            array(1, 1), array(1, 2),
            array(1, 3), array(1, 4),
            array(1, 5), array(1, 6),
            array(2, 1), array(2, 2),
            array(2, 3), array(2, 4),
            array(2, 5), array(2, 6)
        );
        $actual = $_::sortBy($collection, function($pair) {
            return $pair[0];
        });
        $this->assertEquals($_::toArray($actual), $collection,  'sortBy should be stable');
    }

    /**
     * @dataProvider provider
     */
    public function testGroupBy($_)
    {
        $parity = $_::chain(array(1, 2, 3, 4, 5, 6))
            ->groupBy(function($num){ return $num % 2; })
            ->toArray();
        $this->assertArrayHasKey(0, $parity, 'created a group for each value');
        $this->assertArrayHasKey(1, $parity, 'created a group for each value');

        $this->assertEquals(array(1, 3, 5), $parity[1], 'put each even number in the right group');
        $this->assertEquals(array(2, 4, 6), $parity[0], 'put each even number in the right group');

        $list = array('one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten');
        $result = $_::chain($list)
            ->groupBy(function($x) { return strlen($x); })
            ->toArray();
        $shouldBe = array(
            3 => array('one', 'two', 'six', 'ten'),
            4 => array('four', 'five', 'nine'),
            5 => array('three', 'seven', 'eight'),
        );
        $this->assertEquals($shouldBe, $result);

        $grouped = $_::chain(array(4.2, 6.1, 6.4))
            ->groupBy(function($num) {
                return floor($num) > 4 ? 'one' : 'two';
            })->toArray();
        $this->assertEquals(array(6.1, 6.4), $grouped['one']);
        $this->assertEquals(array(4.2), $grouped['two']);

        $grouped = $_::chain(array(1, 2, 1, 2, 3))
            ->groupBy()
            ->toArray();
        $this->assertCount(2, $grouped['1']);
        $this->assertCount(1, $grouped['3']);

        $dict = array(
            array('key' => 'foo', 'value' => 1),
            array('key' => 'foo', 'value' => 2),
            array('key' => 'foo', 'value' => 3),
            array('key' => 'bar', 'value' => 4),
            array('key' => 'bar', 'value' => 5),
        );
        $grouped = $_::chain($dict)
            ->groupBy('key', true)
            ->map(function($xs) use ($_) { return $_::toArray($_::pluck($xs, 'value')); })
            ->toArray();
        $this->assertEquals(array(1, 2, 3), $grouped['foo']);
        $this->assertEquals(array(4, 5), $grouped['bar']);
    }

    /**
     * @dataProvider provider
     */
    public function testIndexBy($_)
    {
        $parity = $_::chain(array(1, 2, 3, 4, 5))
            ->indexBy(function($num) {
                return $num % 2 == 0 ? 'true' : 'false';
            })
            ->toArray();
        $this->assertEquals($parity['true'], 4);
        $this->assertEquals($parity['false'], 5);

        $list = array(
            array('string' => 'one', 'length' => strlen('one')),
            array('string' => 'two', 'length' => strlen('two')),
            array('string' => 'three', 'length' => strlen('three')),
            array('string' => 'four', 'length' => strlen('four')),
            array('string' => 'five', 'length' => strlen('five')),
            array('string' => 'six', 'length' => strlen('six')),
            array('string' => 'seven', 'length' => strlen('seven')),
            array('string' => 'eight', 'length' => strlen('eight')),
            array('string' => 'nine', 'length' => strlen('nine')),
            array('string' => 'ten', 'length' => strlen('ten')),
        );
        $grouped = $_::chain($list)
            ->indexBy('length')
            ->toArray();
        $this->assertEquals($grouped[3]['string'], 'ten');
        $this->assertEquals($grouped[4]['string'], 'nine');
        $this->assertEquals($grouped[5]['string'], 'eight');

        $array = array(1, 2, 1, 2, 3);
        $grouped = $_::chain($array)->indexBy()->toArray();
        $this->assertEquals($grouped[1], 1);
        $this->assertEquals($grouped[2], 2);
        $this->assertEquals($grouped[3], 3);
    }

    /**
     * @dataProvider provider
     */
    public function testCountBy($_)
    {
        $parity = $_::chain(array(1, 2, 3, 4, 5))
            ->countBy(function($num){ return $num % 2; })
            ->toArray();
        $this->assertEquals(2, $parity[0]);
        $this->assertEquals(3, $parity[1]);

        $list = array('one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten');
        $grouped = $_::chain($list)
            ->countBy(function($x) { return strlen($x); })
            ->toArray();
        $this->assertEquals(4, $grouped['3']);
        $this->assertEquals(3, $grouped['4']);
        $this->assertEquals(3, $grouped['5']);

        $grouped = $_::chain(array(4.2, 6.1, 6.4))
            ->countBy(function($num) {
                return floor($num) > 4 ? 'one' : 'two';
            })
            ->toArray();
        $this->assertEquals(2, $grouped['one']);
        $this->assertEquals(1, $grouped['two']);

        $grouped = $_::chain(array(1, 2, 1, 2, 3))
            ->countBy()
            ->toArray();
        $this->assertEquals(2, $grouped['1']);
        $this->assertEquals(1, $grouped['3']);
    }

    /**
     * @dataProvider provider
     */
    public function testShuffle($_)
    {
        $numbers = $_::toList($_::range(10));
        $shuffled = $_::chain($numbers)->shuffle()->sort()->toList();
        $this->assertEquals($numbers, $shuffled, 'contains the same members before and after shuffle');
    }

    /**
     * @dataProvider provider
     */
    public function testSample($_)
    {
        $numbers = range(0, 9);
        $allSampled = $_::chain($numbers)->sample(10)->sort()->toList();
        $this->assertEquals($numbers, $allSampled);

        $allSampled = $_::chain($numbers)->sample(100)->sort()->toList();
        $this->assertEquals($numbers, $allSampled);

        $this->assertContains($_::sample($numbers), $numbers);
        $this->assertNull($_::sample(array()));
        $this->assertEmpty($_::toList($_::sample(array(), 5)));
        $this->assertEmpty($_::toList($_::sample(array(), 0)));
        $this->assertEmpty($_::toList($_::sample(array(1, 2, 3), 0)));
        $this->assertEmpty($_::toList($_::sample(array(1, 2), -1)));

        $numbers = array('a' => 1, 'b' => 2, 'c' => 3);
        $this->assertContains($_::sample($numbers), $numbers);
    }

    /**
     * @dataProvider provider
     */
    public function testMemoize($_)
    {
        $counter = 0;
        $result = $_::chain(array(1, 2, 3))
            ->map(function($n) use (&$counter) { $counter++; return $n * 2; })
            ->memoize();

        foreach ($result as $value);
        foreach ($result as $value);
        $this->assertEquals($counter, 3);
        $this->assertEquals(array(2, 4, 6), $_::toList($result));

        if ($_ === 'Underbar\\ArrayImpl') {
            $this->setExpectedException('OverflowException');
        }

        $counter = 0;
        $shouldBe = array(0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610, 987, 1597);
        $fibs = $_::chain(array(0, 1))
            ->iterate(function($pair) use (&$counter) {
                $counter++;
                return array($pair[1], $pair[0] + $pair[1]);
            })
            ->map(function($pair) { return $pair[0]; })
            ->memoize();

        $result = $_::chain($fibs)->take(count($shouldBe))->toArray();
        $this->assertEquals($shouldBe, $result);

        $result = $_::chain($fibs)->take(20)->last();
        $this->assertEquals(4181, $result);
        $this->assertEquals(20, $counter);
    }

    /**
     * @dataProvider provider
     */
    public function testToArray($_)
    {
        $array = array(1, 2, 3);
        $this->assertEquals($array, $_::toArray($array), 'cloned array contains same elements');

        $numbers = array('one' => 1, 'two' => 2, 'three' => 3);
        $this->assertEquals($numbers, $_::toArray($numbers), 'object flattened into array');

        $this->assertEquals(array('a', 'b', 'c', 'd'), $_::toArray('abcd'), 'works with string');

        $this->assertEquals(array(1), $_::toArray(1), 'works with scalar');
    }

    /**
     * @dataProvider provider
     */
    public function testToList($_)
    {
        $array = array(1, 2, 3);
        $this->assertEquals($array, $_::toList($array), 'cloned array contains same elements');

        $numbers = array('one' => 1, 'two' => 2, 'three' => 3);
        $this->assertEquals($array, $_::toList($numbers), 'object flattened into array');

        $this->assertEquals(array('a', 'b', 'c', 'd'), $_::toList('abcd'), 'works with string');

        $this->assertEquals(array(1), $_::toList(1), 'works with scalar');
    }

    /**
     * @dataProvider provider
     */
    public function testSize($_)
    {
        $this->assertEquals(3, $_::size(array('one' => 1, 'two' => 2, 'three' => 3)), 'can compute the size of an object');
        $this->assertEquals(3, $_::size($_::range(3)), 'can compute the size of an array');
        $this->assertEquals(5, $_::size('hello'), 'can compute the size of a string');
        $this->assertEquals(0, $_::size(null), 'handles nulls');

        $this->assertEquals(3, $_::size(new ArrayObject(array(1, 2, 3))), 'works with Countable');
    }
}
