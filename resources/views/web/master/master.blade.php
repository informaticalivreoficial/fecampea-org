<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"/>        
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    
    <meta name="copyright" content="{{$configuracoes->ano_de_inicio}} - {{$configuracoes->nomedosite}}">
    <meta name="language" content="pt-br" /> 
    <meta name="author" content="{{env('DESENVOLVEDOR')}}"/>
    <meta name="designer" content="Renato Montanari">
    <meta name="publisher" content="Renato Montanari">
    <meta name="url" content="{{$configuracoes->dominio}}" />
    <meta name="keywords" content="{{$configuracoes->metatags}}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="Dec 26">

    {!! $head ?? '' !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!--============ Google Fonts ======-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,300" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet" type="text/css"/>

    <!--========= Style Sheets ============-->
    <link rel="stylesheet" href="{{url('frontend/assets/css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/assets/css/pixeden-icons.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/assets/css/owl.carousel.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/assets/css/animations.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/assets/css/dl-menu.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/assets/css/main.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/assets/css/renato.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/assets/css/font-awesome.min.css')}}" />

    <script src="{{url('frontend/assets/js/modernizr-2.6.2-respond-1.1.0.min.js')}}"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{$configuracoes->getfaveicon()}}" type="image/x-icon" />

    <link rel="stylesheet" href="{{url('frontend/assets/js/jsSocials/jssocials.css')}}" />
    <link rel="stylesheet" href="{{url('frontend/assets/js/jsSocials/jssocials-theme-flat.css')}}" />
    <link rel="stylesheet" href="{{url('frontend/assets/js/shadowbox/shadowbox.css')}}"/> 

    @hasSection('css')
        @yield('css')
    @endif
</head>
<body>
    <div class="xv-overFlow">
        <!--Header -->
        <header class="style1 docHeader">  
            <nav id="sticktop" class="navbar navbar-default" style="background-color:rgba(0, 0, 0, 0.7);">
              <div class="container">
                <div class="navbar-header clearfix">
                    <a class="navbar-brand" href="<?= BASE;?>">
                        <img src="{{$configuracoes->getLogomarca()}}" alt="{{$configuracoes->nomedosite}}"/>
                    </a>
                </div>
                <div class="social-wrap">
                    <ul class="social-list">
                      <?php
                      if(FACEBOOK):
                          echo '<li><a href="'.FACEBOOK.'" target="blank" title="Facebook" class="icon-facebook"></a></li>';
                      endif;
                      if(TWITTER):
                          echo '<li><a target="_blank" href="'.TWITTER.'" title="Twitter" class="icon-twitter"></a></li>';
                      endif;
                      if(INSTAGRAN):
                          echo '<li><a target="_blank" href="'.INSTAGRAN.'" title="Instagram" class="icon-instagram"></a></li>';
                      endif;
                      if(GOOGLE):
                          echo '<li><a target="_blank" href="'.GOOGLE.'" title="Google+" class="icon-google-plus"></a></li>';
                      endif;
                      if(LINKEDIN):
                          echo '<li><a href="'.LINKEDIN.'" target="_blank" title="Linkedin" class="icon-linkedin"></a></li>';
                      endif;
                      ?>
                  </ul>
                </div>  
                  
                <div id="dl-menu" class="xv-menuwrapper responsive-menu">
                    <button class="dl-trigger">Abrir Menu</button>
                    
                    <ul class="dl-menu clearfix">
                        <li><a href="<?= BASE;?>/blog/artigos">Blog</a></li>             
                        <?php
                              $readMenu = new Read;
                              $readMenu->ExeRead("menu_topo","WHERE status = '1' AND id_pai IS NULL ORDER BY nome ASC");
                              if($readMenu->getResult()):
                                  foreach($readMenu->getResult() as $link):
          
                                  //Verifica se abre na mesma janela ou não
                                  $target = ($link['target'] == '1' ? '_blank' : '_self');
          
                                  // Verifica se é link externo ou interno
                                  $Url = ($link['url'] != '' ? $link['url'] : BASE.'/'.$link['link']);
          
                                  // Consulta se é submenu
                                  $readSubMenu = new Read;
                                  $readSubMenu->ExeRead("menu_topo","WHERE status = '1' AND id_pai = :id ORDER BY nome ASC","id={$link['id']}");
                                  if($readSubMenu->getResult()):
                              ?>
                                  <li class="parent"><a><?= $link['nome'];?> &nbsp;<img src="<?= PATCH;?>/images/seta.png" /></a>
                                  <ul class="lg-submenu">
                              <?php
                                  foreach($readSubMenu->getResult() as $sublink):
                                  //Verifica se abre na mesma janela ou não
                                  $target = ($sublink['target'] == '1' ? '_blank' : '_self');
          
                                  // Verifica se é link externo ou interno
                                  $Url = ($sublink['url'] != '' ? $sublink['url'] : BASE.'/'.$sublink['link']);
                              ?>        
                                      <li class="parent"><a target="<?= $target;?>" href="<?= $Url;?>"><?= $sublink['nome'];?></a></li>
                              <?php
                                  endforeach;
                              ?>
                                  </ul> 
                                  
                                  </li>
                              <?php
                                  else:
                              ?>
                                 <li><a target="<?= $target;?>" href="<?= $Url;?>"><?= $link['nome'];?></a></li>    
                              <?php
                                  endif;
          
                                  endforeach;
                              endif;
                              ?>
                          <li><a href="<?= BASE;?>/pagina/atendimento">Atendimento</a></li>       
                    </ul>
                </div>
              </div>
            </nav>
                  
        </header> 
        <!-- Header -->

        @yield('content')
        
        <!--Footer-->
        <?php require(REQUIRE_PATCH . '/include/footer.inc.php'); ?> 
        <!--Footer-->
    </div>
    
    <!--=================================
    Script Source
    =================================-->
    <script src="{{url('frontend/assets/js/jquery.js')}}"></script>
    <script src="{{url('frontend/assets/js/jquery.dlmenu.js')}}"></script>
    <script src="{{url('frontend/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{url('frontend/assets/js/jquery.sticky.js')}}"></script>
    <script src="{{url('frontend/assets/js/jquery.inview.js')}}"></script>
    <script src="{{url('frontend/assets/js/main.js')}}"></script>
    <script src="{{url('frontend/assets/js/bootstrap.js')}}"></script>

    <script src="{{url('frontend/assets/js/jsSocials/jssocials.min.js')}}"></script>

    <script src="{{url('frontend/assets/js/shadowbox/shadowbox.js')}}"></script>       
    <script type="text/javascript">
        Shadowbox.init({
            language: 'pt',
            players: ['img', 'html', 'iframe', 'qt', 'swf', 'flv'],
        });
    </script>

    {{-- require(REQUIRE_PATCH . '/include/funcoes.inc.php'); --}}
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J7EYSK2TCK"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    
        gtag('config', 'G-J7EYSK2TCK');
    </script>
</body>
</html>