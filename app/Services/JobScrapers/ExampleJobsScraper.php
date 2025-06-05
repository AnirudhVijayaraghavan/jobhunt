<?php
// app/Services/JobScrapers/ExampleJobsScraper.php

namespace App\Services\JobScrapers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ExampleJobsScraper
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => 'https://www.examplejobs.com',
            'timeout' => 10,
        ]);
    }

    /**
     * Scrape ExampleJobs.com for the given keyword.
     *
     * @param  string  $keyword
     * @return array<int, array{title:string,company:string,location:string,link:string}>
     */
    public function scrape(string $keyword): array
    {
        // Build search URL (URL‐encode the query)
        $searchUrl = '/search?q=' . urlencode($keyword);

        // Fetch the page
        $response = $this->http->get($searchUrl);
        $htmlBody = (string) $response->getBody();

        $crawler = new Crawler($htmlBody);

        // For each job‐card
        $results = [];
        $crawler->filter('div.job-card')->each(function (Crawler $node) use (&$results) {
            $anchor = $node->filter('a.job-link');
            $title = trim($anchor->text());
            $relativeLink = trim($anchor->attr('href'));
            $absoluteLink = 'https://www.examplejobs.com' . $relativeLink;

            $company = trim($node->filter('span.company')->text());
            $location = trim($node->filter('span.location')->text());

            $results[] = [
                'title' => $title,
                'company' => $company,
                'location' => $location,
                'link' => $absoluteLink,
            ];
        });

        return $results;
    }
}
