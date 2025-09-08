<?php get_header(); ?>
<h2>	
	単行本
</h2>
<?php
	$args = array(
		'post_type' => 'book_work',
		'posts_per_page' => 6, //最新何件表示するか
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>                
	<ul style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px;">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();
		 $img_url = get_field('thumb');
		 
		?>                                     
			<li>
				<a href="<?php the_permalink(); ?>">				
					<img src="<?= esc_url($img_url[0]['img']); ?>" alt="">
					<?= the_time('Y.m.d'); ?>
					<?= the_title(); ?>
				</a>
			</li>				
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>

<hr style="margin-top:60px;">
<h2>	
	単話配信作品
</h2>
<?php
	$args = array(
		'post_type' => 'episode',
		'posts_per_page' => 6, //最新何件表示するか
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
		?> 
	<ul style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px;">        
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();	
			$img_url = get_field('thumb');
			$relation = get_field('relation');
			$relation_ID = $relation[0]->ID;
			$relation_url = get_permalink($relation_ID);		
		?>    
			<li>
				<a href="<?= $relation_url; ?>">				
					<img src="<?= $img_url ?>" alt="">
					<?= the_time('Y.m.d'); ?>
					<?= the_title(); ?>
				</a>
			</li>				
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>
<?php get_footer(); ?>
