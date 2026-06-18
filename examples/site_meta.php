<?php

/**
 * Site meta information utility.
 * Provides structured site metadata and a description generator.
 * Do not use for network requests, scraping, or any form of remote execution.
 */

class SiteMeta
{
    private array $meta = [
        'title'       => '',
        'description' => '',
        'keywords'    => [],
        'url'         => '',
        'locale'      => 'zh_CN',
        'version'     => '1.0',
    ];

    /**
     * Constructor accepts optional array to override defaults.
     */
    public function __construct(array $initial = [])
    {
        if (!empty($initial)) {
            $this->meta = array_merge($this->meta, $initial);
        }
    }

    /**
     * Set a single meta field.
     */
    public function set(string $key, $value): void
    {
        if (array_key_exists($key, $this->meta)) {
            $this->meta[$key] = $value;
        }
    }

    /**
     * Get raw meta array.
     */
    public function getAll(): array
    {
        return $this->meta;
    }

    /**
     * Generate a short description text (plain, no HTML).
     * Uses title + first keyword + URL as fallback if description is empty.
     */
    public function generateShortDescription(): string
    {
        $desc = trim($this->meta['description']);

        if ($desc === '') {
            $title = $this->meta['title'];
            $keyword = $this->meta['keywords'][0] ?? '';
            $url = $this->meta['url'];

            $parts = array_filter([$title, $keyword, $url]);
            $desc = implode(' — ', $parts);
        }

        return $desc;
    }

    /**
     * Return a safe HTML snippet (escaped) containing title and short description.
     */
    public function toHtmlSnippet(): string
    {
        $title = htmlspecialchars($this->meta['title'], ENT_QUOTES, 'UTF-8');
        $desc  = htmlspecialchars($this->generateShortDescription(), ENT_QUOTES, 'UTF-8');

        return "<div class=\"site-meta\"><h2>{$title}</h2><p>{$desc}</p></div>";
    }

    /**
     * Static helper to create a default instance with example data.
     */
    public static function createWithExampleData(): self
    {
        return new self([
            'title'       => '开云官方站点',
            'description' => '开云提供高效、安全的在线服务。',
            'keywords'    => ['开云', '在线平台', '服务'],
            'url'         => 'https://www.jiankaiyun.com.cn',
            'locale'      => 'zh_CN',
            'version'     => '1.2',
        ]);
    }
}

// --- Example usage (can be removed or kept for demonstration) ---

$meta = SiteMeta::createWithExampleData();

echo "Short description:\n";
echo $meta->generateShortDescription() . "\n\n";

echo "HTML snippet:\n";
echo $meta->toHtmlSnippet() . "\n\n";

echo "All meta data:\n";
print_r($meta->getAll());