<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\JobScrapers\RemoteOkScraper;
use App\Services\JobScrapers\ExampleJobsScraper;

class JobSearch extends Component
{
    public string $query = '';
    public array $results = [];
    public bool $isSearching = false;
    public string $errorMessage = '';

    public function updatedQuery()
    {
        $this->results = [];
        $this->errorMessage = '';
    }

    public function search()
    {
        $this->errorMessage = '';
        $keyword = trim($this->query);

        if (strlen($keyword) < 2) {
            $this->errorMessage = 'Please enter at least 2 characters.';
            return;
        }

        $this->isSearching = true;

        try {
            // Resolve our new RemoteOkScraper
            /** @var RemoteOkScraper $scraper */
            $scraper = app(RemoteOkScraper::class);

            $jobs = $scraper->scrape($keyword);
            $this->results = $jobs;
        } catch (\Throwable $e) {
            $this->errorMessage = 'Something went wrong: ' . $e->getMessage();
            $this->results = [];
        }

        $this->isSearching = false;
    }

    public function render()
    {
        return view('livewire.job-search');
    }

}
