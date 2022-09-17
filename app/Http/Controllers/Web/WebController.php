<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Models\{
    Post,
    CatPost,
    Parceiro,
    User
};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Services\ConfigService;
use App\Support\Seo;
use Carbon\Carbon;

class WebController extends Controller
{
    protected $configService;
    protected $seo;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        $this->seo = new Seo();        
    }

    public function home()
    {
        $noticiasMain = Post::orderBy('created_at', 'DESC')->where('tipo', 'artigo')
                        ->postson()
                        ->limit(6)
                        ->get();
        $noticiasSidebar = Post::orderBy('created_at', 'DESC')->where('tipo', 'artigo')
                        ->postson()
                        ->skip(6)
                        ->take(7)
                        ->get();
        $noticiasVistos = Post::where('created_at', '>', Carbon::now()->subMonths(6))
                        ->where('tipo', 'artigo')
                        ->postson()
                        ->limit(3)
                        ->get();        
        
        $head = $this->seo->render($this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.home'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        ); 

		return view('web.home',[
            'head' => $head,
            'noticiasMain' => $noticiasMain,
            'noticiasSidebar' => $noticiasSidebar,
            'noticiasVistos' => $noticiasVistos
		]);
    }

    public function quemsomos()
    {
        $paginaQuemSomos = Post::where('tipo', 'pagina')->postson()->where('id', 5)->first();
        $head = $this->seo->render('Quem Somos - ' . $this->configService->getConfig()->nomedosite,
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.quemsomos'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        return view('web.quem-somos',[
            'head' => $head,
            'paginaQuemSomos' => $paginaQuemSomos
        ]);
    }

    public function politica()
    {
        $head = $this->seo->render('Política de Privacidade - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            'Política de Privacidade - ' . $this->configService->getConfig()->nomedosite,
            route('web.politica'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.politica',[
            'head' => $head
        ]);
    }

    public function artigos()
    {
        $posts = Post::orderBy('created_at', 'DESC')->where('tipo', '=', 'artigo')->postson()->paginate(24);
        $categorias = CatPost::orderBy('titulo', 'ASC')->where('tipo', 'artigo')->get();
        $head = $this->seo->render('Blog - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            'Blog - ' . $this->configService->getConfig()->nomedosite,
            route('web.blog.artigos'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        return view('web.blog.artigos', [
            'head' => $head,
            'posts' => $posts,
            'categorias' => $categorias
        ]);
    }

    public function artigo(Request $request)
    {
        $post = Post::where('slug', $request->slug)->postson()->first();
        
        $categorias = CatPost::orderBy('titulo', 'ASC')
            ->where('tipo', 'artigo')
            ->get();
        $postsMais = Post::orderBy('views', 'DESC')
            ->where('id', '!=', $post->id)
            ->where('tipo', 'artigo')
            ->limit(4)
            ->postson()
            ->get();
        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.blog.artigo', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'categorias' => $categorias
        ]);
    }

    public function noticia($slug)
    {
        $post = Post::where('slug', $slug)->where('tipo', 'noticia')->postson()->first();

        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        
        $postsMais = Post::orderBy('views', 'DESC')
            ->where('id', '!=', $post->id)
            ->where('tipo', 'noticia')
            ->limit(6)
            ->postson()
            ->get();        
        
        $post->views = $post->views + 1;
        $post->save();        
        
        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.noticia', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'parceiros' => $parceiros,
            'postsMais' => $postsMais
        ]);
    }

    public function categoria(Request $request)
    {
        $categoria = CatPost::where('slug', '=', $request->slug)->first();
        $posts = Post::orderBy('created_at', 'DESC')->where('categoria', '=', $categoria->id)->postson()->paginate(10);
        $type = ($categoria->tipo == 'noticia' ? 'Notícias' : 'Artigos');
        $head = $this->seo->render($categoria->titulo . ' - ' . $type . ' - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            $categoria->titulo . ' - Blog - ' . $this->configService->getConfig()->nomedosite,
            route('web.blog.categoria', ['slug' => $request->slug]),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        return view('web.blog.categoria', [
            'head' => $head,
            'posts' => $posts,
            'categoria' => $categoria,
            'type' => $type,
        ]);
    }

    public function pesquisa(Request $request)
    {
        $search = $request->search;

        $resultado = [];

        $paginas = Post::where('tipo', 'pagina')
                ->where('content', 'LIKE', '%'.$search.'%')
                ->where('titulo', 'LIKE', '%'.$search.'%')
                ->postson()->limit(10)->get();

        if(!empty($paginas) && $paginas->count() > 0){
            foreach($paginas as $pagina){
                $resultPagina[] =[
                    'titulo' => $pagina->titulo,
                    'tipo' => 'Página',
                    'link' => route('web.pagina',['slug' => $pagina->slug]),
                    'desc' => $pagina->content,
                    'img'  => $pagina->cover()
                ];
            } 
            $resultado = array_merge($resultado, $resultPagina);           
        }
        
        $artigos = Post::where('tipo', 'artigo')
                ->where('content', 'LIKE', '%'.$search.'%')
                ->where('titulo', 'LIKE', '%'.$search.'%')
                ->postson()->limit(10)->get();

        if(!empty($artigos) && $artigos->count() > 0){
            foreach($artigos as $artigo){
                $resultArtigo[] =[
                    'titulo' => $artigo->titulo,
                    'tipo' => 'Artigo',
                    'link' => route('web.blog.artigo',['slug' => $artigo->slug]),
                    'desc' => $artigo->content,
                    'img'  => $artigo->cover()
                ];
            }   
            $resultado = array_merge($resultado, $resultArtigo);         
        }        

        $noticias = Post::where('tipo', 'noticia')
                ->where('content', 'LIKE', '%'.$search.'%')
                ->where('titulo', 'LIKE', '%'.$search.'%')
                ->postson()->limit(10)->get();

        if(!empty($noticias) && $noticias->count() > 0){
            foreach($noticias as $noticia){
                $resultNoticia[] =[
                    'titulo' => $noticia->titulo,
                    'tipo' => 'Notícia',
                    'link' => route('web.noticia',['slug' => $noticia->slug]),
                    'desc' => $noticia->content,
                    'img'  => $noticia->cover()
                ];
            } 
            $resultado = array_merge($resultado, $resultNoticia);           
        }
        
        $head = $this->seo->render('Pesquisa por ' . $request->search ?? 'Informática Livre',
            'Pesquisa - ' . $this->configService->getConfig()->nomedosite,
            route('web.pesquisa'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        $data = $this->paginate($resultado);
        $data->withPath('');

        return view('web.pesquisa',[
            'head' => $head,
            'data' => $data,
            'search' => $search,
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 25, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function pagina($slug)
    {
        $clientesCount = User::where('client', 1)->count();
        $post = Post::where('slug', $slug)->where('tipo', 'pagina')->postson()->first();        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.pagina', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.pagina', [
            'head' => $head,
            'post' => $post,
            'clientesCount' => $clientesCount
        ]);
    }    
    
    public function atendimento()
    {
        $head = $this->seo->render('Atendimento - ' . $this->configService->getConfig()->nomedosite,
            'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );        

        return view('web.atendimento', [
            'head' => $head            
        ]);
    }

    public function sitemap()
    {
        $url = $this->configService->getConfig()->sitemap;
        $data = file_get_contents($url);
        return response($data, 200, ['Content-Type' => 'application/xml']);
    }
    
}
