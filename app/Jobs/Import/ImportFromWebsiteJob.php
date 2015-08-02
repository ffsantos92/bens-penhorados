<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Jobs\Import;

use App\Jobs\Job;
use GuzzleHttp;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

/**
 * This is the import from website job.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class ImportFromWebsiteJob extends Job
{
    /**
     * The collection of categories.
     *
     * @var Collection
     */
    protected $categories;

    /**
     * The number of the last page to be crawled.
     *
     * @var int|null
     */
    protected $lastPage;

    /**
     * Create a new job instance.
     *
     * @param Collection $categories
     * @param int|null   $lastPage
     */
    public function __construct($categories, $lastPage)
    {
        $this->categories = $categories;
        $this->lastPage = $lastPage;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $existingItems = DB::table('raw_data')->lists('hash', 'code');

        $guzzle = new GuzzleHttp\Client();

        foreach ($this->categories as $category) {
            $request = $guzzle->createRequest('GET', 'www.e-financas.gov.pt/vendas/consultaVendasCurso.action?tipoConsulta='.$category->code, [
                'headers' => [
                    'User-Agent'  => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:36.0) Gecko/20100101 Firefox/36.0',
                    'Accept'      => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Referrer'    => 'http://www.e-financas.gov.pt/vendas/consultaVendasCursoForm.action?tipoConsulta='.$category->code,
                ],
                'debug' => false,
                ]);

            $response = $guzzle->send($request);

            $crawler = new Crawler((string) $response->getBody());

            $input = $crawler->filter('.right')->text();
            preg_match_all('/\d{1,}/', $input, $output);

            if (is_null($this->lastPage)) {
                if (count($output[0]) == 2) {
                    $limitPage = $output[0][1];
                } else {
                    return 'preg_match_all() failed';
                }
            } else {
                $limitPage = $this->lastPage;
            }

            for ($currentPage = 1; $currentPage <= $limitPage; $currentPage++) {
                Bus::dispatch(new WebsiteExtended($category, $existingItems, $currentPage));
            }
        }
    }
}