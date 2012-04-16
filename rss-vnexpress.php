<?php
/*
Plugin Name: RSS VNExpress
Version: 0.1
Description: Hien thi Rss 1 chuyen muc cua trang VNExpress. Chuyen muc ho tro: trang-chu, xa-hoi, the-gioi. Ho tro shortcode voi 2 tham so cate la chuyen muc muon hien thi, limit la so bai viet muon hien thi Ex: <strong>[vnexpress cate="the-gioi" limit="3"]</strong> - chuyen muc hien thi la The Gioi, chi hien thi 3 bai viet dau tien
Author: Doan Tran Thai Son
Author URI: 
Plugin URI:
 */

/* Version Check */
global $wp_version;
$exit_msg = ' This Plugin  require WordPress 3.0 or newer. <a href="http://wordpress.org/download/">Please update!</a>';
if(version_compare($wp_version, "3.0", "<")) {
	exit($exit_msg);
}
	
$wp_rss_vnexpress_plugin_url = trailingslashit( WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));

require_once(ABSPATH.WPINC.'/rss.php');

$rss = array(
	'trang-chu'	=> array(
							'title'=>'Trang Chủ', 
							'url'=>'http://vnexpress.net/rss/gl/trang-chu.rss'),
	'xa-hoi' 	=> array(
							'title'=>'Xã Hội', 
							'url'=>'http://vnexpress.net/rss/gl/xa-hoi.rss'),
	'the-gioi'	=> array(
							'title'=>'Thế Giới', 
							'url'=>'http://vnexpress.net/rss/gl/the-gioi.rss')
	);

function show_rss($feed_url, $limit = 50) {
	$feedfile = fetch_rss($feed_url);
	include('rss-vnexpress-widget.php');
}
	
function Rss_VNE_Widget($args) {
	global $rss;
	extract($args);
	
	$options = get_option('rss_vnexpress');
	$cate = $options['cate'];
	$data = $rss[$cate];
	$feed_url = $data['url'];
	
	echo $before_widget;
	echo $before_title.$options['title'].$after_title;
	show_rss($feed_url, $options['limit']);
	echo $after_widget;
}

function Rss_VNE_WidgetControl() {
	global $rss;
	$options = get_option('rss_vnexpress');
	if($_POST["submit"]) {
		$options['title'] = strip_tags(stripslashes($_POST["title"]));
		$options['limit'] = strip_tags(stripslashes($_POST["limit"]));
		$options['cate'] = $_POST['cate'];
		update_option('rss_vnexpress', $options);
	}
	$title = $options['title'];
	$cate = $options['cate'];
	$limit = $options['limit'];
	include('rss-vnexpress-widget-control.php');
}

function Rss_VNE_Init() {
	register_sidebar_widget('Rss VNExpress', 'Rss_VNE_Widget');
	register_widget_control('Rss VNExpress', 'Rss_VNE_WidgetControl');
}

add_action('init', Rss_VNE_Init);

function display_shortcode($params) {
	global $rss;
	$default = array(
		'cate' => 'trang-chu',
		'limit'=> '50'
	);
	$values = shortcode_atts($default, $params);
	$feed_url = $rss[$values['cate']]['url'];
	show_rss($feed_url, $values['limit']);
}

add_shortcode('vnexpress', 'display_shortcode');

function Rss_VNE_HeadAction()
{
	global $wp_rss_vnexpress_plugin_url;
	echo '<link rel="stylesheet" href="'.$wp_rss_vnexpress_plugin_url.'rss-vne.css" type="text/css" />'; 
}

add_action('wp_head', 'Rss_VNE_HeadAction' );

?>