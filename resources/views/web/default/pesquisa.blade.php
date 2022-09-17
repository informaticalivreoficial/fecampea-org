@extends("web.{$configuracoes->template}.master.master")

@section('content')
<div class="after-header">
	<div class="container">
    	<div class="row">
        	<div class="col-xs-12">
            	<form class="search-form" action="{{ route('web.pesquisa') }}" method="post">
                    @csrf
                	<input type="text" name="search" value="{{$search ?? 'Digite o que você procura...'}}">
                    <button type="submit"><i class="icon-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
	<div class="pageContentArea archive-content">
        <main style="width: 100%;">
            <header>
            	<ul class="breadcrumb">
                	<li><a href="#"><i class="icon-home"></i></a></li>
                    <li><span>Pesquisa no site</span></li>
                </ul>
            </header>
            
            	
                    @if ($search && !empty($data) && count($data) > 0)
                        @foreach ($data as $item)
                            <article>
                                <time datetime="2015-01-31 08:30:45.687">26 jan,2015</time>
                                <div class="article_inner clearfix">
                                    <figure class="" style="background-image: url('{{$item['img']}}');">
                                        <img src="{{$item['img']}}" width="1200" height="570" alt="{{$item['titulo']}}">
                                    </figure>
                                    <h1><a href="{{$item['link']}}">{{$item['titulo']}}</a></h1>
                                    {!! Words($item['desc'], 30) !!}
                                    <a class="readMore" href="#">Ver Mais</a>
                                </div>    
                            </article>                            
                        @endforeach
                        <div class="paging">
                            {{$data->links()}}                            
                        </div>
                    @endif                     
                           
        </main>
    </div>
        
</div>
@endsection

@section('css')
<style>
    .after-header {
        background: #313134;
        height: 200px;
        padding: 40px 0;
        margin-bottom: -75px;
    }
</style>
@endsection