<?php get_header(); ?>

<?php if( have_rows('mv', 'top_settings') ) :  ?>
	<?php while ( have_rows('mv', 'top_settings') ) : ?>
		<?php the_row();
		$url = get_sub_field('url');
		?>
		<a href="<?= $url['url']; ?>" target="<?= $url['target'] == '' ? '_self' : $url['target']; ?>">
			<img src="<?= get_sub_field('img');?>" alt="">
		</a>
	<?php endwhile;?>
<?php endif; ?>


<?php get_footer(); ?>
