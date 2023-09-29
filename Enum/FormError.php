<?php

  enum FormError: int
  {
    case NOT_FOUND = 404;
    case INTERNAL_ERROR = 500;

    /**
     * @return int
     */
    public function code(): int
    {
      return match ($this) {
        self::NOT_FOUND => 404,
        self::INTERNAL_ERROR => 500,
      };
    }

    /**
     * @return string
     */
    public function message(): string
    {
      return match ($this) {
        self::NOT_FOUND => 'No images were found. Please try different keyword',
        self::INTERNAL_ERROR => 'Internal error occurred. Please try again later.',
      };
    }

  }