@extends("web.{$configuracoes->template}.master.master")

@section('content')
<div class="container">
	<div class="pageContentArea clearfix">
        <main style="width: 100%;">
            <article class="single-article clearfix">            	
                <header>
                    <h3 style="width: 100%;">Política de Privacidade</h3>                    
                </header>
                <div class="row">
                    <div class="col-sm-12">{!! $configuracoes->politicas_de_privacidade !!}</div>
                </div>
            </article>            
        </main>        
    </div>      
</div>
@endsection