<?php get_header(); ?>

<?php
$tax = 'news_category';
$current_term_id = is_tax($tax) ? (int) get_queried_object_id() : 0;

// WP_Query（ターム指定があれば tax_query を付与）
$args = array(
  'post_type'      => 'news',
  'posts_per_page' => 10,
  'orderby'        => 'date',
  'order'          => 'DESC',
);

if ($current_term_id) {
  $args['tax_query'] = array(array(
    'taxonomy' => $tax,
    'field'    => 'term_id',
    'terms'    => $current_term_id,
  ));
}

$the_query = new WP_Query($args);
if ($the_query->have_posts()) :
?>

<h1>ニュースカテゴリ一覧</h1>
<?php
$terms = get_terms(array(
  'taxonomy'   => $tax,
  'hide_empty' => true,
  'orderby'    => 'name',
  'order'      => 'ASC',
));
?>
<nav class="news-filter" style="margin-bottom:24px;">
  <a class="<?php echo $current_term_id ? '' : 'is-active'; ?>"
     href="<?php echo esc_url( get_post_type_archive_link('news') ); ?>">すべて</a>
  <?php if (!is_wp_error($terms) && $terms): foreach ($terms as $term): ?>
    <a class="<?php echo ($current_term_id === (int)$term->term_id) ? 'is-active' : ''; ?>"
       href="<?php echo esc_url( get_term_link($term) ); ?>">
       <?php echo esc_html($term->name); ?>
    </a>
  <?php endforeach; endif; ?>
</nav>

<h1 style="margin-top:24px;">
  <?php echo $current_term_id ? esc_html(get_term($current_term_id)->name).' のニュース' : 'ニュース一覧'; ?>
</h1>

<ul>
  <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
    <li>
      <a href="<?php the_permalink(); ?>">
        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
          <?php echo esc_html(get_the_date('Y.m.d')); ?>
        </time>
        <span class="title"><?php the_title(); ?></span>
      </a>
    </li>
  <?php endwhile; wp_reset_postdata(); ?>
</ul>

<?php endif; ?>
<?php get_footer(); ?>
