<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage STUDEON
 * @since STUDEON 1.0
 */

$studeon_blog_style = explode('_', studeon_get_theme_option('blog_style'));
$studeon_columns = empty($studeon_blog_style[1]) ? 2 : max(2, $studeon_blog_style[1]);
$studeon_post_format = get_post_format();
$studeon_post_format = empty($studeon_post_format) ? 'standard' : str_replace('post-format-', '', $studeon_post_format);
$studeon_animation = studeon_get_theme_option('blog_animation');
$studeon_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($studeon_columns).' post_format_'.esc_attr($studeon_post_format) ); ?>
	<?php echo (!studeon_is_off($studeon_animation) ? ' data-animation="'.esc_attr(studeon_get_animation_classes($studeon_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($studeon_image[1]) && !empty($studeon_image[2])) echo intval($studeon_image[1]) .'x' . intval($studeon_image[2]); ?>"
	data-src="<?php if (!empty($studeon_image[0])) echo esc_url($studeon_image[0]); ?>"
	>

	<?php
	$studeon_image_hover = 'icon';
	if (in_array($studeon_image_hover, array('icons', 'zoom'))) $studeon_image_hover = 'dots';
	// Featured image
	studeon_show_post_featured(array(
		'hover' => $studeon_image_hover,
		'thumb_size' => studeon_get_thumb_size( strpos(studeon_get_theme_option('body_style'), 'full')!==false || $studeon_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. studeon_show_post_meta(array(
									'categories' => true,
									'date' => true,
									'edit' => false,
									'seo' => false,
									'share' => true,
									'counters' => 'comments',
									'echo' => false
									))
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'studeon') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>