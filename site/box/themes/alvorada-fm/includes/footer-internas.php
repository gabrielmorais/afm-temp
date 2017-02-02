
<?php

$publicidade_rodape = get_publicidades( 728 );

// print_r($publicidade_rodape);
// die;

if( ! empty( $publicidade_rodape ) ) {

    array_rand( $publicidade_rodape, 1 );

/*    echo '<pre>';
    print_r( $publicidade_rodape );
    echo '</pre>';*/
?>

    <section class="publicidade">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="<?php echo $publicidade_rodape[0]['link'] ?>" target="_blank" class="hvr-shadow-radial"><img alt="Bootstrap Image Preview" src="<?php echo $publicidade_rodape[0]['imagem'] ?>" /></a>
                </div>
            </div>
        </div>
    </section>

<?php

}

?>


<?php

$conteudo_relacionado = new WP_Query( array(
    'post_type'         => 'conteudo',
    'posts_per_page'    => 1,
    'meta_key'          => 'colunista',
    'orderby'           => 'rand',
    'meta_query'        => array(
        array(
            'key' => '_thumbnail_id'
        )
    )
));

$programa_relacionado = new WP_Query( array(
    'post_type'         => 'programacao',
    'posts_per_page'    => 1,
    'orderby'           => 'rand',
    'meta_query'        => array(
        array(
            'key' => '_thumbnail_id'
        )
    )
));

?>

<section class="listagem listagem-compartilhamento space-margin">

        <div class="container">
        <div class="row">

            <div class="col-md-4 item">
                <div class=" hvr-shadow-radial">
                <div class="image ">
                    <?php $thumbnail_conteudo = wp_get_attachment_image_src( get_post_thumbnail_id( $conteudo_relacionado->post->ID ), 'listagem-conteudo' ); ?>
                    <a href="<?php echo get_permalink( $conteudo_relacionado->post->ID ) ?>" class="link-refresh"><img class="img-responsive" alt="<?php echo get_the_title( $conteudo_relacionado->post->ID ) ?>" src="<?php echo $thumbnail_conteudo[0] ?>" /></a>
                </div>
                <div class="content">
                <h3>
                    <a href="<?php echo get_permalink( $conteudo_relacionado->post->ID ) ?>" class="link-refresh"><?php echo get_the_title( $conteudo_relacionado->post->ID ) ?></a>
                </h3>
                <p>
                <a href="<?php echo get_permalink( $conteudo_relacionado->post->ID ) ?>" class="link-refresh"><?php echo wp_trim_words(  $conteudo_relacionado->post->post_content , 15 ); ?></a>
                </p>
                <p class="footer">
                <a href="<?php echo get_permalink( $conteudo_relacionado->post->ID ) ?>">LEIA MAIS</a>
                <a href="" class="fr mleft15 social share-link" data-url="<?php echo get_permalink( $conteudo_relacionado->post->ID ) ?>" data-title="<?php echo get_the_title( $conteudo_relacionado->post->ID ) ?>" data-network="facebook"><i class="fa fa-facebook"></i></a>
                <a href="" class="fr social share-link" data-url="<?php echo get_permalink( $conteudo_relacionado->post->ID ) ?>" data-title="<?php echo get_the_title( $conteudo_relacionado->post->ID ) ?>" data-network="twitter"><i class="fa fa-twitter"></i></a>
                </p>
                </div>
                </div>
            </div>

            <div class="col-md-4 item">
            <div class=" hvr-shadow-radial">
                <div class="image ">
                    <?php $thumbnail_programacao = wp_get_attachment_image_src( get_post_thumbnail_id( $programa_relacionado->post->ID ), 'listagem-conteudo' ); ?>
                    <a href="<?php echo get_permalink( $programa_relacionado->post->ID ) ?>" class="link-refresh"><img class="img-responsive" alt="<?php echo get_the_title( $programa_relacionado->post->ID ) ?>" src="<?php echo $thumbnail_programacao[0] ?>" /></a>
                </div>
                <div class="content">
                <h3>
                    <a href="<?php echo get_permalink( $programa_relacionado->post->ID ) ?>" class="link-refresh"><?php echo get_the_title( $programa_relacionado->post->ID ) ?></a>
                </h3>
                <p>
                <a href="<?php echo get_permalink( $programa_relacionado->post->ID ) ?>" class="link-refresh"><?php echo wp_trim_words( $programa_relacionado->post->post_content , 15 ); ?></a>
                </p>
                <p class="footer">
                <a href="<?php echo get_permalink( $programa_relacionado->post->ID  ) ?>" class="link-refresh">OUÇA</a>
                <a href="" class="fr mleft15 social share-link" data-url="<?php echo get_permalink( $programa_relacionado->post->ID ) ?>" data-title="<?php echo get_the_title( $programa_relacionado->post->ID ) ?>" data-network="facebook"><i class="fa fa-facebook"></i></a>
                <a href="" class="fr social share-link" data-url="<?php echo get_permalink( $programa_relacionado->post->ID ) ?>" data-title="<?php echo get_the_title( $programa_relacionado->post->ID  ) ?>" data-network="twitter"><i class="fa fa-twitter"></i></a>
                </p>
                </div>
            </div>
            </div>

            <?php

wp_reset_query(); wp_reset_postdata();
if ( is_post_type_archive( 'promocao' ) || is_singular( 'promocao' ) ){

    $terms_home = get_field( 'terms_home', 'option' );

    $texto_botao = 'LEIA MAIS';


    $promocao_relacionada = new WP_Query(array(
        'post_type' => 'conteudo',
        'posts_per_page' => 1,
        'orderby'=> 'rand',
        'tax_query' => array(
            array(
                'taxonomy'  => 'category',
                'terms'     => $terms_home
            )
        ),
        'meta_query' => array(
            array(
                'key' => 'destaque',
                'value' => 1
            )
        )
    ));
    $promocao_relacionada = $promocao_relacionada->posts[0];
    $texto_resumido  = wp_trim_words( $promocao_relacionada->post_content , 15 );


}else{

    $texto_botao = 'PARTICIPE';

    $promocao_relacionada = new WP_Query( array(
        'post_type'         => 'promocao',
        'posts_per_page'    => 1,
        'orderby'           => 'rand',
        'meta_query'        => array(
            array(
                'key' => 'status',
                'value' => 'aberta',
                'compare' => '='
            )
        )
    ));

    $promocao_relacionada = $promocao_relacionada->posts[0];

    $texto_resumido  = wp_trim_words( get_field('resumo',$promocao_relacionada->ID) , 15 );

}


    if (!empty($promocao_relacionada)) :
             ?>

            <div class="col-md-4 item">
            <div class=" hvr-shadow-radial">
                <div class="image ">
                    <?php $thumbnail_promocao = wp_get_attachment_image_src( get_post_thumbnail_id( $promocao_relacionada->ID ), 'listagem-conteudo' ); ?>
                    <a href="<?php echo get_permalink( $promocao_relacionada->ID ) ?>" class="link-refresh">
                    <?php if ($thumbnail_promocao):  ?>
                    <img class="img-responsive" alt="<?php echo get_the_title( $promocao_relacionada->ID ) ?>" src="<?php echo $thumbnail_promocao[0] ?>" />
                    <?php endif; ?>
                    </a>
                </div>
                <div class="content">

                <?php if ( ! is_post_type_archive( 'promocao' ) && ! is_singular( 'promocao' ) ){ ?>

                 <a class="tag <?php echo join(' ', wp_get_post_terms( $promocao_relacionada->ID, 'categoria-de-promocao', array( 'fields' => 'slugs' ) ) ); ?>"><?php echo join(' | ', wp_get_post_terms( $promocao_relacionada->ID, 'categoria-de-promocao', array( 'fields' => 'names' ) ) ); ?></a>

                <?php } ?>

                <h3>
                    <a href="<?php echo get_permalink( $promocao_relacionada->ID ) ?>" class="link-refresh"><?php echo get_the_title( $promocao_relacionada->ID ) ?></a>
                </h3>

                <p><a href="<?php echo get_permalink( $promocao_relacionada->ID ) ?>" class="link-refresh"><?php echo $texto_resumido; ?></a></p>

                <p class="footer">
                <a href="<?php echo get_permalink( $promocao_relacionada->ID ) ?>" class="link-refresh"><?php echo $texto_botao; ?></a>
                <a href="" class="fr mleft15 social share-link" data-url="<?php echo get_permalink( $promocao_relacionada->ID ) ?>" data-title="<?php echo get_the_title( $promocao_relacionada->ID ) ?>" data-network="facebook"><i class="fa fa-facebook"></i></a>
                <a href="" class="fr social share-link" data-url="<?php echo get_permalink( $promocao_relacionada->ID ) ?>" data-title="<?php echo get_the_title( $promocao_relacionada->ID ) ?>" data-network="twitter"><i class="fa fa-twitter"></i></a>
                </p>
                </div>
            </div>
            </div>

<?php endif; ?>

        </div>
    </div>
</section>