<?php

  enum APIMethod
  {
    case SEARCH;
    case ARTWORK;

    /**
     * @return string
     */
    public function endpoint(): string
    {
      return match ($this) {
        self::SEARCH => '/artworks/search',
        self::ARTWORK => '/artworks/',
      };
    }
  }