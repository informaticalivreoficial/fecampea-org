<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatPost;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Analytics;
use Spatie\Analytics\Period;

class AdminController extends Controller
{
    public function home()
    {
        //Users
        $time = User::where('admin', 1)->orWhere('editor', 1)->count();
        $usersAvailable = User::where('client', 1)->available()->count();
        $usersUnavailable = User::where('client', 1)->unavailable()->count();
        $postsArtigos = CatPost::where('tipo', 'artigo')->count();
        $postsNoticias = CatPost::where('tipo', 'noticia')->count();
        $postsPaginas = CatPost::where('tipo', 'pagina')->count();

        //Notícias
        $noticiasAvailable = Post::postson()->where('tipo', 'noticia')->count();
        $noticiasUnavailable = Post::postsoff()->where('tipo', 'noticia')->count();
        //Artigos
        $artigosAvailable = Post::postson()->where('tipo', 'artigo')->count();
        $artigosUnavailable = Post::postsoff()->where('tipo', 'artigo')->count();

        //Analitcs
        $visitasHoje = Analytics::fetchMostVisitedPages(Period::days(1));
        $visitas365 = Analytics::fetchTotalVisitorsAndPageViews(Period::months(5));
        $top_browser = Analytics::fetchTopBrowsers(Period::months(5));

        $analyticsData = Analytics::performQuery(
            Period::months(5),
               'ga:sessions',
               [
                   'metrics' => 'ga:sessions, ga:visitors, ga:pageviews',
                   'dimensions' => 'ga:yearMonth'
               ]
         ); 
        

        return view('admin.dashboard',[
            'time' => $time,
            //Notícias
            'noticiasAvailable' => $noticiasAvailable,
            'noticiasUnavailable' => $noticiasUnavailable,
            //Artigos
            'artigosAvailable' => $artigosAvailable,
            'artigosUnavailable' => $artigosUnavailable,
            'usersAvailable' => $usersAvailable,
            'usersUnavailable' => $usersUnavailable,
            'postsArtigos' => $postsArtigos,
            'postsNoticias' => $postsNoticias,
            'postsPaginas' => $postsPaginas,
            //Analytics
            'visitasHoje' => $visitasHoje,
            //'visitas365' => $visitas365,
            'analyticsData' => $analyticsData,
            'top_browser' => $top_browser
        ]);
    }
}
