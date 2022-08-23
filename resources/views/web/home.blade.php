

    
    
    <?php require(REQUIRE_PATCH . '/include/search.inc.php'); ?> 
    
    <div class="mainWrapper">
        <div class="container">
           <div class="pageContentArea clearfix">
            
                <main>            
                    <?php
                        $readNoticias = new Read;
                        $readNoticias->ExeRead("posts", "WHERE tipo = 'noticia' AND status = '1' ORDER BY data DESC LIMIT 5");
                        if($readNoticias->getResult()):
                            foreach($readNoticias->getResult() as $noticia):
                        ?>
                        <article itemscope itemtype="https://schema.org/Article">
                            <figure>
                                <?php
                                $pasta = 'uploads/';
                                if(file_exists($pasta.$noticia['thumb']) && $noticia['thumb'] != null):
                                    echo '<img itemprop="image" title="'.$noticia['titulo'].'" alt="'.$noticia['titulo'].'" src="'.BASE.'/tim.php?src='.BASE.'/uploads/'.$noticia['thumb'].'&w=1200&h=570">';
                                else:
                                    echo '<img itemprop="image" title="'.$noticia['titulo'].'" alt="'.$noticia['titulo'].'" src="'.BASE.'/tim.php?src='.PATCH.'/images/image.jpg&w=1200&h=570">';
                                endif;
                                ?>
                            </figure>
                            <header>
                                <h1><a itemprop="mainEntytiOfPage" href="<?= BASE;?>/noticia/<?= $noticia['url'];?>"><span itemprop="headline"><?= $noticia['titulo'];?></span></a></h1>
                                <time datetime="<?= date('Y-m-d', strtotime($noticia['data']));?>" itemprop="datePublished"><?= strftime('%d %b, %Y', strtotime($noticia['data']));?></time>
                                <time class="ds_none" datetime="<?= date('Y-m-d', strtotime($noticia['uppdate']));?>" itemprop="dateModified"><?= date('d/m/Y', strtotime($noticia['uppdate']));?></time>
                                <span class="ds_none" itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?= Check::getUser("usuario", $noticia['autor'], 'nome');?></span></span>
                                <span class="ds_none" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                    <span itemprop="name"><?= SITENAME;?></span>
                                    <span itemprop="Logo" itemscope itemtype="https://schema.org/ImageObject">
                                        <img itemprop="contentUrl" src="<?= BASE;?>/uploads/<?= LOGOMARCA;?>"/>
                                    </span>
                                </span>
                                <div class="specialContent">
                                    <div class="shareWrapper"><a href="<?= BASE.'/noticia/'.$noticia['url'];?>"></a></div>
                                    <a class="cat-tag" href="<?= BASE.'/categoria/'.Check::Categoria('cat_posts', $noticia['categoria'], 'url');?>"><?= Check::Categoria('cat_posts', $noticia['categoria'],'nome');?></a>
                                </div>
                            </header>
                        </article>
                        <?php
                            endforeach;
                        endif;
                    ?>    
                 </main>
            
                <aside class="sidebar">
                    
                    <div class="widget widget_timeline">
                        <div class="timeline-wrap">
                            <?php
                                $readNoticias1 = new Read;
                                $readNoticias1->ExeRead("posts", "WHERE tipo = 'noticia' AND status = '1' ORDER BY data DESC LIMIT 5,7");
                                if($readNoticias1->getResult()):
                                    foreach($readNoticias1->getResult() as $noticia1):
                                ?>
                                <article itemscope itemtype="https://schema.org/Article">
                                <figure>
                                    <?php
                                    $pasta = 'uploads/';
                                    if(file_exists($pasta.$noticia1['thumb']) && $noticia1['thumb'] != null):
                                        echo '<img itemprop="image" title="'.$noticia1['titulo'].'" alt="'.$noticia1['titulo'].'" src="'.BASE.'/tim.php?src='.BASE.'/uploads/'.$noticia1['thumb'].'&w=1200&h=720">';
                                    else:
                                        echo '<img itemprop="image" title="'.$noticia1['titulo'].'" alt="'.$noticia1['titulo'].'" src="'.BASE.'/tim.php?src='.PATCH.'/images/image.jpg&w=1200&h=570">';
                                    endif;
                                    ?>
                                </figure>
                                <header>
                                    <h3><a itemprop="mainEntytiOfPage" href="<?= BASE;?>/noticia/<?= $noticia1['url'];?>"><span itemprop="headline"><?= $noticia1['titulo'];?></span></a></h3>
                                    <time itemprop="datePublished" datetime="<?= date('Y-m-d', strtotime($noticia1['data']));?>"><?= strftime('%d %b, %Y', strtotime($noticia1['data']));?></time>                                
                                    <time class="ds_none" datetime="<?= date('Y-m-d', strtotime($noticia1['uppdate']));?>" itemprop="dateModified"><?= date('d/m/Y', strtotime($noticia1['uppdate']));?></time>
                                    <span class="ds_none" itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?= Check::getUser("usuario", $noticia1['autor'], 'nome');?></span></span>
                                    <span class="ds_none" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                        <span itemprop="name"><?= SITENAME;?></span>
                                        <span itemprop="Logo" itemscope itemtype="https://schema.org/ImageObject"><img itemprop="url" src="<?= BASE;?>/uploads/<?= LOGOMARCA;?>"/></span>
                                    </span>
                                </header>
                                    <p><?= Check::Words($noticia1['content'],20);?></p>
                            </article>
                                <?php
                                    endforeach;
                                endif;                            
                            ?>                     
                            <a href="<?= BASE;?>/noticias" class="loadTimeline">Ver Mais</a>
                        </div><!--timeline-wrap-->
                    </div>
                </aside><!--sidebar-->
            
            </div><!--pageContentArea-->
        </div>   
    </div>
    <div class="container">   
        <!--=================================
        Most visitied
        =================================-->
        <section class="most_visited">
            <header><h2>Mais Visualizados</h2></header>
            <div class="row">
                <?php
                    $readMaisVistos = new Read;
                    $readMaisVistos->ExeRead("posts", "WHERE data BETWEEN CURDATE() - INTERVAL 180 DAY AND CURDATE() AND status = '1' AND tipo = 'noticia' ORDER BY visitas DESC LIMIT 3");
                    if($readMaisVistos->getResult()):
                        foreach($readMaisVistos->getResult() as $maisvistos):
                    ?>
                    <div class="col-xs-12 col-sm-4">
                        <article>
                            <figure>
                                <?php
                                $pasta = 'uploads/';
                                if(file_exists($pasta.$maisvistos['thumb']) && $maisvistos['thumb'] != null):
                                    echo '<img title="'.$maisvistos['titulo'].'" alt="'.$maisvistos['titulo'].'" src="'.BASE.'/tim.php?src='.BASE.'/uploads/'.$maisvistos['thumb'].'&w=1200&h=570">';
                                else:
                                    echo '<img title="'.$maisvistos['titulo'].'" alt="'.$maisvistos['titulo'].'" src="'.BASE.'/tim.php?src='.PATCH.'/images/image.jpg&w=1200&h=570">';
                                endif;
                                ?>
                            </figure>
                            <header>
                                <h3><a href="<?= BASE;?>/noticia/<?= $maisvistos['url'];?>"><?= $maisvistos['titulo'];?></a></h3>
                                <time datetime="<?= date('d/m/Y H:i:s', strtotime($maisvistos['data']));?>"><?= strftime('%d %b, %Y', strtotime($maisvistos['data']));?></time>                                
                            </header>
                            <div class="article_content">
                                <p><?= Check::Words($maisvistos['content'],30);?></p>
                            </div>
                            <footer>
                               <a href="<?= BASE.'/noticia/'.$maisvistos['url'];?>" class="readMore">Leia Mais</a> 
                            </footer>
                        </article>
                    </div>
                    <?php
                        endforeach;
                    endif;
                ?>         
            </div><!--row
            <footer>
                <a class="viewAllPopular btn" href="#">More</a>
            </footer>-->
        </section>
        
    </div><!--container-->
    
     
    
    