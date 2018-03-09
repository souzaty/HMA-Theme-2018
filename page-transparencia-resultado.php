<?php
/* Template Name: Transparência Resultado */
/**
 * @package WordPress
 * @subpackage HMA
 * @since HMA 1.0
*/
?>
<?php get_header(); ?>
<div id="transparencia-hma">
   <header>
      <div class="intro-heading">
         <div class="container">
            <div class="row campo-pesquisa">
               <div class="col-lg-12">
                  <hr style="height:100px; background:transparent; border:none;" >
               </div>
            </div>
         </div>
      </div>
   </header>
   <section id="transparencia">
      <!-- Section Numeros full width -->
      <section id="numeros-full" class="ghost">
         <div class="container">
            <div class="row gutter-0">
               <?php include 'includes/heelj-section_numbers_full.php'; ?>
            </div>
         </div>
      </section>
      <div class="container">
         <div class="row">
            <div class="col-md-9 col-sm-12">
               <h1 style="font-style: italic; margin-bottom: 10px">Resultados da pesquisa</h1>
               <?php
                  $pesquisa_transparencia = trim($_GET['pesquisa_transparencia']);
                  $unidadeSelectSlug = preg_split('/,/', trim($_GET['unidadeSelect']));
                  $anoSelect = preg_split('/,/', trim($_GET['anoSelect']));
                  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                  $busca_transparencia = array(
                        'post_type' => 'transparencia',
                        'posts_per_page' => -1,
                        's' => $pesquisa_transparencia,
                        'tax_query' => array(
                              array(
                                    'taxonomy' => 'Tipo documento',
                                    'field'    => 'slug',
                                    'terms'    => $unidadeSelectSlug,
                                    'operator'     => 'IN'
                              ),
                              array(
                                    'taxonomy' => 'Ano',
                                    'field'    => 'slug'
                                    'terms'    => $anoSelect,
                                    'operator'     => 'IN'
                              ),
                        ),
                        'paged' => $paged
                  );
                  $wp_query_busca_transparencia = new WP_Query( $busca_transparencia );
                  //$wp_query->query('s='.$pesquisa_transparencia.'&post_type=transparencia&posts_per_page=-1&paged=' . $paged);
                  $count_transparencia = $wp_query_busca_transparencia->post_count;
                   ?>
               <p style="font-style: italic; font-size: 1.1em;"><?php echo $count_transparencia; ?> resultados encontrados para o(s) termo(s) <span style="color:#0072a4"><b>"<?php  echo $_GET['pesquisa_transparencia']; ?>"</b></span> em <?php  echo str_replace("-", " ", ucwords($_GET['unidadeSelect'])); echo ', '; echo $_GET['anoSelect']; ?>.</p>
               <div class="result-arrow"></div>
               <?php if ($wp_query_busca_transparencia->have_posts()) : ?>
               <?php while ($wp_query_busca_transparencia->have_posts()) : $wp_query_busca_transparencia->the_post(); ?>
               <div class="resultado">
                  <p class="result-post-date"><span class="clock"></span><?php the_time('j/m/Y'); ?> <span class="tag"></span>
                     <?php
                        $terms = get_the_terms( $post->ID, 'Ano' );
                        if ( $terms && ! is_wp_error( $terms ) ) :
                        $vehicle_details = array();
                        foreach ( $terms as $term ) {
                        $vehicle_details[] = $term->name;
                        }
                        $vehicle_detail = join( ", ", $vehicle_details);
                        echo $vehicle_detail;
                        endif;
                        echo ", ";
                        $terms = get_the_terms( $post->ID, 'Tipo documento' );
                        if ( $terms && ! is_wp_error( $terms ) ) :
                        $vehicle_details = array();
                        foreach ( $terms as $term ) {
                        $vehicle_details[] = $term->name;
                        }
                        $vehicle_detail = join( ", ", $vehicle_details);
                        echo $vehicle_detail;
                        endif;
                        ?>
                  </p>
                  <?php $upload_documento_transparencia = get_post_meta($post->ID, 'upload_documento_transparencia', true); ?>
                  <p class="result-post-title"><a href="<?php echo $upload_documento_transparencia; ?>" target="_blank"><?php the_title(); ?></a></p>
               </div>
               <?php endwhile;?><?php endif; ?><?php wp_reset_query(); ?>
            </div>
            <!-- contact fomr -->
            <div class="col-md-3 col-sm-12">
               <div class="conteiner-transparencia-form">
                  <h4>N&atilde;o encontrou o que procura?</h4>
                  <p>Valorizamos uma gest&atilde;o transparente. Preencha os dados abaixo e solicite.</p>
                  <?php echo do_shortcode("[gravityform id=3 title=false description=false ajax=true tabindex=49]"); ?>
               </div>
               <p class="procurar-indicador-sidebar center">
                  ou ligue para (63) 3413-7428
               </p>
               <p class="procurar-indicador-sidebar center">
                  <a href="mailto:contato@ibgh.org.br">contato@ibgh.org.br</a>
               </p>
            </div>
         </div>
      </div>
   </section>
</div>
<?php get_footer(); ?>
