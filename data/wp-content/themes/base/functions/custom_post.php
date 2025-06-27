<?php


$cp = [	
	[ 
		'slug' => 'news', 
		'label' => 'ニュース', 
		'rewrite_slug' => 'news',
		'has_archive' => true
	],	
	[ 
		'slug' => 'volume', 
		'label' => '単行本', 
		'rewrite_slug' => 'lineup/volume',
		'has_archive' => false
	],	
	[ 
		'slug' => 'episode', 
		'label' => '単話配信作品', 
		'rewrite_slug' => 'lineup/episode',
		'has_archive' => false
	],	
];

foreach ($cp as $item) {
	$slug = $item['slug'];
	$name = $item['label'];
    $archive_slug = $slug; // デフォルトのアーカイブスラッグ

	$options = array(
		'labels' => array(
			'name' => __($name),
			'singular_name' => __($name),
			'add_new_item' => __($name . 'を追加'),
			'edit_item' => __($name . 'を編集'),
			'new_item' => __($name . 'を追加')
		),
		'public' => true,
		'supports' => array('title','editor','thumbnail'),
		'menu_position' => 5,
		'show_ui' => true,
		'has_archive' => $item['has_archive'],
		'hierarchical' => false,
		"show_in_rest" => true,
		'rewrite' => array('slug' => $item['rewrite_slug'], 'with_front' => false)
	);


	$label = $item['tax_label'];
	add_action('init', function () use ($slug, $label, $options) {
		register_post_type($slug, $options);
		// カテゴリー
		if($slug === 'news') {
			register_taxonomy(
				$slug . '_category',
				$slug,
				array(
					'hierarchical' => true,
					'update_count_callback' => '_update_post_term_count',
					'label' => $label,
					'public' => true,
					'show_ui' => true,
					'show_in_rest' => true,
					'rewrite' => array(
						'hierarchical' => true,
					)
				)
			);		
		}
		register_taxonomy(
			'author', // タクソノミ名
			['volume', 'episode'], // 紐づけるCPT
			[
				'label' => '著者',
				'hierarchical' => true, // タグ形式
				'show_ui' => true,
				'show_in_rest' => true,
				'public' => true,
				'rewrite' => [
					'slug' => 'author',
					'with_front' => false,
				],
			]
		);				
	});
}



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
