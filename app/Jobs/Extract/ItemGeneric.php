<?php

namespace App\Jobs\Extract;

use App\Jobs\Job;
use App\Models\Items\Item;
use Bus;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Storage;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description here...
 */
class ItemGeneric extends Job
{
    protected $code;
    protected $lat;
    protected $lng;
    protected $filePath;
    protected $description;
    protected $category;

    public function __construct($code, $lat, $lng)
    {
        $this->code = $code;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->filePath = env('BP_RAW_FOLDER', 'rawdata/').$code.env('BP_RAW_FILE_EXT', '.raw');
    }

    public function handle()
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent(Storage::get($this->filePath));

        if ($this->itemExists($crawler)) {
            print "\n > Creating a generic item of $this->code ... \n";

            $item = new Item();
            $item->code = $this->code;
            $item->lat = $this->lat;
            $item->lng = $this->lng;

            preg_match_all('/\d{1,}/', $this->code, $match);
            $item->tax_office = $match[0][0];
            $item->year = $match[0][1];

            //$this->data->title = trim($crawler->filter('#tdTitulo')->text());
            $this->category = trim($crawler->filter('th.info-table-title:nth-child(1)')->text());

            $headerDetails = $crawler->filter('#trFotoP > th:nth-child(1)');

            for ($x = 1; $x <= ($headerDetails->filter('span')->count() + 5); $x++) {
                if ($headerDetails->filter('span:nth-child('.$x.')')->count()) {
                    $currentSpan = $headerDetails->filter('span:nth-child('.$x.')')->text();

                    if (preg_match('/Base de Venda/i', $currentSpan, $match)) {
                        try {
                            $nodeText = trim($headerDetails->filter('span:nth-child('.($x + 1).')')->text());
                            $item->price = $this->extractPrice($nodeText);

                            if ($item->price != null) {
                                $item->vat = $this->extractVat($nodeText);
                            }
                        } catch (\Exception $e) {
                            $item->price = null;
                            $item->vat = null;
                        }
                    } elseif (preg_match('/Estado da Venda/i', $currentSpan, $match)) {
                        try {
                            $nodeText = trim($headerDetails->filter('span:nth-child('.($x + 1).')')->text());
                            $item->status = $this->extractStatus($nodeText);
                        } catch (\Exception $e) {
                            $item->status = null;
                        }
                    } elseif (preg_match('/Modalidade/i', $currentSpan, $match)) {
                        try {
                            $nodeText = trim($headerDetails->filter('span:nth-child('.($x + 1).')')->text());
                            $item->mode = $this->extractMode($nodeText);
                        } catch (\Exception $e) {
                            $item->mode = null;
                        }
                    }
                }
            }

            $footerDetails = $crawler->filter('#dataTable > tr:nth-child(3) > td:nth-child(1) > table:nth-child(1) > tr:nth-child(1)');

            for ($i = 1; $i <= ($footerDetails->filter('th:nth-child(1) > span')->count() + 6); $i++) {
                if ($footerDetails->filter('th:nth-child(1) > span:nth-child('.$i.')')->count()) {
                    $currentSpan = trim($footerDetails->filter('th:nth-child(1) > span:nth-child('.$i.')')->text());
                    if (preg_match('/Caracter/i', $currentSpan, $match)) {
                        try {
                            $this->description = trim($footerDetails->filter('th:nth-child(1) > span:nth-child('.($i + 1).')')->text());
                        } catch (\Exception $e) {
                            $this->description = null;
                        }
                    } elseif (preg_match('/Fiel Deposit/i', $currentSpan, $match)) {
                        try {
                            $nodeText = trim($footerDetails->filter('th:nth-child(1) > span:nth-child('.($i + 1).')')->text());
                            $item->depositary_name = $this->extractName($nodeText);
                        } catch (\Exception $e) {
                            $item->depositary_name = null;
                            $item->depositary_phone = null;
                            $item->depositary_email = null;
                        }

                        if ($item->depositary_name != null) {
                            $item->depositary_phone = $this->extractPhoneNumber($nodeText);

                            if (preg_match('/Email/i', $nodeText, $match)) {
                                $nodeText = $footerDetails->filter('th:nth-child(1) > span:nth-child('.($i + 1).') > a')->attr('href');
                                $item->depositary_email = $this->extractEmail($nodeText);
                            }
                        }
                    } elseif (preg_match('/Mediador/i', $currentSpan, $match)) {
                        try {
                            $nodeText = trim($footerDetails->filter('th:nth-child(1) > span:nth-child('.($i + 1).')')->text());
                            $item->mediator_name = $this->extractName($nodeText);
                        } catch (\Exception $e) {
                            $item->mediator_name = null;
                            $item->mediator_phone = null;
                            $item->mediator_email = null;
                        }

                        if ($item->mediator_name != null) {
                            $item->mediator_phone = $this->extractPhoneNumber($nodeText);

                            if (preg_match('/Email/i', $nodeText, $match)) {
                                $nodeText = $footerDetails->filter('th:nth-child(1) > span:nth-child('.($i + 1).') > a')->attr('href');
                                $item->mediator_email = $this->extractEmail($nodeText);
                            }
                        }
                    } elseif (preg_match('/examinar o bem/i', $currentSpan, $match)) {
                        try {
                            $nodeText = trim($footerDetails->filter('th:nth-child(1) > span:nth-child('.($i + 1).')')->text());
                            $preview_dt = $this->extractStartEndDateTime($nodeText);
                            $item->preview_dt_start = $preview_dt[0];
                            $item->preview_dt_end = $preview_dt[1];
                        } catch (\Exception $e) {
                            $item->preview_dt_start = null;
                            $item->preview_dt_end = null;
                        }
                    } elseif (preg_match('/aceitaçao das propostas/i', $currentSpan, $match)) {
                        try {
                            $nodeText = trim($footerDetails->filter('th:nth-child(1) > span:nth-child('.($i + 1).')')->text());
                            $item->acceptance_dt = $this->extractSingleDateTime($nodeText);
                        } catch (\Exception $e) {
                            $item->acceptance_dt = null;
                        }
                    } elseif (preg_match('/abertura das propostas/i', $currentSpan, $match)) {
                        try {
                            $nodeText = trim($footerDetails->filter('th:nth-child(1) > span:nth-child('.($i + 1).')')->text());
                            $item->opening_dt = $this->extractSingleDateTime($nodeText);
                        } catch (\Exception $e) {
                            $item->opening_dt = null;
                        }
                    }
                }
            }

            $headerImages = $crawler->filter('#trFotoP > th:nth-child(2)');
            $images = [];

            for ($c = 1; $c <= ($headerImages->filter('img')->count()); $c++) {
                $images[$c - 1] = $headerImages->filter('img:nth-child('.$c.')')->attr('src');
                $images[$c - 1] = preg_replace('/1(?=\.jpg)/', '2', $images[$c - 1]);
            }

            $item->images = $this->extractImages($images);

            $item->save();

            if (preg_match('/Imóveis/ui', $this->category)) {
                // to do
            } elseif (preg_match('/Veículos/ui', $this->category)) {
                Bus::dispatch(new ItemVehicle($this->code, $this->tokenize($this->description)));
            } else {
                // to do
            }
        } else {
            print "\n > The item $this->code is unavailable! \n";
        }
    }

    public function itemExists($crawler)
    {
        if ($crawler->filter('.info-element-title > p:nth-child(1)')->count() > 0) {
            // dupla verificação
            if ($crawler->filter('.info-element-title > p')->text() == 'Venda inexistente ou inactiva.' || $crawler->filter('.info-element-title > p')->text() == 'Venda não disponível para consulta') {
                //return 'not found';
            } else {
                /*Por motivos de ordem técnica, não é possível satisfazer o seu pedido neste momento.
                Por favor tente mais tarde.*/
                //return 'something strange happened here!';
            }
        }

        return true;
    }

    public function extractPrice($str)
    {
        if (preg_match('/(\d+?\.?\d+\,\d+)/', $str, $match)) {
            $match[0] = str_replace('.', '', $match[0]);
            $match[0] = str_replace(',', '.', $match[0]);

            return $match[0];
        } else {
            return;
        }
    }

    public function extractVat($str)
    {
        if (preg_match('/(\d+)(,\d+)?% IVA incluído/ui', $str, $match)) {
            return $match[0];
        } else {
            return;
        }
    }

    public function extractStatus($str)
    {
        return $str;
    }

    public function extractMode($str)
    {
        return $str;
    }

    public function extractName($str)
    {
        preg_replace('/(\\n)|(\\t)/', '', $str);

        if (preg_match('/^[^(]+(?=$|\s)/ui', $str, $match)) {
            return $match[0];
        }

        return;
    }

    public function extractPhoneNumber($str)
    {
        if (preg_match('/\d{9,}/', $str, $match)) {
            return $match[0];
        }

        return;
    }

    public function extractEmail($str)
    {
        if (preg_match('/\w+@\w+\.\w{1,}/i', $str, $match)) {
            return strtolower($match[0]);
        }

        return;
    }

    public function extractStartEndDateTime($str)
    {
        $preview_dt = [];

        if (preg_match('/\d+\-\d+\-\d+/', $str, $match)) {
            preg_match_all('/\d+\-\d+\-\d+/', $str, $match_date);
            preg_match_all('/\d+\:\d+/', $str, $match_time);

            $dt_start = $match_date[0][0].'-'.$match_time[0][0];
            $dt_end = $match_date[0][1].'-'.$match_time[0][1];

            $preview_dt[0] = Carbon::createFromFormat('Y-m-d-H:i', $dt_start);
            $preview_dt[1] = Carbon::createFromFormat('Y-m-d-H:i', $dt_end);
        } else {
            $preview_dt[0] = null;
            $preview_dt[1] = null;
        }

        return $preview_dt;
    }

    public function extractSingleDateTime($str)
    {
        if (preg_match('/\d+\-\d+\-\d+/', $str, $match_date)) {
            if (preg_match('/\d+\:\d+/', $str, $match_time)) {
                $dt = $match_date[0].'-'.$match_time[0];

                return Carbon::createFromFormat('Y-m-d-H:i', $dt);
            } else {
                $dt = $match_date[0];

                return Carbon::createFromFormat('Y-m-d', $dt);
            }
        } else {
            return;
        }
    }

    public function extractImages($external_images)
    {
        if (preg_match('/img_semfoto/', $external_images[0])) {
            return;
        } else {
            $i = 1;
            $images = [];
            $manager = new ImageManager();
            foreach ($external_images as $ext_img) {
                try {
                    $img = $manager->make($ext_img);
                    $filename = $i.'-'.$this->code.'.jpg';
                    $img->fit(600, 400);
                    $img->encode('jpg', 90);
                    $img->save('public/images/'.$filename);
                } catch (\Exception $e) {
                    // to do
                }
                $i++;
                $images[] = $filename;
            }

            return json_encode($images);
        }
    }

    /**
     * Splits a given text into smaller units called token. Breaks either on
     * whitespace or on word boundaries (ex.: dots, commas, etc). Does not
     * include punctuation characters.
     *
     * Regex explanation:
     * \pP matches any kind of punctuation character
     * \pZ matches any kind of whitespace or invisible separator
     * \pC matches invisible control characters and unused code points.
     *
     * @param string $str
     *
     * @return array
     */
    public function tokenize($str)
    {
        $result = [];

        $pattern = '/([\pZ\pC]*)([^\pP\pZ\pC]+|.)([\pP\pZ\pC]*)/u';
        preg_match_all($pattern, $str, $result);

        return $result[2];
    }
}
