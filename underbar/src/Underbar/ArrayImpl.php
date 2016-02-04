<?php
/**
 * This file is part of the Underbar.php package.
 *
 * Copyright (C) 2013 Shota Nozaki <emonkak@gmail.com>
 *
 * Licensed under the MIT License
 */

namespace Underbar;

class ArrayImpl extends AbstractImpl
{
    /**
     * Alias: collect
     *
     * @chainable
     * @category  Collections
     * @param     array     $xs
     * @param     callable  $f
     * @return    array
     */
    public static function map($xs, $f)
    {
        $ys = array();
        foreach ($xs as $k => $x) {
            $ys[$k] = call_user_func($f, $x, $k, $xs);
        }
        return $ys;
    }

    /**
     * Alias: select
     *
     * @chainable
     * @category  Collections
     * @param     array     $xs
     * @param     callable  $f
     * @return    array
     */
    public static function filter($xs, $f)
    {
        $ys = array();
        foreach ($xs as $k => $x) {
            if (call_user_func($f, $x, $k, $xs)) {
                $ys[$k] = $x;
            }
        }
        return $ys;
    }

    /**
     * @chainable
     * @category  Collections
     * @param     array            $xs
     * @param     callable|string  $f
     * @return    array
     */
    public static function sortBy($xs, $f)
    {
        $f = self::createCallback($f);
        $result = array();

        foreach ($xs as $k => $x) {
            $result[] = array(
                'value' => $x,
                'key' => $k,
                'criteria' => call_user_func($f, $x, $k, $xs),
            );
        }

        usort($result, function($left, $right) {
            $a = $left['criteria'];
            $b = $right['criteria'];
            if ($a !== $b) {
                return $a < $b ? -1 : 1;
            } else {
                return $left['key'] < $right['key'] ? -1 : 1;
            }
        });

        return self::pluck($result, 'value');
    }

    /**
     * @chainable
     * @category  Collections
     * @param     array            $xs
     * @param     callable|string  $f
     * @return    array
     */
    public static function groupBy($xs, $f = null)
    {
        $f = self::createCallback($f);
        $result = array();

        foreach ($xs as $k => $x) {
            $key = call_user_func($f, $x, $k, $xs);
            $result[$key][] = $x;
        }

        return $result;
    }

    /**
     * @chainable
     * @category  Collections
     * @param     array            $xs
     * @param     callable|string  $f
     * @return    array
     */
    public static function indexBy($xs, $f = null)
    {
        $f = self::createCallback($f);
        $result = array();

        foreach ($xs as $k => $x) {
            $key = call_user_func($f, $x, $k, $xs);
            $result[$key] = $x;
        }

        return $result;
    }

    /**
     * @chainable
     * @category  Collections
     * @param     array            $xs
     * @param     callable|string  $x
     * @return    array
     */
    public static function countBy($xs, $f = null)
    {
        $f = self::createCallback($f);
        $result = array();

        foreach ($xs as $k => $x) {
            $key = call_user_func($f, $x, $k, $xs);
            if (isset($result[$key])) {
                $result[$key]++;
            } else {
                $result[$key] = 1;
            }
        }

        return $result;
    }

    /**
     * @chainable
     * @category  Collections
     * @param     array  $xs
     * @return    array
     */
    public static function shuffle($xs)
    {
        $xs = self::extractIterator($xs);
        shuffle($xs);
        return $xs;
    }

    /**
     * @chainable
     * @category  Collections
     * @param     array  $xs
     * @return    array
     */
    public static function memoize($xs)
    {
        return self::toArray($xs);
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array  $xs
     * @param     int    $n
     * @return    array
     */
    public static function initial($xs, $n = 1, $guard = null)
    {
        if ($guard !== null) {
            $n = 1;
        }
        return $n > 0
             ? array_slice(self::extractIterator($xs), 0, -$n)
             : array();
    }

    /**
     * Alias: tail, drop
     *
     * @chainable
     * @category  Arrays
     * @param     array  $xs
     * @param     int    $n
     * @return    array
     */
    public static function rest($xs, $n = 1, $guard = null)
    {
        if ($guard !== null) {
            $n = 1;
        }
        return array_slice(self::extractIterator($xs), $n);
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array     $xs
     * @param     callable  $f
     * @return    array
     */
    public static function takeWhile($xs, $f)
    {
        $result = array();
        foreach ($xs as $i => $x) {
            if (!call_user_func($f, $x, $i, $xs)) {
                break;
            }
            $result[] = $x;
        }
        return $result;
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array     $xs
     * @param     callable  $f
     * @return    array
     */
    public static function dropWhile($xs, $f)
    {
        $result = array();
        $accepted = false;
        foreach ($xs as $i => $x) {
            if ($accepted || ($accepted = !call_user_func($f, $x, $i, $xs))) {
                $result[] = $x;
            }
        }
        return $result;
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array     $xs
     * @param     callable  $f
     * @return    array
     */
    public static function concatMap($xs, $f)
    {
        $ys = array();
        foreach ($xs as $k => $x) {
            foreach (call_user_func($f, $x, $k, $xs) as $y) {
                $ys[] = $y;
            }
        }
        return $ys;
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array    $xss
     * @param     boolean  $shallow
     * @return    array
     */
    public static function flatten($xss, $shallow = false, &$output = array())
    {
        foreach ($xss as $xs) {
            if (self::isTraversable($xs)) {
                if ($shallow) {
                    foreach ($xs as $x) {
                        $output[] = $x;
                    }
                } else {
                    self::flatten($xs, $shallow, $output);
                }
            } else {
                $output[] = $xs;
            }
        }
        return $output;
    }

    /**
     * @chainable
     * @varargs
     * @category  Arrays
     * @param     array  $xs
     * @param     array  *$others
     * @return    array
     */
    public static function intersection($xs)
    {
        $xss = array();
        foreach (func_get_args() as $xs) {
            $xss[] = static::extractIterator($xs);
        }
        return array_unique(call_user_func_array('array_intersect', $xss));
    }

    /**
     * Alias: unique
     *
     * @chainable
     * @category  Arrays
     * @param     array            $xs
     * @param     callable|string  $f
     * @return    array
     */
    public static function uniq($xs, $f = null)
    {
        $f = static::createCallback($f);
        $set = new Internal\Set();

        $result = [];
        foreach ($xs as $k => $x) {
            if ($set->add(call_user_func($f, $x, $k, $xs))) {
                $result[$k] = $x;
            }
        }

        return $result;
    }

    /**
     * @chainable
     * @varargs
     * @category  Arrays
     * @param     array  $xss
     * @return    array
     */
    public static function unzip($xss)
    {
        $yss = $zss = $result = array();
        $loop = true;

        foreach ($xss as $xs) {
            $yss[] = $wrapped = self::wrapIterator($xs);
            $wrapped->rewind();
            $loop = $loop && $wrapped->valid();
            $zss[] = $wrapped->current();
        }

        if (!empty($zss)) while ($loop) {
            $result[] = $zss;
            $zss = array();
            $loop = true;
            foreach ($yss as $ys) {
                $ys->next();
                $zss[] = $ys->current();
                $loop = $loop && $ys->valid();
            }
        }

        return $result;
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array  $xs
     * @param     int    $n
     * @return    array
     * @throws    OverflowException
     */
    public static function cycle($xs, $n = -1)
    {
        if ($n < 0) {
            throw new \OverflowException();
        }
        $result = array();
        while ($n-- > 0) {
            foreach ($xs as $x) {
                $result[] = $x;
            }
        }
        return $result;
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     mixed  $value
     * @param     int    $n
     * @return    array
     * @throws    OverflowException
     */
    public static function repeat($value, $n = -1)
    {
        if ($n < 0) {
            throw new \OverflowException();
        }
        return $n == 0 ? array() : array_fill(0, $n, $value);
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     mixed     $acc
     * @param     callable  $f
     * @return    array
     * @throws    OverflowException
     */
    public static function iterate($acc, $f)
    {
        throw new \OverflowException();
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array  $xs
     * @return    array
     */
    public static function reverse($xs)
    {
        return array_reverse(self::extractIterator($xs));
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array     $xs
     * @param     callable  $compare
     * @return    array
     */
    public static function sort($xs, $compare = null)
    {
        $xs = self::extractIterator($xs);
        is_callable($compare) ? usort($xs, $compare) : sort($xs);
        return $xs;
    }

    /**
     * @chainable
     * @varargs
     * @category  Arrays
     * @param     array  *$xss
     * @return    array
     */
    public static function concat()
    {
        $result = array();
        foreach (func_get_args() as $xs) {
            $result = array_merge($result, self::extractIterator($xs));
        }
        return $result;
    }

    /**
     * @chainable
     * @category  Utility
     * @param     int  $start
     * @param     int  $stop
     * @param     int  $step
     * @return    array
     */
    public static function range($start, $stop = null, $step = 1)
    {
        if ($stop === null) {
            $stop = $start;
            $start = 0;
        }

        $l = max(ceil(($stop - $start) / $step), 0);
        $range = array();

        for ($i = 0; $i < $l; $i++) {
            $range[] = $start;
            $start += $step;
        }

        return $range;
    }

    /**
     * @category  Collections
     * @param     array  $xs
     * @param     int    $n
     * @return    array
     */
    protected static function sampleN($xs, $n)
    {
        $xs = self::extractIterator($xs);
        $result = array();

        while ($n-- > 0 && !empty($xs)) {
            $key = array_rand($xs);
            if ($key === null) {
                break;
            }
            $result[] = $xs[$key];
            unset($xs[$key]);
        }

        return $result;
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array  $xs
     * @param     int    $n
     * @return    array
     */
    protected static function firstN($xs, $n)
    {
        return $n > 0
             ? array_slice(self::extractIterator($xs), 0, $n)
             : array();
    }

    /**
     * @chainable
     * @category  Arrays
     * @param     array  $xs
     * @param     int    $n
     * @return    SplQueue
     */
    protected static function lastN($xs, $n)
    {
        return $n > 0 ? array_slice(self::extractIterator($xs), -$n) : [];
    }
}
