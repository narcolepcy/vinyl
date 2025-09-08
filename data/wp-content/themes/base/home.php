<?php get_header(); ?>

<!-- MV設定 -->
<?php if( have_rows('mv', 'top_settings') ) :  ?>
	<ul style="display:flex; list-style:none; padding:0;">
	<?php while ( have_rows('mv', 'top_settings') ) : ?>
		<?php the_row();
		$url = get_sub_field('url');
		?>
			<li>
				<a href="<?= $url['url']; ?>" target="<?= $url['target'] == '' ? '_self' : $url['target']; ?>">
					<img src="<?= get_sub_field('img');?>" alt="">
				</a>
			</li>
		<?php endwhile;?>
	</ul>
<?php endif; ?>


<!-- 新作単行本 -->
<hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">
<h2>	
	新着配信（単話）：最新4件
</h2>
<?php
	$args = array(
		'post_type' => 'episode',
		'posts_per_page' => 4,
		'orderby' => 'date',
		'order' => 'DESC',
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>                
	<ul style="display:grid; grid-template-columns:repeat(1, 1fr); gap:20px;">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();
			$img_url = get_field('thumb');
			$relation = get_field('relation');
			$relation_ID = $relation[0]->ID;
			$relation_url = get_permalink($relation_ID);	
		?>   
			<li>
				<a href="<?= $relation_url; ?>">				
					<img style="max-width:300px;" src="<?= $img_url ?>" alt="">
					<?= the_time('Y.m.d'); ?>
					<?= the_title(); ?>
				</a>
			</li>			
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>



<!-- 新着配信 -->
 <hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">
<h2>
	新作単行本：最新６件	
</h2>
<?php
	$args = array(
		'post_type' => 'book_work',
		'posts_per_page' => 6,
		'orderby' => 'date',
		'order' => 'DESC',
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>                
	<ul style="display:grid; grid-template-columns:repeat(1, 1fr); gap:20px;">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();
			$img_url = get_field('thumb');
		?>                                     
			<li>
				<a href="<?php the_permalink(); ?>">				
					<img style="max-width:300px" src="<?= esc_url($img_url[0]['img']); ?>" alt="">				
					<?= the_title(); ?>
				</a>
			</li>				
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>




<!-- お知らせ -->
<hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">
<h2>
	お知らせ：最新６件
</h2>
<?php
	$args = array(
		'post_type' => 'news',
		'posts_per_page' => 6,
		'orderby' => 'date',
		'order' => 'DESC',
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>                
	<ul>                    
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>                                     
			<li>
				<a href="<?= get_permalink(); ?>">
					<?= the_time('Y.m.d'); ?>
					<?= the_title(); ?>
				</a>
			</li>				
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>


<?php get_footer(); ?>
