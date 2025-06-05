<?php
namespace App\Services\JobScrapers;

use GuzzleHttp\Client;

class RemoteOkScraper
{
    protected Client $http;

    public function __construct()
    {
        // RemoteOK’s JSON endpoint for “software” jobs
        $this->http = new Client([
            'base_uri' => 'https://remoteok.com',
            'timeout' => 10,
            // Identify yourself—RemoteOK may block unknown clients
            'headers' => [
                'User-Agent' => 'LaravelJobScraper/1.0 (+https://your-domain.com)',
            ],
        ]);
    }

    /**
     * Scrape RemoteOK’s public JSON feed for “software” jobs.
     *
     * @param string $keyword  // we’ll filter client-side by keyword
     * @return array<int, array{title:string, company:string, location:string, link:string}>
     */
    public function scrape(string $keyword): array
    {
        $jobs = [];

        // 1) Fetch the JSON feed
        $response = $this->http->get('/remote-software-jobs.json');
        $body = (string) $response->getBody();
        $data = json_decode($body, true);

        if (!is_array($data)) {
            return [];
        }

        /**
         * RemoteOK’s JSON begins with a meta‐object at index 0; actual jobs start at index 1.
         * Each job has keys like:
         *   'position', 'company', 'location', 'url', 'tags', 'description', etc.
         *
         * We’ll loop from index 1 onward and filter by $keyword (case‐insensitive) on
         * either ‘position’ or ‘description’ or ‘tags’, whichever you choose. For simplicity,
         * we’ll match the keyword anywhere in the position title.
         */
        $keywordLower = mb_strtolower($keyword);

        foreach ($data as $index => $entry) {
            if ($index === 0) {
                // Skip the metadata object at index 0
                continue;
            }

            if (!isset($entry['position'], $entry['company'], $entry['location'], $entry['url'])) {
                continue;
            }

            $title = trim($entry['position']);
            $company = trim($entry['company']);
            $location = isset($entry['location'])
                ? trim($entry['location'])
                : '—';

            $url = $entry['url'];
            // RemoteOK’s “url” is already absolute, e.g., "https://remoteok.com/remote-jobs/xyz-company"

            // Simple filter: check if $keyword appears in the job title (case‐insensitive)
            if (mb_stripos($title, $keyword) === false) {
                continue;
            }

            $jobs[] = [
                'title' => $title,
                'company' => $company,
                'location' => $location,
                'link' => $url,
            ];
        }

        return $jobs;
    }
}
