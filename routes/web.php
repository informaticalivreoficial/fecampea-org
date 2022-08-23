<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CatPostController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ParceiroController;
use App\Http\Controllers\Admin\SlideController;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */
    //Route::get('/', 'WebController@home')->name('home');
    Route::get('/', [WebController::class, 'home'])->name('home');

    /** Página Destaque */
    Route::get('/destaque', 'WebController@spotlight')->name('spotlight');
    
    /** Página Inicial */
    Route::match(['post', 'get'], '/filtro', 'WebController@filter')->name('filter');
   
    /** Página Inicial */
    Route::get('/atendimento', 'WebController@atendimento')->name('atendimento');
    Route::get('/sendEmail', 'WebController@sendEmail')->name('sendEmail');
    Route::get('/sendNewsletter', 'WebController@sendNewsletter')->name('sendNewsletter');

    /** Página de Locação */
    Route::get('/quero-alugar', 'WebController@locacao')->name('locacao');

    /** Página de Locaçãp - Específica de um imóvel */
    Route::get('/quero-alugar/{slug}', 'WebController@rentProperty')->name('rentProperty');

    /** Página de Compra */
    Route::get('/quero-comprar', 'WebController@venda')->name('venda');

    /** Página de Compra - Específica de um imóvel */
    Route::get('/quero-comprar/{slug}', 'WebController@buyProperty')->name('buyProperty');  
    
    /** Página de Experiências */
    Route::get('/experiencias', 'WebController@experience')->name('experience');

    /** Página de Experiências - Específica de uma categoria */
    Route::get('/experiencias/{slug}', 'WebController@experienceCategory')->name('experienceCategory');

    /****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', 'WebController@artigo')->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', 'WebController@categoria')->name('blog.categoria');
    Route::get('/blog/artigos', 'WebController@artigos')->name('blog.artigos');

    /****************************** Notícias *******************************************/
    Route::get('/noticia/{slug}', 'WebController@noticia')->name('noticia');
    Route::get('/noticias', 'WebController@noticias')->name('noticias');

    /****************************** Páginas *******************************************/
    Route::get('/pagina/{slug}', 'WebController@pagina')->name('pagina');
    Route::get('/paginas', 'WebController@paginas')->name('paginas');

    /** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', 'WebController@pesquisa')->name('pesquisa');

    /** FEED */
    //Route::get('feed', 'RssFeedController@feed');
    Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');

    //****************************** Parceiros *********************************************/
    Route::get('/sendEmailParceiro', [SendEmailController::class, 'sendEmailParceiro'])->name('sendEmailParceiro');
    Route::get('/partner/{slug}', [WebController::class, 'parceiro'])->name('parceiro');
    Route::get('/partners', [WebController::class, 'parceiros'])->name('parceiros');
    

});

Route::prefix('admin')->middleware('auth')->group( function(){

    //******************************* Newsletter *********************************************/
    Route::match(['post', 'get'], 'listas/padrao', [NewsletterController::class, 'padraoMark'])->name('listas.padrao');
    Route::get('listas/set-status', [NewsletterController::class, 'listaSetStatus'])->name('listas.listaSetStatus');
    Route::get('listas/delete', [NewsletterController::class, 'listaDelete'])->name('listas.delete');
    Route::delete('listas/deleteon', [NewsletterController::class, 'listaDeleteon'])->name('listas.deleteon');
    Route::put('listas/{id}', [NewsletterController::class, 'listasUpdate'])->name('listas.update');
    Route::get('listas/{id}/editar', [NewsletterController::class, 'listasEdit'])->name('listas.edit');
    Route::get('listas/cadastrar', [NewsletterController::class, 'listasCreate'])->name('listas.create');
    Route::post('listas/store', [NewsletterController::class, 'listasStore'])->name('listas.store');
    Route::get('listas', [NewsletterController::class, 'listas'])->name('listas');

    Route::put('listas/email/{id}', [NewsletterController::class, 'newsletterUpdate'])->name('listas.newsletter.update');
    Route::get('listas/email/{id}/edit', [NewsletterController::class, 'newsletterEdit'])->name('listas.newsletter.edit');
    Route::get('listas/email/cadastrar', [NewsletterController::class, 'newsletterCreate'])->name('lista.newsletter.create');
    Route::post('listas/email/store', [NewsletterController::class, 'newsletterStore'])->name('listas.newsletter.store');
    Route::get('listas/emails/categoria/{categoria}', [NewsletterController::class, 'newsletters'])->name('lista.newsletters');

    //******************* Slides ************************************************/
    Route::get('slides/set-status', [SlideController::class, 'slideSetStatus'])->name('slides.slideSetStatus');
    Route::get('slides/delete', [SlideController::class, 'delete'])->name('slides.delete');
    Route::delete('slides/deleteon', [SlideController::class, 'deleteon'])->name('slides.deleteon');
    Route::put('slides/{slide}', [SlideController::class, 'update'])->name('slides.update');
    Route::get('slides/{slide}/edit', [SlideController::class, 'edit'])->name('slides.edit');
    Route::get('slides/create', [SlideController::class, 'create'])->name('slides.create');
    Route::post('slides/store', [SlideController::class, 'store'])->name('slides.store');
    Route::get('slides', [SlideController::class, 'index'])->name('slides.index');

    //******************** Parceiros *********************************************/
    Route::match(['post', 'get'], 'parceiros/fetchCity', [ParceiroController::class, 'fetchCity'])->name('parceiros.fetchCity');
    Route::get('parceiros/set-status', [ParceiroController::class, 'parceiroSetStatus'])->name('parceiros.parceiroSetStatus');
    Route::post('parceiros/image-set-cover', [ParceiroController::class, 'imageSetCover'])->name('parceiros.imageSetCover');
    Route::delete('parceiros/image-remove', [ParceiroController::class, 'imageRemove'])->name('parceiros.imageRemove');
    Route::delete('parceiros/deleteon', [ParceiroController::class, 'deleteon'])->name('parceiros.deleteon');
    Route::get('parceiros/delete', [ParceiroController::class, 'delete'])->name('parceiros.delete');
    Route::put('parceiros/{id}', [ParceiroController::class, 'update'])->name('parceiros.update');
    Route::get('parceiros/{id}/edit', [ParceiroController::class, 'edit'])->name('parceiros.edit');
    Route::get('parceiros/create', [ParceiroController::class, 'create'])->name('parceiros.create');
    Route::post('parceiros/store', [ParceiroController::class, 'store'])->name('parceiros.store');
    Route::get('parceiros', [ParceiroController::class, 'index'])->name('parceiros.index');

    //******************** Sitemap *********************************************/
    Route::get('gerarxml', [SitemapController::class, 'gerarxml'])->name('admin.gerarxml');

    //******************** Configurações ***************************************/
    Route::match(['post', 'get'], 'configuracoes/fetchCity', [ConfigController::class, 'fetchCity'])->name('configuracoes.fetchCity');
    Route::put('configuracoes/{config}', [ConfigController::class, 'update'])->name('configuracoes.update');
    Route::get('configuracoes', [ConfigController::class, 'editar'])->name('configuracoes.editar');

    //********************* Categorias para Posts *******************************/
    Route::get('categorias/delete', [CatPostController::class, 'delete'])->name('categorias.delete');
    Route::delete('categorias/deleteon', [CatPostController::class, 'deleteon'])->name('categorias.deleteon');
    Route::put('categorias/posts/{id}', [CatPostController::class, 'update'])->name('categorias.update');
    Route::get('categorias/{id}/edit', [CatPostController::class, 'edit'])->name('categorias.edit');
    Route::match(['post', 'get'],'posts/categorias/create/{catpai}', [CatPostController::class, 'create'])->name('categorias.create');
    Route::post('posts/categorias/store', [CatPostController::class, 'store'])->name('categorias.store');
    Route::get('posts/categorias', [CatPostController::class, 'index'])->name('categorias.index');

    //********************** Blog ************************************************/
    Route::get('posts/set-status', [PostController::class, 'postSetStatus'])->name('posts.postSetStatus');
    Route::get('posts/delete', [PostController::class, 'delete'])->name('posts.delete');
    Route::delete('posts/deleteon', [PostController::class, 'deleteon'])->name('posts.deleteon');
    Route::post('posts/image-set-cover', [PostController::class, 'imageSetCover'])->name('posts.imageSetCover');
    Route::delete('posts/image-remove', [PostController::class, 'imageRemove'])->name('posts.imageRemove');
    Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::post('posts/categoriaList', [PostController::class, 'categoriaList'])->name('posts.categoriaList');
    Route::get('posts/artigos', [PostController::class, 'index'])->name('posts.artigos');
    Route::get('posts/noticias', [PostController::class, 'index'])->name('posts.noticias');
    Route::get('posts/paginas', [PostController::class, 'index'])->name('posts.paginas');

    //*********************** Email **********************************************/
    Route::get('email/suporte', [EmailController::class, 'suporte'])->name('email.suporte');
    Route::match(['post', 'get'], 'email/enviar-email', [EmailController::class, 'send'])->name('email.send');
    Route::post('email/sendEmail', [EmailController::class, 'sendEmail'])->name('email.sendEmail');
    Route::match(['post', 'get'], 'email/success', [EmailController::class, 'success'])->name('email.success');

    //*********************** Usuários *******************************************/
    Route::match(['get', 'post'], 'usuarios/pesquisa', [UserController::class, 'search'])->name('users.search');
    Route::match(['post', 'get'], 'usuarios/fetchCity', [UserController::class, 'fetchCity'])->name('users.fetchCity');
    Route::delete('usuarios/deleteon', [UserController::class, 'deleteon'])->name('users.deleteon');
    Route::get('usuarios/set-status', [UserController::class, 'userSetStatus'])->name('users.userSetStatus');
    Route::get('usuarios/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('usuarios/time', [UserController::class, 'team'])->name('users.team');
    Route::get('usuarios/view/{id}', [UserController::class, 'show'])->name('users.view');
    Route::put('usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('usuarios/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usuarios/store', [UserController::class, 'store'])->name('users.store');
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');

    Route::get('/', [AdminController::class, 'home'])->name('home');
});


Auth::routes();
