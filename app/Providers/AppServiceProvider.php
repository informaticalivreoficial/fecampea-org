<?php

namespace App\Providers;

use App\Models\CatPost;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Goutte\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceScheme('https');
        Schema::defaultStringLength(191);
        Blade::aliasComponent('admin.components.message', 'message');

        $configuracoes = \App\Models\Configuracoes::find(1); 
        View()->share('configuracoes', $configuracoes);

        //Categorias de Notícias
        $catnoticias = CatPost::where('tipo', 'noticia')
                        ->available()
                        ->whereNotNull('id_pai')
                        ->get();
        View()->share('catnoticias', $catnoticias);

        $crowlerVersiculo = new Client();
        $url  = 'https://www.bibliaon.com/versiculo_do_dia/';
        $versiculo = $crowlerVersiculo->request('GET', $url);
        View()->share('versiculo', $versiculo->filter('.v_dia .color-box p')->text());
        
        Paginator::useBootstrap();
    }
}
