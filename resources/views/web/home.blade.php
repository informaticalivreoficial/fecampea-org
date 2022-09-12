@extends('web.master.master')

@section('content')

<div class="mainWrapper">
    <div class="container">
        <div class="pageContentArea clearfix">            
            <main>    
                @if (!empty($noticiasMain) && $noticiasMain->count() > 0)
                    @foreach ($noticiasMain as $noticia)
                        <article itemscope itemtype="https://schema.org/Article">
                            <figure>
                                <img itemprop="image" title="{{ $noticia->titulo }}" alt="{{ $noticia->titulo }}" src="{{ $noticia->cover() }}">
                            </figure>
                            <header>
                                <h1>
                                    <a itemprop="mainEntytiOfPage" href="{{route('web.noticia', ['slug' => $noticia->slug ])}}">
                                        <span itemprop="headline">{{ $noticia->titulo }}</span>
                                    </a>
                                </h1>
                                <time datetime="{{ Carbon\Carbon::parse($noticia->created_at)->format('Y-m-d') }}" itemprop="datePublished">{{ Carbon\Carbon::parse($noticia->created_at)->formatLocalized('%d, %B %Y') }}</time>
                                <time class="ds_none" datetime="{{ Carbon\Carbon::parse($noticia->updated_at)->format('Y-m-d') }}" itemprop="dateModified">{{ Carbon\Carbon::parse($noticia->updated_at)->format('d/m/Y') }}</time>
                                <span class="ds_none" itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name">{{$noticia->user->name}}</span></span>
                                <span class="ds_none" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                    <span itemprop="name">{{$configuracoes->nomedosite}}</span>
                                    <span itemprop="Logo" itemscope itemtype="https://schema.org/ImageObject">
                                        <img itemprop="contentUrl" src="{{ $noticia->cover() }}"/>
                                    </span>
                                </span>
                                <div class="specialContent">
                                    <div class="shareWrapper">
                                        <a href="{{route('web.noticia', ['slug' => $noticia->slug ])}}"></a>
                                    </div>
                                    <a class="cat-tag" href="{{route('web.blog.categoria', [ 'slug' => $noticia->categoriaObject->slug ])}}">{{$noticia->categoriaObject->titulo}}</a>
                                </div>
                            </header>
                        </article>
                    @endforeach
                @endif 
                </main>
        
            <aside class="sidebar">                    
                <div class="widget widget_timeline">
                    <div class="timeline-wrap">
                        @if (!empty($noticiasSidebar) && $noticiasSidebar->count() > 0)
                            @foreach ($noticiasSidebar as $noticia)
                            <article itemscope itemtype="https://schema.org/Article">
                                <figure>
                                    <img itemprop="image" title="{{ $noticia->titulo }}" alt="{{ $noticia->titulo }}" src="{{ $noticia->cover() }}">
                                </figure>
                                <header>
                                    <h3>
                                        <a itemprop="mainEntytiOfPage" href="{{route('web.noticia', ['slug' => $noticia->slug ])}}">
                                            <span itemprop="headline">{{ $noticia->titulo }}</span>
                                        </a>
                                    </h3>
                                    <time itemprop="datePublished" datetime="{{ Carbon\Carbon::parse($noticia->created_at)->format('Y-m-d') }}">{{ Carbon\Carbon::parse($noticia->created_at)->formatLocalized('%d, %B %Y') }}</time>                                
                                    <time class="ds_none" datetime="{{ Carbon\Carbon::parse($noticia->updated_at)->format('Y-m-d') }}" itemprop="dateModified">{{ Carbon\Carbon::parse($noticia->updated_at)->format('d/m/Y') }}</time>
                                    <span class="ds_none" itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name">{{$noticia->user->name}}</span></span>
                                    <span class="ds_none" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                        <span itemprop="name">{{$configuracoes->nomedosite}}</span>
                                        <span itemprop="Logo" itemscope itemtype="https://schema.org/ImageObject">
                                            <img itemprop="url" src="{{ $noticia->cover() }}"/>
                                        </span>
                                    </span>
                                </header>
                                <p>{!! $noticia->content_web !!}</p>
                            </article>
                            @endforeach
                        @endif                                             
                        <a href="{{route('web.noticias')}}" class="loadTimeline">Ver Mais</a>
                    </div>
                </div>
            </aside>
        
        </div>
    </div>   
</div>

<div class="container">   
    @if (!empty($noticiasVistos) && $noticiasVistos->count() > 0)
        <section class="most_visited">
            <header><h2>Mais Visualizados</h2></header>
            <div class="row">
                @foreach ($noticiasVistos as $noticia)
                    <div class="col-xs-12 col-sm-4">
                        <article>
                            <figure>
                                <img itemprop="image" title="{{ $noticia->titulo }}" alt="{{ $noticia->titulo }}" src="{{ $noticia->cover() }}">
                            </figure>
                            <header>
                                <h3>
                                    <a href="{{route('web.noticia', ['slug' => $noticia->slug ])}}">
                                        {{ $noticia->titulo }}
                                    </a>
                                </h3>
                                <time datetime="{{ Carbon\Carbon::parse($noticia->created_at)->format('Y-m-d') }}">{{ Carbon\Carbon::parse($noticia->created_at)->formatLocalized('%d, %B %Y') }}</time>                                
                            </header>
                            <div class="article_content">
                                <p>{!! $noticia->content_web !!}</p>
                            </div>
                            <footer>
                            <a href="{{route('web.noticia', ['slug' => $noticia->slug ])}}" class="readMore">Leia Mais</a> 
                            </footer>
                        </article>
                    </div>
                @endforeach 
            </div>
        </section>
    @endif
</div>

@endsection