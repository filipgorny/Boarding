<?php

namespace Boarding\Card;

use Boarding\Card;

/**
 * Class Stack
 * @package Boarding\Card
 */
class Stack implements \Iterator, \Countable
{
    /**
     * @var Card[]
     */
    private $cards = [];

    /**
     * @var int
     */
    private $cursor;

    /**
     * @param Card $card
     */
    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }

    public function getLength()
    {
        return count($this->cards);
    }

    public function current()
    {
        return $this->cards[$this->cursor];
    }

    public function next()
    {
        $this->cursor++;
    }

    public function key()
    {
        return $this->cursor;
    }

    public function valid()
    {
        return isset($this->cards[$this->cursor]);
    }

    public function rewind()
    {
        $this->cursor = 0;
    }

    public function count()
    {
        return $this->getLength();
    }

    /**
     * @param Card[] $cards
     */
    public function addCards($cards)
    {
        foreach ($cards as $card) {
            $this->addCard($card);
        }
    }

    public function get($index)
    {
        if ($this->valid($index)) {
            return $this->offsetGet($index);
        }
    }
}
