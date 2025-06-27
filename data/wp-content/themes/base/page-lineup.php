<?php get_header(); ?>
作品一覧

<?php
	$args = array(
		'post_type' => 'volume',
		'posts_per_page' => -1, //最新何件表示するか
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>                
	<ul>                    
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>                                     
			<li>
				<a href="<?php the_permalink(); ?>">				
					<?= the_time('Y.m.d'); ?>
					<?= the_title(); ?>
				</a>
			</li>				
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>

<?php
	$args = array(
		'post_type' => 'episode',
		'posts_per_page' => -1, //最新何件表示するか
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>                
	<ul>                    
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>                                     
			<li>
				<a href="<?php the_permalink(); ?>">				
					<?= the_time('Y.m.d'); ?>
					<?= the_title(); ?>
				</a>
			</li>				
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>
<?php get_footer(); ?>
