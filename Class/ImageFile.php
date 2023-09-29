<?php

  class ImageFile
  {

    public string $filepath;
    public string $keyword;
    public string $filename;
    private static array $cache = [];

    /**
     * @param string $filepath
     * @param string $keyword
     * @throws Exception
     */
    public function __construct(string $filepath, string $keyword)
    {
      $this->filepath = $filepath;
      if (!file_exists($this->filepath)) {
        throw new Exception('File does not exist.');
      }
      $this->filename = basename($this->filepath);
      $this->keyword = $keyword;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
      return '/' . IMG_DIR . '/' . $this->filename;
    }

    /**
     * @return int|false
     */
    public function getCreationTime(): int|false
    {
      return filectime($this->filepath);
    }

    /**
     * @param string $keyword
     * @return bool
     */
    public static function checkIfExists(string $keyword): bool
    {
      return 0 < count(static::scanDirectory($keyword));
    }

    /**
     * @param string $keyword
     * @return bool|array
     * @throws Exception
     */
    public static function getAll(string $keyword): bool|array
    {
      if (!static::checkIfExists($keyword)) {
        return false;
      }
      $files = static::scanDirectory($keyword);
      $instances = [];
      foreach ($files as $file) {
        $instances[] = new static($file, $keyword);
      }
      return $instances;
    }

    public static function removeCache($keyword): void
    {
      unset(static::$cache[$keyword]);
    }

    private static function scanDirectory(string $keyword): array|false
    {
      if (!isset(static::$cache[$keyword])) {
        static::$cache[$keyword] = glob(IMG_PATH . '/' . TMP_PREFIX . $keyword . '_*');
      }
      return static::$cache[$keyword];
    }
  }