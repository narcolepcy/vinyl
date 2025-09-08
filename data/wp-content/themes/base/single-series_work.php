<?php get_header(); ?>
<?php the_title(); 

$post_ID = get_the_ID();
?>
<h2>サムネイル</h2>
<?php if( have_rows('thumb') ) :  ?>
	<?php while ( have_rows('thumb') ) : ?>
		<?php the_row();?>
		<img style="max-width: 300px;" src="<?= get_sub_field('img');?>" alt="">		
	<?php endwhile;?>
<?php endif; ?>
<hr style="margin-top:30px;">
<h2>日付</h2>
<?= get_field('date'); ?>

<hr style="margin-top:30px;">
<h2>著者</h2>
<?= get_terms('author')[0]->name; ?>

<hr style="margin-top:30px;">
<h2>作品概要</h2>
<?= get_field('content'); ?>

<hr style="margin-top:30px;">
<h2>試し読みリンク</h2>
<?= get_field('read_url'); ?>

<hr style="margin-top:30px;">
<?php $related_post_id = get_field('related_episodes')[0]->ID; ?>
<a href="<?= get_permalink($related_post_id); ?>">単話配信ページはこちら</a>

<hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">

<h2>単話配信一覧</h2>
<?php
	$args = array(
		'post_type' => 'episode',
		'posts_per_page' => -1,
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>                
	<ul style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px;"> 
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();
			$relation = get_field('relation');
			$relation_ID = $relation[0]->ID;
			if ($relation && $relation_ID == $post_ID) :
		?>                                     
			<li>
				<p>
					サムネイル画像
				</p>
				<img style="max-width: 300px;" style="max-width: 300px;" src="<?= get_field('thumb'); ?>" alt="">
				<p>
					タイトル：<?= the_title(); ?>
				</p>
				<p>
					日付：
					<?= get_field('date'); ?>
				</p>
				<p>
					無料試し読みリンク：<?= get_field('free_link'); ?>
				</p>
				<p>
					購入はこちらリンク
				</p>				
				<p>
					・シーモア：<?= get_field('url1'); ?><br>
					・amazon：<?= get_field('url2'); ?><br>
					・Renta!：<?= get_field('url3'); ?><br>
				</p>
			</li>				
		<?php endif;
			endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>



<?php 
	$info_group = get_field('info');	
	if(empty($relation)): //relationあったらここから非表示 
?>
<hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">

<p>キャラ</p>
<?php
if (!empty($info_group['chara'])) :
?>	
	<?php foreach ($info_group['chara'] as $chara) : ?>
		<img style="max-width: 300px;" src="<?= esc_url($chara['img']); ?>" alt="">
		<p><?= esc_html($chara['name']); ?></p>
		<p><?= esc_html($chara['text']); ?></p>
	<?php endforeach; ?>

<?php endif; ?>

<hr style="margin-top:30px;">
<h2>あらすじ</h2>
<?= $info_group['arasuji'] ?>

<hr style="margin-top:30px;">
<h2>特典</h2>
<?php
if (!empty($info_group['tokuten'])) :
?>	
	<?php foreach ($info_group['tokuten'] as $tokuten) : ?>		
		<p><?= esc_html($tokuten['name']); ?></p>
		
		<?php foreach ($tokuten['list'] as $item) : ?>		
			<img style="max-width: 300px;" src="<?= esc_url($item['img']); ?>" alt="">			
			<?= $item['text']; ?>
			<p><?= $item['url']; ?></p>
			
		<?php endforeach; ?>
	<?php endforeach; ?>

<?php endif; ?>

<hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">
<h2>イベント</h2>
<?php
if (!empty($info_group['event'])) :
	$event = $info_group['event'];
?>	
	<img style="max-width: 300px;" src="<?= esc_url($event['img']); ?>" alt="">
	<p><?= esc_html($event['url']); ?></p>
	<p><?= esc_html($event['title']); ?></p>
	<p><?= esc_html($event['text']); ?></p>
<?php endif; ?>

<hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">

<h2>グッズ</h2>
<?php
if (!empty($info_group['goods'])) :
	$goods = $info_group['goods'];
?>	
	<img style="max-width: 300px;" src="<?= esc_url($goods['img']); ?>" alt="">
	<p><?= esc_html($goods['url']); ?></p>
	<?php foreach ($goods['list'] as $item) : ?>				
		<p>
			<?= $item['title']; ?>
		</p>
		<p>
			<?= $item['text']; ?>
		</p>
		<p>
			<?= $item['category']; ?>
		</p>
		<p>
			<?= $item['url']; ?>
		</p>
		
	<?php endforeach; ?>
<?php endif; ?>
<?php endif; //relationあったらここまで非表示 ?>


<hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">

<h2>作品ニュース</h2>
<?php 
	$relation_post = get_field('relation_news'); 
	if ($relation_post) :
		foreach ($relation_post as $post) : 
			setup_postdata($post); ?>
			<p>
				<a href="<?= get_permalink(); ?>">
					<?= the_title(); ?>
				</a>
			</p>
			<p>
				<?= the_time('Y.m.d'); ?>
			</p>						
		<?php endforeach;
		wp_reset_postdata();
	else : ?>
		<p>関連ニュースはありません。</p>
	<?php endif;
?>

<hr style="margin:30px 0; visibility:visible; opacity:1; border:2px solid black">

<h2>関連作品</h2>
<?php 
	$relation_post = get_field('relation'); 
	if ($relation_post) :
		foreach ($relation_post as $post) : 
			setup_postdata($post); ?>
			<p>
				<a href="<?= get_permalink(); ?>">
					<?= the_title(); ?>
				</a>
			</p>
			<p>
				<?= the_time('Y.m.d'); ?>
			</p>						
		<?php endforeach;
		wp_reset_postdata();
	else : ?>
		<p>関連作品はありません。</p>
	<?php endif;
?>

<?php get_footer(); ?>
