<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatPost;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Analytics;
use App\Models\Newsletter;
use App\Models\NewsletterCat;
use Illuminate\Support\Facades\DB;
use Spatie\Analytics\Period;

class AdminController extends Controller
{
    public function home()
    {
        //Users
        $time = User::where('admin', 1)->orWhere('editor', 1)->count();
        $usersAvailable = User::where('client', 1)->available()->count();
        $usersUnavailable = User::where('client', 1)->unavailable()->count();
        //Newsletter
        $listas = NewsletterCat::count();
        $emails = Newsletter::count();
        $emailsCount = Newsletter::get();
        //CHART PIZZA
        $postsArtigos = Post::where('tipo', 'artigo')->count();
        $postsPaginas = Post::where('tipo', 'pagina')->count();
        $postsNoticias = Post::where('tipo', 'noticia')->count();
        //Notícias
        $noticiasAvailable = Post::postson()->where('tipo', 'noticia')->count();
        $noticiasUnavailable = Post::postsoff()->where('tipo', 'noticia')->count();
        $noticiasTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'noticia')
                ->limit(6)
                ->postson()   
                ->get();                
        $totalViewsNoticias = Post::orderBy('views', 'DESC')
                ->where('tipo', 'noticia')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');
        
        //Artigos
        $artigosAvailable = Post::postson()->where('tipo', 'artigo')->count();
        $artigosUnavailable = Post::postsoff()->where('tipo', 'artigo')->count();
        $artigosTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'artigo')
                ->limit(6)
                ->postson()   
                ->get();                
        $totalViewsArtigos = Post::orderBy('views', 'DESC')
                ->where('tipo', 'artigo')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');
        //Páginas
        $paginasAvailable = Post::postson()->where('tipo', 'pagina')->count();
        $paginasUnavailable = Post::postsoff()->where('tipo', 'pagina')->count();
        $paginasTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'pagina')
                ->limit(6)
                ->postson()   
                ->get();
        $totalViewsPaginas = Post::orderBy('views', 'DESC')
                ->where('tipo', 'pagina')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');

        //Analitcs
        // $visitasHoje = Analytics::fetchMostVisitedPages(Period::days(1));
        // $visitas365 = Analytics::fetchTotalVisitorsAndPageViews(Period::months(5));
        // $top_browser = Analytics::fetchTopBrowsers(Period::months(5));

        
        // $analyticsData = Analytics::performQuery(
        //     Period::months(5),
        //        'ga:sessions',
        //        [
        //            'metrics' => 'ga:sessions, ga:visitors, ga:pageviews',
        //            'dimensions' => 'ga:yearMonth'
        //        ]
        //  );         
        
        return view('admin.dashboard',[
            //Newsletter
            'listas' => $listas,
            'emails' => $emails,
            'emailsCount' => $emailsCount->sum('count'),
            'time' => $time,
            //Notícias
            'noticiasAvailable' => $noticiasAvailable,
            'noticiasUnavailable' => $noticiasUnavailable,
            'noticiasTop' => $noticiasTop,
            'noticiastotalviews' => $totalViewsNoticias,
            //Artigos
            'artigosAvailable' => $artigosAvailable,
            'artigosUnavailable' => $artigosUnavailable,
            'artigosTop' => $artigosTop,
            'artigostotalviews' => $totalViewsArtigos,
            //Páginas
            'paginasAvailable' => $paginasAvailable,
            'paginasUnavailable' => $paginasUnavailable,
            'paginasTop' => $paginasTop,
            'paginastotalviews' => $totalViewsPaginas,
            'usersAvailable' => $usersAvailable,
            'usersUnavailable' => $usersUnavailable,
            'postsArtigos' => $postsArtigos,
            'postsNoticias' => $postsNoticias,
            'postsPaginas' => $postsPaginas,
            //Analytics
            //'visitasHoje' => $visitasHoje,
            //'visitas365' => $visitas365,
            //'analyticsData' => $analyticsData,
            //'top_browser' => $top_browser
        ]);
    }
}
