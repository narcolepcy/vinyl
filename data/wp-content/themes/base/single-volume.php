<?php get_header(); ?>
<?php the_title(); ?>
<h2>サムネイル</h2>
<?php if( have_rows('thumb') ) :  ?>
	<?php while ( have_rows('thumb') ) : ?>
		<?php the_row();?>
		<img src="<?= get_sub_field('img');?>" alt="">		
	<?php endwhile;?>
<?php endif; ?>
<hr style="margin-top:30px;">
<h2>日付</h2>
<?= get_field('date'); ?>

<hr style="margin-top:30px;">
<h2>著者</h2>
<?= get_terms('author')[0]->name; ?>

<hr style="margin-top:30px;">
<h2>概要</h2>
<?= get_field('content'); ?>

<hr style="margin-top:30px;">
<h2>概要</h2>
<a href="<?= get_field('read_url'); ?>"><?= get_field('read_url'); ?></a>

<hr style="margin-top:30px;">
<h2>単話配信ページはこちら</h2>
<?php $related_post_id = get_field('related_episodes')[0]->ID; ?>
<a href="<?= get_permalink($related_post_id); ?>">単話配信ページはこちら</a>

<hr style="margin-top:30px;">
<h2>単行本リスト</h2>
<?php if( have_rows('book') ) :  ?>
	<?php while ( have_rows('book') ) : ?>
		<?php the_row();?>
		<p>
			サムネイル画像
		</p>
		<img src="<?= get_sub_field('thumb'); ?>" alt="">
		<p>
			タイトル：<?= get_sub_field('title');?>
		</p>
		<p>
			日付：
			<?= get_sub_field('date'); ?>
		</p>
		<p>
			購入はこちらリンク
		</p>
		<?php 
		 $link_group = get_sub_field('link');		 	
		?>
		<p>
			シーモア：<?= $link_group['cmoa']; ?><br>
			amazon：<?= $link_group['amazon']; ?><br>
			Renta!：<?= $link_group['renta']; ?><br>
		</p>
		
	<?php endwhile;?>
<?php endif; ?>


<hr style="margin-top:30px;">
<h2>作品情報</h2>
<?php 
	$info_group = get_field('info');
	// var_dump($info_group);
	// $info_group['chara']
?>

<p>キャラ</p>
<?php
if (!empty($info_group['chara'])) :
?>	
	<?php foreach ($info_group['chara'] as $chara) : ?>
		<img src="<?= esc_url($chara['img']); ?>" alt="">
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
			<img src="<?= esc_url($item['img']); ?>" alt="">			
			<?= $item['text']; ?>
			<p><?= $item['url']; ?></p>
			
		<?php endforeach; ?>
	<?php endforeach; ?>

<?php endif; ?>

<hr style="margin-top:30px;">
<h2>イベント</h2>
<?php
if (!empty($info_group['event'])) :
	$event = $info_group['event'];
?>	
	<img src="<?= esc_url($event['img']); ?>" alt="">
	<p><?= esc_html($event['url']); ?></p>
	<p><?= esc_html($event['title']); ?></p>
	<p><?= esc_html($event['text']); ?></p>
<?php endif; ?>

<hr style="margin-top:30px;">
<h2>グッズ</h2>
<?php
if (!empty($info_group['goods'])) :
	$goods = $info_group['goods'];
?>	
	<img src="<?= esc_url($goods['img']); ?>" alt="">
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


<hr style="margin-top:30px;">
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

<hr style="margin-top:30px;">
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
