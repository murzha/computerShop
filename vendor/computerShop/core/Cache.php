<?php

namespace computerShop;

/**
 * Cache Management Class
 * Handles file-based caching functionality
 */
class Cache
{

    use TSingletone;

    public function set($key, $data, $seconds = 3600)
    {
        if ($seconds) {
            $content = [
                'data' => $data,
                'end_time' => time() + $seconds
            ];

            $file = $this->getCacheFileName($key);

            return file_put_contents($file, serialize($content));
        }
        return false;
    }

    public function get($key)
    {
        $file = $this->getCacheFileName($key);

        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));

            if (time() <= $content['end_time']) {
                return $content['data'];
            }

            $this->delete($key);
        }
        return false;
    }

    public function delete($key): bool
    {
        $file = $this->getCacheFileName($key);
        return @unlink($file);
    }

    protected function getCacheFileName($key): string
    {
        return CACHE . '/' . md5($key) . '.txt';
    }
}
