<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage STUDEON
 * @since STUDEON 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												. ' itemscope'
												); ?>
		itemscope itemtype="http://schema.org/<?php echo esc_attr(is_single() ? 'BlogPosting' : 'Article'); ?>">
	<?php
	// Structured data snippets
	if (studeon_is_on(studeon_get_theme_option('seo_snippets'))) {
		?>
		<div class="structured_data_snippets">
			<meta itemprop="headline" content="<?php echo esc_attr(get_the_title()); ?>">
			<meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
			<meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('Y-m-d')); ?>">
			<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php echo esc_url(get_the_permalink()); ?>" content="<?php echo esc_attr(get_the_title()); ?>"/>	
			<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
					<?php 
					$studeon_logo_image = studeon_get_retina_multiplier(2) > 1 
										? studeon_get_theme_option( 'logo_retina' )
										: studeon_get_theme_option( 'logo' );
					if (!empty($studeon_logo_image)) {
						$studeon_attr = studeon_getimagesize($studeon_logo_image);
						?>
						<img itemprop="url" src="<?php echo esc_url($studeon_logo_image); ?>">
						<meta itemprop="width" content="<?php echo esc_attr($studeon_attr[0]); ?>">
						<meta itemprop="height" content="<?php echo esc_attr($studeon_attr[1]); ?>">
						<?php
					}
					?>
				</div>
				<meta itemprop="name" content="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
				<meta itemprop="telephone" content="">
				<meta itemprop="address" content="">
			</div>
		</div>
		<?php
	}
	
	// Featured image
	if ( !studeon_sc_layouts_showed('featured'))
		studeon_show_post_featured();

	// Title and post meta
	if ( (!studeon_sc_layouts_showed('title') || !studeon_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!studeon_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.(studeon_is_on(studeon_get_theme_option('seo_snippets')) ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			// Post meta
			if (!studeon_sc_layouts_showed('postmeta')) {
				studeon_show_post_meta(array(
					'seo' => studeon_is_on(studeon_get_theme_option('seo_snippets')),
					'share' => false,
					'comment' => false,
					'edit' => false,
					'date' => false,
					'categories' => false,
					'counters' => '0'
					)
				);
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	?>
	<div class="post_content entry-content" itemprop="articleBody">
		<?php
			the_content( );

			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'studeon' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'studeon' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			// Taxonomies and share
			if ( is_single() && !is_attachment() ) {
				?>
				<div class="post_meta post_meta_single"><?php
					
					// Post taxonomies
					the_tags( '<span class="post_meta_item post_tags">', '', '</span>' );

					// Share
					studeon_show_share_links(array(
							'type' => 'block',
							'caption' => '',
							'before' => '<span class="post_meta_item post_share">',
							'after' => '</span>'
						));
					?>
				</div>
				<?php
			}
		?>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
			get_template_part( 'templates/author-bio' );
		}
	?>
</article>
