<?php
//カスタムメニューのエリア定義
//出力はこんな感じで。
//wp_nav_menu(array('theme_location' => 'nav'));

register_nav_menus(array('gnavi' => 'グローバル'));
register_nav_menus(array('sitemap' => 'サイトマップ'));

//ログイン画面のロゴ変更 設定内容は適宜変更
function login_logo() {
	echo '<style type="text/css">
	  body.login { background-color:#fff!important;}
		.login h1 a {
			background-image: url('.get_stylesheet_directory_uri().'/assets/build/images/logo.png)!important;
			width:100px;
			height:100px;
			background-size:100px 100px;
			display:block;
			margin-left:auto;
			margin-right:auto;
		}
		</style>';
}
add_action('login_head', 'login_logo');

/* ビジュアルエディタにオリジナルのcssを読ませる */
add_editor_style('css/editor-style.css');
function custom_editor_settings( $initArray ){
	$initArray['body_class'] = 'editor-area';
	 return $initArray;
}
add_filter( 'tiny_mce_before_init', 'custom_editor_settings' );

/* ビジュアルエディタからｈ3までを除去 */
function custom_editor_settingsp( $initArray ){
	$initArray['theme_advanced_blockformats'] = 'p,address,pre,code,h4,h5,h6';
	return $initArray;
}
add_filter( 'tiny_mce_before_init', 'custom_editor_settingsp' );




//-----------------------------------------------------
// WebPのアップロードを許可
//-----------------------------------------------------
function add_upload_mines($mines) {
	$mines['webp'] = 'image/webp';
	return $mines;
}
add_filter('mime_types', 'add_upload_mines');

//-----------------------------------------------------
// 投稿メニューを非表示
//-----------------------------------------------------
function remove_menus () {
	remove_menu_page( 'edit.php' );
}
add_action('admin_menu', 'remove_menus');


//-----------------------------------------------------
// エディタを非表示
//-----------------------------------------------------
add_action( 'init', function() {
    remove_post_type_support( 'episode', 'editor' );
    remove_post_type_support( 'series_work', 'editor' );    
    remove_post_type_support( 'book_volume', 'editor' );    
    remove_post_type_support( 'book_work', 'editor' );        
}, 99);


//-----------------------------------------------------
// オプションメニュー
//-----------------------------------------------------
// オプションページの定義
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( [
      'page_title' => 'トップページ設定',
      'menu_title' => 'トップページ設定',
      'menu_slug' => 'top_settings',
      'capability' => 'edit_posts', //権限
      'parent_slug' => '',
      'position' => 3,
      'icon_url' => false,
      'redirect' => false,
      'post_id' => 'top_settings'
    ] );
}
