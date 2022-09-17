@extends("web.{$configuracoes->template}.master.master")

@section('content')
    
<div class="mainWrapper page">
    <div class="container">
        <div class="pageContentArea">
            <main>
                <header id="alertatendiento">
                    <h1>Atendimento</h1>
                </header>
                
                <div class="pageContent">            					
                    <form action="" method="post" autocomplete="off" class="j_formsubmit">                
                        @csrf
                        <div id="js-contact-result"></div>
                        <!-- HONEYPOT -->
                        <input type="hidden" class="noclear" name="bairro" value="" />
                        <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                        <div class="row form_hide">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="fe-name" class="required">Seu Nome</label>
                                <input id="fe-name" name="nome" type="text"/>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-lg-6">
                                <label for="fe-email" class="required">Seu E-mail</label>
                                <input id="fe-email" name="email" type="text"/>
                            </div>
                        </div> 
                        
                        <div class="row form_hide">
                            <div class="col-xs-12 col-md-12">
                                <label for="fe-message" class="required">Sua Mensagem</label>
                                <textarea id="fe-message" name="mensagem"></textarea>
                            </div>
                         </div>  
                        
                        <p class="text-center form_hide">
                            <button class="btn btn-default" id="js-contact-btn" type="submit" name="submit">Enviar Agora</button>
                        </p>
                        
                    </form>
                </div>
            </main>
        </div>
    </div>
    </div>
@endsection

@section('js')
<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.sendEmail') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-contact-btn").attr("disabled", true);
                    form.find('#js-contact-btn').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(resposta){
                    $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-140}, 'slow');
                    if(resposta.error){
                        form.find('#js-contact-result').html('<div class="alert alert-danger error-msg">'+ resposta.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('#js-contact-result').html('<div class="alert alert-success error-msg">'+ resposta.sucess +'</div>');
                        form.find('.error-msg').fadeIn();                    
                        form.find('input[class!="noclear"]').val('');
                        form.find('textarea[class!="noclear"]').val('');
                        form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(resposta){
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').html("Enviar Agora");                                
                }
            });

            return false;
        });

    });
</script>   
@endsection