<?php
/**
 * This file is part of the Underbar.php package.
 *
 * Copyright (C) 2013 Shota Nozaki <emonkak@gmail.com>
 *
 * Licensed under the MIT License
 */

namespace Underbar\Iterator;

class DropWhileIterator implements \Iterator
{
    private $it;
    private $f;

    public function __construct(\Iterator $it, $f)
    {
        $this->it = $it;
        $this->f = $f;
    }

    public function current()
    {
        return $this->it->current();
    }

    public function key()
    {
        return $this->it->key();
    }

    public function next()
    {
        $this->it->next();
    }

    public function rewind()
    {
        $this->it->rewind();
        while ($this->it->valid()) {
            $dropped = call_user_func(
                $this->f,
                $this->it->current(),
                $this->it->key(),
                $this->it
            );
            if ($dropped) {
                $this->it->next();
            } else {
                break;
            }
        }
    }

    public function valid()
    {
        return $this->it->valid();
    }
}
