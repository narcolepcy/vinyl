<?php

// ===== CPT定義（5種）=====
$cp = [
  [
    'slug'         => 'news',
    'label'        => 'ニュース',
    'rewrite_slug' => 'news',
    'has_archive'  => 'news',
    'tax_label'    => 'ニュースカテゴリ',
  ],
  // 単行本の「作品」：公開ページ（=単行本詳細）はここ
  [
    'slug'         => 'book_work',
    'label'        => '単行本作品',
    'rewrite_slug' => 'lineup/book',
    'has_archive'  => false,
  ],
  // 単行本の「各巻」：基本は管理専用（非公開）
  [
    'slug'         => 'book_volume',
    'label'        => '単行本の巻',
    'rewrite_slug' => 'lineup/volume',
    'has_archive'  => false,
  ],
  // 単話配信の「シリーズ」：公開ページ（=単話配信詳細）はここ
  [
    'slug'         => 'series_work',
    'label'        => '単話配信作品',
    'rewrite_slug' => 'lineup/series',
    'has_archive'  => false,
  ],
  // 単話配信の「各話」：基本は管理専用（非公開）
  [
    'slug'         => 'episode',
    'label'        => '単話',
    'rewrite_slug' => 'lineup/episode',
    'has_archive'  => false,
  ],
];

add_action('init', function () use ($cp) {
  foreach ($cp as $item) {
    $slug = $item['slug'];
    $name = $item['label'];

    $args = [
      'labels' => [
        'name'          => __($name),
        'singular_name' => __($name),
        'add_new_item'  => __($name . 'を追加'),
        'edit_item'     => __($name . 'を編集'),
        'new_item'      => __($name . 'を追加'),
      ],
      'public'             => in_array($slug, ['book_work','series_work','news'], true), // 詳細ページを持つのはこの3つ
      'publicly_queryable' => in_array($slug, ['book_work','series_work','news'], true),
      'show_ui'            => true,           // 管理画面は全て表示
      'show_in_rest'       => true,
      'has_archive'        => $item['has_archive'],
      'rewrite'            => ['slug' => $item['rewrite_slug'], 'with_front' => false],
      'hierarchical'       => false,
      'menu_position'      => 4,
      'supports'           => ['title','editor','thumbnail','excerpt'],
    ];
	$icon_map = array(
		'news'        => 'dashicons-megaphone',
		'book_work'   => 'dashicons-book',
		'book_volume' => 'dashicons-index-card',
		'series_work' => 'dashicons-playlist-audio',
	);
	$menu_icon = isset($icon_map[$slug]) ? $icon_map[$slug] : 'dashicons-media-default';

	$args['menu_icon'] = $menu_icon;

    // 各話/各巻は基本 非公開（管理専用）
    if (in_array($slug, ['book_volume','episode'], true)) {
      $args['public']             = false;
      $args['publicly_queryable'] = false;
    }

    register_post_type($slug, $args);
  }

  // --- ニュースカテゴリ（news_category）：newsのみ ---
  register_taxonomy('news_category', ['news'], [
    'label'             => $cp[0]['tax_label'] ?? 'ニュースカテゴリ',
    'public'            => true,
    'show_ui'           => true,
    'show_in_rest'      => true,
    'hierarchical'      => true,
    'show_admin_column' => true,
    // 'rewrite'           => ['slug' => 'news/category', 'with_front' => false, 'hierarchical' => true],
  ]);

  // --- 著者（author）：作品系に付与（必要なら巻/話にも付与OK）---
  register_taxonomy('author', ['book_work','series_work','book_volume','episode'], [
    'label'             => '著者',
    'public'            => true,
    'show_ui'           => true,
    'show_in_rest'      => true,
    'hierarchical'      => false, // タグ形式
    'show_admin_column' => true,
    'rewrite'           => ['slug' => 'author', 'with_front' => false],
  ]);
}, 9);



//カスタム投稿と紐付いたカスタムタクソノミーを取得する処理を用意する。
class RelatedTAX{

	public function __construct($excludes_category = []){
		$this->relation = [];
		$this->pt = get_post_type();

		$taxonomy = get_object_taxonomies($this->pt, 'objects');
		foreach($taxonomy as $tax){
			if(isset($excludes_category[$this->pt]) && in_array($tax->name, $excludes_category[$this->pt])) continue;
			$this->relation[$tax->name] = $tax;
		}

		add_filter('manage_edit-'.$this->pt.'_columns', [$this, 'addColumn'], 1);
		add_action('manage_'.$this->pt.'_posts_custom_column', [$this, 'add_custom_tax_columns'], 10, 2);
		add_action('restrict_manage_posts', [$this, 'restrict_manage_posts']);
	}

	public function addColumn($columns){
		$tax = $this->relation;
		foreach($tax as $t){
			$columns[$t->name] = $t->labels->singular_name;
		}
		return $columns;
	}

	public function add_custom_tax_columns($columns, $postid){
		$tax = $this->relation;
		if(isset($tax[$columns])){
			$name = $tax[$columns]->name;
			$terms = get_the_terms($postid, $name);
			if(is_array($terms) && 0 < count($terms)){
				$term_names = array_map(function($t){
				return $t->name;
				}, $terms);
				echo implode(',', $term_names);
			}
		}
	}

	public function restrict_manage_posts(){
		$taxonomies = $this->relation;
		if ($this->pt != "page" && $this->pt != "post" && $taxonomies) {
			foreach ($taxonomies as $taxonomy) {
				$terms = get_terms($taxonomy->name, array(
					'hide_empty' => 0
				));
				echo "<select name='{$taxonomy->name}' id='{$taxonomy->name}' class='postform'>";
				echo "<option value=''>カテゴリー別</option>";
				foreach ($terms as $term) {
					if ($term->count > 0) {
						echo '<option value=' . $term->slug, $_GET[$taxonomy->name] == $term->slug ? ' selected="selected"' : '', '>' . $term->name . ' (' . $term->count . ')</option>';
					}
				}
				echo "</select>";
			}
		}
	}
}

add_action( 'admin_head', function(){
	$excludes_category = [
	 'post' => ['category', 'post_tag', 'post_format']
	];
	new RelatedTAX($excludes_category);
} );



add_filter('template_include', function($t){
  if (is_tax('news_category')) {
    $alt = locate_template('archive-news.php');
    if ($alt) return $alt;
  }
  return $t;
});
