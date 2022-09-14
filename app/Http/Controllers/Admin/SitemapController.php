<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Spatie\Sitemap\SitemapGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function gerarxml(Request $request)
    {
        $configupdate = $this->configService->getConfig();
        //$configupdate->sitemap_data = date('Y-m-d');
        //$configupdate->sitemap = url('/' . $configupdate->slug . '_sitemap.xml');
        //$configupdate->save();
                
        Sitemap::create()->add(Url::create('/atendimento')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.1))
            ->add('/')
            ->add('/blog')
            ->add('/paginas')
            ->add('/noticias')
            ->add('/politica-de-privacidade')
            ->writeToDisk('s3', Str::slug($configupdate->nomedosite) . '_sitemap.xml');
        
        return response()->json(['success' => true]);
    }
}
