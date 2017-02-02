<?php get_header();?>


<div class="inner faq">
    <section class="faq-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="gradient-text">Busca</h2>
                    <div class="input-search pRelative">
                        <form action="/" role="search">
                            <input type="text" value="" name="s" class="termo" placeholder="BUSCA POR PALAVRAS-CHAVE">
                            <div class="submit">
                            <i class="fa fa-search"></i>
                            <input type="submit" value="" />
                        </form>
                    </div>
                    </div>
                    <p class="upper">Resultados para o termo: <b><?php echo (isset($_GET['s'])) ? $_GET['s'] : ""; ?></b></p>
                    <ul class="list">
                        <?php foreach( $posts as $post ) : the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title( ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <aside class="col-md-3 col-md-offset-1">

                    <?php

                    $publicidades = get_publicidades( 293 );

                    if( ! empty( $publicidades ) ) {
                        array_rand( $publicidades, 1 );;

                    ?>

                        <div class="publicidades">
                            <a href="<?php echo $publicidades[0]['link'] ?>"><img alt="Bootstrap Image Preview" src="<?php echo $publicidades[0]['imagem'] ?>"></a>
                        </div>

                    <?php
                    }
                    ?>



                    <?php

                    $publicidades = get_publicidades( 267 );

                    if( ! empty( $publicidades ) ) {
                        array_rand( $publicidades, 1 );;

                    ?>

                        <div class="publicidades">
                            <a href="<?php echo $publicidades[0]['link'] ?>"><img alt="Bootstrap Image Preview" src="<?php echo $publicidades[0]['imagem'] ?>"></a>
                        </div>

                    <?php
                    }
                    ?>
                </aside>
            </div>
        </div>
    </section>

<?php get_footer() ?>