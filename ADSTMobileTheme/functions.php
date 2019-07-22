<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

// -----------------------------------------------------------------------------

require TEMPLATEPATH.'/drone/drone.php';

// -----------------------------------------------------------------------------

class Website extends DroneTheme
{

	// -------------------------------------------------------------------------

	private $sidebars_def;

	// -------------------------------------------------------------------------

	public function optionIndent($option, &$html)
	{
		$html->style('padding-left: 18px;');
	}

	// -------------------------------------------------------------------------

	public function optionTemplateURIPrefix($option, &$html)
	{
		$html = DroneHTML::make()->add(
			DroneHTML::make('code')->add($this->template_uri.'/'),
			$html
		);
	}

	// -------------------------------------------------------------------------

	public function optionAreasImage($option, &$html)
	{
		$html = DroneHTML::make('div')
			->style('position: relative; float: left;')
			->add(
				$html,
				DroneHTML::make('img')
					->src($this->template_uri.'/data/img/areas.png')
					->style('padding-left: 30px; position: absolute; left: 100%; top: -3px;')
			);
	}

	// -------------------------------------------------------------------------

	public function optionSmallMemo($option, &$html)
	{
		$html->style('height: 80px;');
	}

	// -------------------------------------------------------------------------

	public function optionSmallestMemo($option, &$html)
	{
		$html->style('width: 300px; height: 80px;');
	}

	// -------------------------------------------------------------------------

	public function optionWideSelect($option, &$html)
	{
		$html->style('width: 200px;');
	}

	// -------------------------------------------------------------------------

	public function optionPathSlashTrim($option, $original_value, &$value)
	{
		$value = trim($value, '\\/');
	}

	// -------------------------------------------------------------------------

	public function flickrOnPhoto($widget, $photo, &$html)
	{
		$a   = $html->child(0);
		$img = $a->child(0);
		$a->delete($img)->add(
			self::getResponsiveImage($img->src)->alt($img->alt)->width(41)->height(41)
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * Options setup
	 *
	 * @since 1.0
	 *
	 * @param object $theme_options
	 */
	protected function onSetupOptions($theme_options)
	{

		// Options
		$sidebars_options = array(
			'' => __('None', 'website')
		)+$this->sidebars_def;
		$sidebars_post_options = array(
			'inherit' => __('Inherit', 'website'),
			''        => __('None', 'website')
		)+$this->sidebars_def;

		// Appearance
		$appearance = $theme_options->addGroup('appearance', __('Appearance', 'website'));
			$appearance->addOption('group', 'scheme', 'bright', __('Color scheme', 'website'), '', array('options' => array(
				'bright' => __('Bright', 'website'),
				'dark'   => __('Dark', 'website')
			)));
			$appearance->addOption('color', 'color', '#089bc3', __('Leading color', 'website'));
			$background = $appearance->addGroup('background', __('Background', 'website'));
				$background->addOption('boolean', 'enabled', false, '', '', array('caption' => __('Use custom background', 'website')));
				$background->addOption('background', 'settings', array());
			$appearance->addOption('group', 'sidebar', 'right', __('Sidebar position', 'website'), '', array('options' => array(
				'left'  => __('Left', 'website'),
				'right' => __('Right', 'website')
			)));
			$font = $appearance->addGroup('font', __('Custom font', 'website'), sprintf(__('Select one of recommended Google web fonts or visit <a href="%s">Google web fonts catalog</a>, where you can watch previews and use other one. Paste just the name of the font (e.g. %s).', 'website'), 'http://www.google.com/webfonts', '<code>Mrs Saint Delafield</code>'));
				$font->addOption('boolean', 'enabled', true, '', '', array('caption' => __('Use custom font', 'website')));
				$font->addOption('list', 'name', 'Roboto', __('Recommended Google web font', 'website'), '', array('options' => array(
					//'Caudex'           => 'Caudex',
					//'Crete Round'      => 'Crete Round',
					//'Glegoo'           => 'Glegoo',
					//'Gudea'            => 'Gudea',
					//'Lilita One'       => 'Lilita One',
					//'Play'             => 'Play',
					//'PT Serif Caption' => 'PT Serif Caption',
					//'Rokkitt'          => 'Rokkitt',
					//'Ropa Sans'        => 'Ropa Sans',
					//'Ubuntu Condensed' => 'Ubuntu Condensed',
					'Roboto Condensed'   => 'Roboto Condensed',
					'Roboto'             => 'Roboto'
				)));
				$font->addOption('codeline', 'custom_name', '', __('Or other Google web font', 'website'));
				$font->addOption('group', 'subset', array('latin'), __('Subset', 'website'), '', array('multiple' => true, 'options' => array(
					'latin'        => __('Latin', 'website'),
					'latin-ext'    => __('Latin extended', 'website'),
					'cyrillic'     => __('Cyrillic', 'website'),
					'cyrillic-ext' => __('Cyrillic extended', 'website'),
					'greek'        => __('Greek', 'website'),
					'greek-ext'    => __('Greek extended', 'website'),
					'khmer'        => __('Khmer', 'website'),
					'vietnamese'   => __('Vietnamese', 'website')
				)));
			$image = $appearance->addGroup('image', __('Images', 'website'));
				$image->addOption('list', 'border', 'thin', __('Border style', 'website'), '', array('options' => array(
					''      => __('None', 'website'),
					'thin'  => __('Thin', 'website'),
					'thick' => __('Thick', 'website')
				)));
				$image->addOption('boolean', 'fancybox', true, '', '', array('caption' => __('Open in Fancybox', 'website')));

		// Header
		$header = $theme_options->addGroup('header', __('Header', 'website'));
			$header->addOption('number', 'height', 60, __('Height', 'website'), '', array('min' => 60, 'max' => 300, 'unit' => 'px'));
			$logo = $header->addGroup('logo', __('Logo', 'website'));
				$logo->addOption('text', 'text', get_bloginfo('name'), __('Text', 'website'), __("It will be used if you don't select any logo image below.", 'website'));
				$logo->addOption('image', 'image', '', __('Image', 'website'), __("If you don't select any logo image, text logo above will be used.", 'website'));
				$logo->addOption('boolean', 'center', false, '', __('This option will hide tagline and banner.', 'website'), array('caption' => __('Align logo to the center', 'website')));
			$header->addOption('text', 'tagline', get_bloginfo('description'), __('Tagline', 'website'), sprintf(__('To place nonbreaking space between words, use the %s sign (without spaces).', 'website'), '<code>_</code>'));
			$ad = $header->addGroup('ad', __('Ad banner', 'website'));
				$ad->addOption('boolean', 'enabled', false, '', '', array('caption' => __('Display ad banner', 'website')));
				$ad->addOption('image', 'image', '', __('Image', 'website'));
				$ad->addOption('codeline', 'url', '', __('Target URL', 'website'));
				$ad->addOption('code', 'code', '', __('Code', 'website'), __('If you paste any code, it will be used instead image and target URL from the fields above.', 'website'));
				$ad->addOption('boolean', 'hide_mobile', false, '', __('Notice: hiding ad using this method may be against some ad-networks rules, so I recommend using this option only for self-controlled ad campaigns.', 'website'), array('caption' => __('Hide on mobile version', 'website')));

		// Footer
		$footer = $theme_options->addGroup('footer', __('Footer', 'website'));
			$footer->addOption('boolean', 'fixed', false, __('Position', 'website'), '', array('caption' => __('Stick to bottom', 'website')));
			$footer->addOption('group', 'layout', 'sssx', __('Sidebar layout', 'website'), __('Fixed means, it has the same size as the main sidebar.', 'website'), array('options' => array(
				'sssx' => __('4 widgets (<code>small</code> + <code>small</code> + <code>small</code> + <code>fixed</code>)', 'website'),
				'smx'  => __('3 widgets (<code>small</code> + <code>medium</code> + <code>fixed</code>)', 'website'),
				'msx'  => __('3 widgets (<code>medium</code> + <code>small</code> + <code>fixed</code>)', 'website'),
				'lx'   => __('2 widgets (<code>large</code> + <code>fixed</code>)', 'website'),
				'f'    => __('1 widget (<code>full</code>)', 'website')
			)));
			$text = $footer->addGroup('text', __('End note', 'website'));
				$text->addOption('memo', 'left', sprintf(__('&copy; Copyright %s', 'website'), date('Y'))."\n".sprintf(__('%1$s by <a href="%3$s">%2$s</a>', 'website'), get_bloginfo('name'), get_userdata(1)->display_name, esc_url(home_url('/'))), __('Left', 'website'), '', array('on_html' => array($this, 'optionSmallMemo')));
				$text->addOption('memo', 'right', sprintf(__('powered by %s theme', 'website'), '<a href="http://themeforest.net/user/kubasto">Website</a>'), __('Right', 'website'), '', array('on_html' => array($this, 'optionSmallMemo')));

		// Navigation
		$nav = $theme_options->addGroup('nav', __('Navigation', 'website'));
			$top = $nav->addGroup('top', __('Top menu', 'website'));
				$top->addOption('group', 'visible', array('desktop', 'mobile'), __('Visible', 'website'), '', array('multiple' => true, 'options' => array(
					'desktop' => __('On desktop &amp; tablet devices', 'website'),
					'mobile'  => __('On mobile devices', 'website')
				)));
				$top->addOption('group', 'content', 'categories', __('Content', 'website'), __('Matters only if you do not select another in <code>Appearance/Menus</code>.', 'website'), array('options' => array(
					'pages'      => __('Pages', 'website'),
					'categories' => __('Categories', 'website')
				)));
				$top->addOption('boolean', 'fixed', false, '', '', array('caption' => __('Stick to top', 'website')));
			$main = $nav->addGroup('main', __('Main menu', 'website'));
				$main->addOption('group', 'visible', array('desktop', 'mobile'), __('Visible', 'website'), '', array('multiple' => true, 'options' => array(
					'desktop' => __('On desktop &amp; tablet devices', 'website'),
					'mobile'  => __('On mobile devices', 'website')
				)));
				$main->addOption('group', 'content', 'pages', __('Content', 'website'), __('Matters only if you do not select another in <code>Appearance/Menus</code>.', 'website'), array('options' => array(
					'pages'      => __('Pages', 'website'),
					'categories' => __('Categories', 'website')
				)));
			if (function_exists('bcn_display') || function_exists('yoast_breadcrumb') || function_exists('breadcrumb_trail')) {
				$breadcrumbs = $nav->addOption('group', 'breadcrumbs', array('home,archive', 'search', 'singular[post]', 'page', 'singular[portfolio]', 'singular[portfolio-item]', 'singular[gallery]', '404'), __('Breadcrumbs', 'website'), '', array('multiple' => true, 'options' => array(
					'front_page'               => __('Front page', 'website'),
					'home,archive'             => __('Blog page', 'website'),
					'search'                   => __('Search results page', 'website'),
					'singular[post]'           => __('Posts', 'website'),
					'page'                     => __('Pages', 'website'),
					'singular[portfolio]'      => __('Portfolios', 'website'),
					'singular[portfolio-item]' => __('Portfolio items', 'website'),
					'singular[gallery]'        => __('Galleries', 'website'),
					'404'                      => __('Not found page (404)', 'website')
				)));
			}

		// Sidebars
		$sidebar = $theme_options->addGroup('sidebar', __('Sidebars', 'website'));
			$conf = $sidebar->addGroup('conf', __('Configuration', 'website'));
				$conf->addOption('list', 'front_page', 'general', __('Sidebar on front page', 'website'), '', array('options' => $sidebars_options, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', 'home,archive', 'general', __('Sidebar on blog page', 'website'), '', array('options' => $sidebars_options, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', 'search', 'general', __('Sidebar on search results page', 'website'), '', array('options' => $sidebars_options, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', 'single', 'general', __('Sidebar on posts', 'website'), '', array('options' => $sidebars_options, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', 'page', 'general', __('Sidebar on pages', 'website'), '', array('options' => $sidebars_options, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', '404', 'general', __('Sidebar on not found page (404)', 'website'), '', array('options' => $sidebars_options, 'on_html' => array($this, 'optionWideSelect')));
				function wpb_widgets_init() {
 
    register_sidebar( array(
        'name'          => 'Custom Header Widget Area',
        'id'            => 'custom-header-widget',
        'before_widget' => '<div class="chw-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
 
}
add_action( 'widgets_init', 'wpb_widgets_init' );

		// Sliders
		$slider = $theme_options->addGroup('slider', __('Sliders', 'website'));
			$conf = $slider->addGroup('conf', __('Configuration', 'website'));
				$conf->addOption('list', 'front_page', '', __('Slider on front page', 'website'), '', array('strict' => false, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', 'home,archive', '', __('Slider on blog page', 'website'), '', array('strict' => false, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', 'search', '', __('Slider on search results page', 'website'), '', array('strict' => false, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', 'single', '', __('Slider on posts', 'website'), '', array('strict' => false, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', 'page', '', __('Slider on pages', 'website'), '', array('strict' => false, 'on_html' => array($this, 'optionWideSelect')));
				$conf->addOption('list', '404', '', __('Slider on not found page (404)', 'website'), '', array('strict' => false, 'on_html' => array($this, 'optionWideSelect')));
			$prop = $slider->addGroup('prop', __('Properties', 'website'));
				$prop->addOption('list', 'animation', 'slide', __('Animation type', 'website'), '', array('options' => array(
					'fade'  => __('Fade', 'website'),
					'slide' => __('Slide', 'website')
				)));
// 				$prop->addOption('list', 'slide_direction', 'horizontal', __('Sliding direction', 'website'), '', array('options' => array(
// 					'horizontal' => __('Horizontal', 'website'),
// 					'vertical'   => __('Vertical', 'website')
// 				)));
				$prop->addOption('number', 'animation_duration', 600, __('Animation speed', 'website'), '', array('unit' => 'ms', 'min' => 0, 'max' => 10000));
				$prop->addOption('number', 'slideshow_speed', 7000, __('Exposure time', 'website'), '', array('unit' => 'ms', 'min' => 1000, 'max' => 60000));
				$prop->addOption('boolean', 'slideshow', false, '', '', array('caption' => __('Animate slider automatically', 'website')));
			$height = $slider->addGroup('height', __('Height', 'website'));
				$height->addOption('number', 'full', 285, __('Full width slider', 'website'), '', array('unit' => 'px', 'min' => 100, 'max' => 1000));
				$height->addOption('number', 'one_text', 285, __('Slider + text', 'website'), '', array('unit' => 'px', 'min' => 100, 'max' => 1000));

		// Front page
		$front_page = $theme_options->addGroup('front_page', __('Front page', 'website'));
			$area = $front_page->addGroup('area', __('Areas', 'website'));
				foreach (array('a', 'b') as $name) {
					$area->addOption('list', $name, '', sprintf(__('Area %s', 'website'), strtoupper($name)), '', array('options' => array(
						''        => __('None', 'website'),
						'box'     => __('Notice box', 'website'),
						'columns' => __('Featured columns', 'website')
					)));
				}
				foreach (array('c', 'd', 'e') as $name) {
					$area->addOption('list', $name, '', sprintf(__('Area %s', 'website'), strtoupper($name)), '', array('options' => array(
						''         => __('None', 'website'),
						'box'      => __('Notice box', 'website'),
						'featured' => __('Featured content', 'website'),
						'posts'    => __('Posts list', 'website'),
						'columns'  => __('Featured columns', 'website')
					)));
				}
				foreach (array('f', 'g') as $name) {
					$area->addOption('list', $name, '', sprintf(__('Area %s', 'website'), strtoupper($name)), '', array('options' => array(
						''        => __('None', 'website'),
						'box'     => __('Notice box', 'website'),
						'columns' => __('Featured columns', 'website')
					)));
				}
			$area->child('a')->on_html = array($this, 'optionAreasImage');
			$box = $front_page->addGroup('box', __('Notice box', 'website'), __('If you change title or content of the box, it will be displayed again for all users, even if they closed it before.', 'website'));
				$box->addOption('text', 'title', '', __('Title', 'website'));
				$box->addOption('memo', 'text', '', __('Text', 'website'));
				$box->addOption('boolean', 'close', true, '', '', array('caption' => __('Allow users to close the box', 'website')));
			$featured = $front_page->addGroup('featured', __('Featured content', 'website'), __('You can select many posts and pages using CTRL key. From the selected group a number of them (set in the <code>Quantity</code> field) will be randomly selected to be displayed in the order specified by the <code>Sort by</code> selector.', 'website'));
				$featured->addOption('list', 'posts', array(), __('Posts', 'website'), '', array('multiple' => true, 'strict' => false));
				$featured->addOption('list', 'pages', array(), __('Pages', 'website'), '', array('multiple' => true, 'strict' => false));
				$featured->addOption('number', 'count', 1, __('Quantity', 'website'), '', array('min' => 1, 'max' => 10));
				$featured->addOption('list', 'orderby', 'date', __('Sort by', 'website'), '', array('options' => array(
					'title'         => __('Title', 'website'),
					'date'          => __('Date', 'website'),
					'modified'      => __('Modified date', 'website'),
					'comment_count' => __('Comment count', 'website'),
					'rand'          => __('Random order', 'website')
				)));
				$featured->addOption('list', 'order', 'desc', __('Sort order', 'website'), '', array('options' => array(
					'asc'  => __('Ascending', 'website'),
					'desc' => __('Descending', 'website')
				)));
			$posts = $front_page->addGroup('posts', __('Posts list', 'website'));
				$posts->addOption('number', 'count', 3, __('Quantity', 'website'), '', array('min' => 1, 'max' => 20));
				$posts->addOption('list', 'orderby', 'date', __('Sort by', 'website'), '', array('options' => array(
					'title'         => __('Title', 'website'),
					'date'          => __('Date', 'website'),
					'modified'      => __('Modified date', 'website'),
					'comment_count' => __('Comment count', 'website'),
					'rand'          => __('Random order', 'website')
				)));
				$posts->addOption('list', 'order', 'desc', __('Sort order', 'website'), '', array('options' => array(
					'asc'  => __('Ascending', 'website'),
					'desc' => __('Descending', 'website')
				)));
				$filter = $posts->addGroup('filter', __('Category filter', 'website'));
					$filter->addOption('boolean', 'enabled', false, '', '', array('caption' => __('Show post only from selected categories:', 'website')));
					$filter->addOption('group', 'categories', array(), '', '', array('multiple' => true, 'strict' => false, 'on_html' => array($this, 'optionIndent')));
				$goto = $posts->addGroup('goto');
					$goto->addOption('boolean', 'visible', true, '', '', array('caption' => __('Display Go to blog link', 'website')));
					$goto->addOption('text', 'text', __('Go to blog', 'website'), __('Go to blog link text', 'website'));
			$columns = $front_page->addGroup('columns', __('Featured columns', 'website'));
				$columns->addOption('list', 'count', 3, __('Number of columns', 'website'), '', array('options' => array(
					1 => __('One', 'website'),
					2 => __('Two', 'website'),
					3 => __('Three', 'website'),
					4 => __('Four', 'website')
				)));
				$column = $columns->addGroup('column');
					for ($i = 0; $i < 4; $i++) {
						$group = $column->addGroup($i, sprintf(__('Column %d', 'website'), $i+1));
							$group->addOption('list', 'icon', '', __('Icon', 'website'), '', array('strict' => false));
							$group->addOption('text', 'title', '', __('Title', 'website'));
							$group->addOption('memo', 'text', '', __('Text', 'website'), '', array('on_html' => array($this, 'optionSmallestMemo')));
							$group->addOption('text', 'more', __('More', 'website'), __('Read more word', 'website'));
							$group->addOption('codeline', 'link', '', __('Read more link', 'website'));
					}

		// Posts
		$post = $theme_options->addGroup('post', __('Posts', 'website'));
			$readmore = $post->addOption('text', 'readmore', __('Read more', 'website'), __('Read more text', 'website'));
			$about = $post->addOption('boolean', 'about', false, __('Author details', 'website'), '', array('caption' => __('Show author details inside post', 'website')));
			$social = $post->addGroup('social', __('Social buttons', 'website'));
				foreach (array('list' => __('On posts list', 'website'), 'single' => __('Inside post', 'website')) as $name => $label) {
					$group = $social->addGroup($name, $label);
					$group->addOption('boolean', 'visible', $name == 'single', '', '', array('caption' => __('Visible', 'website')));
					$group->addOption('group', 'items', array('twitter', 'facebook', 'googleplus', 'pinterest'), '', '', array('multiple' => true, 'options' => array(
						'twitter'    => __('Twitter', 'website'),
						'facebook'   => __('Facebook', 'website'),
						'googleplus' => __('Google+', 'website'),
						'pinterest'  => __('Pinterest', 'website')
					), 'on_html' => array($this, 'optionIndent')));
				}
			$meta = $post->addGroup('meta', __('Meta elements', 'website'));
				foreach (array('list' => __('On posts list', 'website'), 'single' => __('Inside post', 'website')) as $name => $label) {
					$group = $meta->addGroup($name, $label);
					$group->addOption('boolean', 'visible', true, '', '', array('caption' => __('Visible', 'website')));
					$group->addOption('group', 'items', array('comments', 'author', 'date', 'category', 'link'), '', '', array('multiple' => true, 'options' => array(
						'comments' => __('Number of comments', 'website'),
						'author'   => __('Author', 'website'),
						'date'     => __('Date', 'website'),
						'category' => __('Category', 'website'),
						'tags'     => __('Tags', 'website'),
						'link'     => __('Permalink', 'website'),
						'edit'     => __('Edit link (visible to editors only)', 'website')
					), 'on_html' => array($this, 'optionIndent')));
				}
			$post->addOption('boolean', 'navigation', false, __('Navigation', 'website'), '', array('caption' => __('Show links to next and previous posts', 'website')));
			$post->addOption('boolean', 'comments', true, __('Comments', 'website'), '', array('caption' => __('Allow comments', 'website')));
			$post->addOption('list', 'pagination', 'numbers_navigation', __('Pagination', 'website'), '', array('options' => array(
				'numbers'            => __('Numbers', 'website'),
				'numbers_navigation' => __('Numbers + navigation', 'website')
			)));
			$post->addOption('list', 'comments_pagination', 'numbers_navigation', __('Comments pagination', 'website'), '', array('options' => array(
				'numbers'            => __('Numbers', 'website'),
				'numbers_navigation' => __('Numbers + navigation', 'website')
			)));

		// Format posts
		$format_post = $theme_options->addGroup('format_post', __('Format posts', 'website'));
			$default = $format_post->addGroup('default', __('Standard', 'website'));
				$featured = $default->addGroup('featured');
					$featured->addOption('group', 'visible', array('list'), __('Show featured image', 'website'), '', array('multiple' => true, 'options' => array(
						'list'   => __('On posts list', 'website'),
						'single' => __('Inside post', 'website')
					)));
					$featured->addOption('group', 'link', 'post', __('Featured image click action', 'website'), __('Click action refers to posts list only. Inside posts, clicked featured images always open in Fancybox window.', 'website'), array('options' => array(
						'post'     => __('Go to post', 'website'),
						'fancybox' => __('Open image in Fancybox', 'website')
					)));
				$content = $default->addGroup('content');
					$content->addOption('boolean', 'hide', false, '', '', array('caption' => __('Hide content on posts list', 'website')));
			$link = $format_post->addGroup('link', __('Link', 'website'));
				$title = $link->addGroup('title');
					$title->addOption('group', 'link', 'url', __('Post title click action', 'website'), __('This option refers to posts list only. Inside posts, clicked link always goes to specified URL.', 'website'), array('options' => array(
						'post' => __('Go to post', 'website'),
						'url'  => __('Go to URL specified in the post', 'website')
					)));
					$title->addOption('boolean', 'target_blank', false, __('Post title link behavior', 'website'), '', array('caption' => __('Open in new window', 'website')));
				$content = $link->addGroup('content');
					$content->addOption('boolean', 'hide', true, '', '', array('caption' => __('Hide content on posts list', 'website')));
			$image = $format_post->addGroup('image', __('Image', 'website'));
				$featured = $image->addGroup('featured');
					$featured->addOption('group', 'visible', array('list', 'single'), __('Show featured image', 'website'), '', array('multiple' => true, 'options' => array(
						'list'   => __('On posts list', 'website'),
						'single' => __('Inside post', 'website')
					)));
					$featured->addOption('group', 'link', 'fancybox', __('Featured image click action', 'website'), __('Click action refers to posts list only. Inside posts, clicked featured images always open in Fancybox window.', 'website'), array('options' => array(
						'post'     => __('Go to post', 'website'),
						'fancybox' => __('Open image in Fancybox', 'website')
					)));
				$content = $image->addGroup('content');
					$content->addOption('boolean', 'hide', false, '', '', array('caption' => __('Hide content on posts list', 'website')));
			$quote = $format_post->addGroup('quote', __('Quote', 'website'));
				$content = $quote->addGroup('content');
					$content->addOption('boolean', 'hide', true, '', '', array('caption' => __('Hide content on posts list', 'website')));
			$status = $format_post->addGroup('status', __('Status', 'website'));
				$content = $status->addGroup('content');
					$content->addOption('boolean', 'hide', true, '', '', array('caption' => __('Hide content on posts list', 'website')));
			$video = $format_post->addGroup('video', __('Video', 'website'));
				$player = $video->addGroup('player');
					$player->addOption('group', 'visible', array('list', 'single'), __('Show player', 'website'), '', array('multiple' => true, 'options' => array(
						'list'   => __('On posts list', 'website'),
						'single' => __('Inside post', 'website')
					)));
				$content = $video->addGroup('content');
					$content->addOption('boolean', 'hide', false, '', '', array('caption' => __('Hide content on posts list', 'website')));
			$audio = $format_post->addGroup('audio', __('Audio', 'website'));
				$player = $audio->addGroup('player');
					$player->addOption('group', 'visible', array('list', 'single'), __('Show player', 'website'), '', array('multiple' => true, 'options' => array(
						'list'   => __('On posts list', 'website'),
						'single' => __('Inside post', 'website')
					)));
				$content = $audio->addGroup('content');
					$content->addOption('boolean', 'hide', false, '', '', array('caption' => __('Hide content on posts list', 'website')));

		// Pages
		$page = $theme_options->addGroup('page', __('Pages', 'website'));
			$page->addOption('boolean', 'hide_title', false, __('Title', 'website'), '', array('caption' => __('Hide page title', 'website')));
			$about = $page->addOption('boolean', 'about', false, __('Author details', 'website'), '', array('caption' => __('Show author details', 'website')));
			$social = $page->addGroup('social', __('Social buttons', 'website'));
				$social->addOption('boolean', 'visible', true, '', '', array('caption' => __('Visible', 'website')));
				$social->addOption('group', 'items', array('twitter', 'facebook', 'googleplus', 'pinterest'), '', '', array('multiple' => true, 'options' => array(
					'twitter'    => __('Twitter', 'website'),
					'facebook'   => __('Facebook', 'website'),
					'googleplus' => __('Google+', 'website'),
					'pinterest'  => __('Pinterest', 'website')
				), 'on_html' => array($this, 'optionIndent')));
			$meta = $page->addGroup('meta', __('Meta elements', 'website'));
				$meta->addOption('boolean', 'visible', false, '', '', array('caption' => __('Visible', 'website')));
				$meta->addOption('group', 'items', array('comments', 'author', 'date', 'category', 'link'), '', '', array('multiple' => true, 'options' => array(
					'comments' => __('Number of comments', 'website'),
					'author'   => __('Author', 'website'),
					'date'     => __('Date', 'website'),
					'link'     => __('Permalink', 'website'),
					'edit'     => __('Edit link (visible to editors only)', 'website')
				), 'on_html' => array($this, 'optionIndent')));
			$page->addOption('boolean', 'comments', true, __('Comments', 'website'), '', array('caption' => __('Allow comments', 'website')));
			$page->addOption('list', 'comments_pagination', 'numbers_navigation', __('Comments pagination', 'website'), '', array('options' => array(
				'numbers'            => __('Numbers', 'website'),
				'numbers_navigation' => __('Numbers + navigation', 'website')
			)));

		// Portfolios
		$portfolio_item = $theme_options->addGroup('portfolio-item', __('Portfolios', 'website'));
			$about = $portfolio_item->addOption('boolean', 'about', false, __('Author details', 'website'), '', array('caption' => __('Show author details', 'website')));
			$social = $portfolio_item->addGroup('social', __('Social buttons', 'website'));
				$social->addOption('boolean', 'visible', true, '', '', array('caption' => __('Visible', 'website')));
				$social->addOption('group', 'items', array('twitter', 'facebook', 'googleplus', 'pinterest'), '', '', array('multiple' => true, 'options' => array(
					'twitter'    => __('Twitter', 'website'),
					'facebook'   => __('Facebook', 'website'),
					'googleplus' => __('Google+', 'website'),
					'pinterest'  => __('Pinterest', 'website')
				), 'on_html' => array($this, 'optionIndent')));
			$meta = $portfolio_item->addGroup('meta', __('Meta elements', 'website'));
				$meta->addOption('boolean', 'visible', false, '', '', array('caption' => __('Visible', 'website')));
				$meta->addOption('group', 'items', array('comments', 'author', 'date', 'category', 'link'), '', '', array('multiple' => true, 'options' => array(
					'comments' => __('Number of comments', 'website'),
					'author'   => __('Author', 'website'),
					'date'     => __('Date', 'website'),
					'link'     => __('Permalink', 'website'),
					'edit'     => __('Edit link (visible to editors only)', 'website')
				), 'on_html' => array($this, 'optionIndent')));
			$portfolio_item->addOption('boolean', 'comments', true, __('Comments', 'website'), '', array('caption' => __('Allow comments', 'website')));
			$portfolio_item->addOption('list', 'pagination', 'numbers_navigation', __('Pagination', 'website'), '', array('options' => array(
				'numbers'            => __('Numbers', 'website'),
				'numbers_navigation' => __('Numbers + navigation', 'website')
			)));
			$portfolio_item->addOption('list', 'comments_pagination', 'numbers_navigation', __('Comments pagination', 'website'), '', array('options' => array(
				'numbers'            => __('Numbers', 'website'),
				'numbers_navigation' => __('Numbers + navigation', 'website')
			)));

		// Galleries
		$gallery = $theme_options->addGroup('gallery', __('Galleries', 'website'));
			$gallery->addOption('list', 'pagination', 'numbers_navigation', __('Pagination', 'website'), '', array('options' => array(
				'numbers'            => __('Numbers', 'website'),
				'numbers_navigation' => __('Numbers + navigation', 'website')
			)));

		// Contact form
		$contact_form = $theme_options->addGroup('contact_form', __('Contact form', 'website'));
			$this->addThemeFeature('option-contact-form');

		// Advanced
		$advanced = $theme_options->addGroup('advanced', __('Advanced', 'website'));
			$this->addThemeFeature('option-custom-css');
			$this->addThemeFeature('option-custom-js');
			$timthumb = $advanced->addGroup('timthumb', __('TimThumb', 'website'));
				$timthumb->addOption('boolean', 'enabled', function_exists('imagecreatetruecolor'), '', '', array('caption' => __('Enabled', 'website')));
				$quality = $timthumb->addGroup('quality', __('Images quality', 'website'), __('Higher value = better image quality.', 'website'));
					$quality->addOption('number', 'desktop', 90, __('Desktop & tablet devices', 'website'), '', array('unit' => '%', 'min' => 1, 'max' => 100));
					$quality->addOption('number', 'mobile', 75, __('Mobile devices', 'website'), '', array('unit' => '%', 'min' => 1, 'max' => 100));
			$jwplayer = $advanced->addGroup('jwplayer', __('JW Player', 'website'), __("If you use self-hosted videos, read about configuring it in theme's documentation, Installation chapter.", 'website'));
				$jwplayer->addOption('codeline', 'path', 'data/jwplayer', __('Player folder path', 'website'), '', array('on_sanitize' => array($this, 'optionPathSlashTrim'), 'on_html' => array($this, 'optionTemplateURIPrefix')));
				$jwplayer_skin = $jwplayer->addGroup('skin');
					$jwplayer_skin->addOption('codeline', 'file', 'data/jwplayer/whotube/whotube.xml', __('Skin file path', 'website'), '', array('on_sanitize' => array($this, 'optionPathSlashTrim'), 'on_html' => array($this, 'optionTemplateURIPrefix')));
					$jwplayer_skin->addOption('number', 'height', 25, __('Skin control bar height', 'website'), '', array('min' => 0, 'max' => 999, 'unit' => 'px'));

		// Other
		$other = $theme_options->addGroup('other', __('Other', 'website'));

		// ---------------------------------------------------------------------

		// Post options
		$post_options = $this->getPostOptions('post');

		// Options
		$options = $post_options->addGroup('options', __('Options', 'website'), __('Inherit means, it will take the option from Theme Options.', 'website'), 'side', 'low');
			$options->addOption('list', 'slider', 'inherit', __('Slider inside post', 'website'), '', array('strict' => false));
			$options->addOption('list', 'sidebar', 'inherit', __('Sidebar inside post', 'website'), '', array('options' => $sidebars_post_options));
			foreach (array(
				'about'         => __('Author inside post', 'website'),
				'social_list'   => __('Social on posts list', 'website'),
				'social_single' => __('Social inside post', 'website'),
				'meta_list'     => __('Meta on posts list', 'website'),
				'meta_single'   => __('Meta inside post', 'website')
			) as $name => $label) {
				$options->addOption('list', $name, 'inherit', $label, '', array('options' => array(
					'inherit' => __('Inherit', 'website'),
					'on'      => __('Visible', 'website'),
					'off'     => __('Hidden', 'website')
				)));
			}

		// Link
		$link = $post_options->addGroup('link', __('Link', 'website'), __('These fields impact only Link post format.', 'website'));
			$link->addOption('codeline', 'url', '', __('URL', 'website'));

		// Audio
		$audio = $post_options->addGroup('audio', __('Audio', 'website'), __('These fields impact only Audio post format.', 'website'));
			$audio->addOption('codeline', 'url', '', __('File URL', 'website'), sprintf(__('Supported formats: %s.', 'website'), '<code>mp3</code>, <code>wav</code>'));

		// Video
		$video = $post_options->addGroup('video', __('Video', 'website'), __('These fields impact only Video post format.', 'website'));
			$video->addOption('group', 'method', 'embed', __('Method', 'website'), '', array('options' => array(
				'self'  => __('Self-hosted', 'website'),
				'embed' => __('Embedding code', 'website')
			)));
			$video->addOption('codeline', 'url', '', __('File URL', 'website'), sprintf(__('Supported formats: %s.', 'website'), '<code>mp4</code>, <code>flv</code>'));
			$video->addOption('number', 'ratio', 1.7778, __('Size ratio', 'website'), __('Divide width by height to specify correct number.', 'website'), array('float' => true, 'min' => 0.1, 'max' => 10));
			$video->addOption('code', 'code', '', __('External video code', 'website'), __('It will be used instead the URL above.', 'website'));

		// ---------------------------------------------------------------------

		// Page options
		$page_options = $this->getPostOptions('page');

		// Options
		$options = $page_options->addGroup('options', __('Options', 'website'), __('Inherit means, it will take the option from Theme Options.', 'website'), 'side', 'low');
			$options->addOption('list', 'slider', 'inherit', __('Slider', 'website'), '', array('strict' => false));
			$options->addOption('list', 'sidebar', 'inherit', __('Sidebar', 'website'), '', array('options' => $sidebars_post_options));
			$options->addOption('list', 'title', 'inherit', __('Hide title', 'website'), '', array('options' => array(
				'inherit' => __('Inherit', 'website'),
				'hide'    => __('Yes', 'website'),
				'show'    => __('No', 'website')
			)));
			foreach (array(
				'about'    => __('Author details', 'website'),
				'social'   => __('Social buttons', 'website'),
				'meta'     => __('Meta elements', 'website')
			) as $name => $label) {
				$options->addOption('list', $name, 'inherit', $label, '', array('options' => array(
					'inherit' => __('Inherit', 'website'),
					'on'      => __('Visible', 'website'),
					'off'     => __('Hidden', 'website')
				)));
			}

		// ---------------------------------------------------------------------

		// Slider options
		$slider_options = $this->getPostOptions('slider');

		// Items
		$content = $slider_options->addGroup('content', __('Content', 'website'), '', 'normal');
			$content->addOption('group', 'items', array(), __('Slider items', 'website'), '', array('multiple' => true, 'strict' => false));

		// Additional banner 1
		for ($i = 1; $i <= 2; $i++) {
			$group = $slider_options->addGroup('banner_'.$i, sprintf(__('Additional banner %s', 'website'), $i), __("It's displayed only if the &quot;slider + two banners&quot; type is used.", 'website'), 'normal');
				$group->addOption('text', 'caption', '', __('Caption', 'website'));
				$group->addOption('group', 'color', 'white', __('Caption color', 'website'), '', array('options' => array(
					'white' => __('White', 'website'),
					'black' => __('Black', 'website')
				)));
				$group->addOption('image', 'image', '', __('Image', 'website'));
				$group->addOption('codeline', 'link', '', __('Link', 'website'));
		}

		// Options
		$options = $slider_options->addGroup('options', __('Options', 'website'), '', 'side');
			$options->addOption('list', 'type', '', __('Type', 'website'), '', array('options' => array(
				'full'     => __('Full width slider', 'website'),
				'one_two'  => __('Slider + two banners', 'website'),
				'one_text' => __('Slider + text', 'website')
			)));
			$options->addOption('list', 'orderby', 'date', __('Sort by', 'website'), '', array('options' => array(
				'title'    => __('Title', 'website'),
				'date'     => __('Date', 'website'),
				'modified' => __('Modified date', 'website'),
				'rand'     => __('Random order', 'website')
			)));
			$options->addOption('list', 'order', 'desc', __('Sort order', 'website'), '', array('options' => array(
				'asc'  => __('Ascending', 'website'),
				'desc' => __('Descending', 'website')
			)));

		// ---------------------------------------------------------------------

		// Slider item options
		$slider_item_options = $this->getPostOptions('slider-item');

		// Content
		$content = $slider_item_options->addGroup('content', __('Content', 'website'), '', 'normal');
			$content->addOption('memo', 'text', '', __('On-slide text', 'website'));
			$content->addOption('group', 'color', 'white', __('Text color', 'website'), '', array('options' => array(
				'white' => __('White', 'website'),
				'black' => __('Black', 'website')
			)));
			$content->addOption('group', 'align', 'top', __('Text position', 'website'), '', array('options' => array(
				'top'      => __('Top', 'website'),
				'vertical' => __('Middle', 'website'),
				'bottom'   => __('Bottom', 'website')
			)));
			$content->addOption('text', 'caption', '', __('Caption', 'website'));
			$content->addOption('codeline', 'link', '', __('Link URL', 'website'));
			$content->addOption('boolean', 'target_blank', false, __('Link target', 'website'), '', array('caption' => __("Open in new browser's window", 'website')));

		// Video
		$video = $slider_item_options->addGroup('video', __('Video', 'website'), __("Notice: if you use video, the Content section won't be used.", 'website'));
			$video->addOption('code', 'code', '', __('External video code', 'website'));

		// Description
		$description = $slider_item_options->addGroup('description', __('Description', 'website'), __("It's displayed only if the &quot;slider + text&quot; type is used."), 'normal');
			$description->addOption('text', 'title', '', __('Title', 'website'));
			$description->addOption('memo', 'text', '', __('Text', 'website'));
			$description->addOption('memo', 'tablet_text', '', __('Text for tablet version', 'website'), __('Due to the difference in space to use on desktop and tablet versions of the site, you can prepare a different text for each version. If you leave this field empty, the same text will be used in all site versions.', 'website'));
			$description->addOption('text', 'more', __('Read more', 'website'), __('Read more word', 'website'));
			$description->addOption('codeline', 'link', '', __('Read more link', 'website'));

		// ---------------------------------------------------------------------

		// Portfolio options
		$portfolio_options = $this->getPostOptions('portfolio');

		// Items
		$content = $portfolio_options->addGroup('content', __('Content', 'website'), '', 'normal');
			$content->addOption('group', 'items', array(), __('Portfolio items', 'website'), '', array('multiple' => true, 'strict' => false));

		// Options
		$options = $portfolio_options->addGroup('options', __('Options', 'website'), '', 'side');
			$options->addOption('list', 'size', 'tiny', __('Items sizes', 'website'), '', array('options' => array(
				'big'    => __('Big', 'website'),
				'medium' => __('Medium', 'website'),
				'small'  => __('Small', 'website'),
				'tiny'   => __('Tiny', 'website')
			)));
			$options->addOption('list', 'orderby', 'date', __('Sort by', 'website'), '', array('options' => array(
				'title'         => __('Title', 'website'),
				'date'          => __('Date', 'website'),
				'modified'      => __('Modified date', 'website'),
				'comment_count' => __('Comment count', 'website'),
				'rand'          => __('Random order', 'website')
			)));
			$options->addOption('list', 'order', 'desc', __('Sort order', 'website'), '', array('options' => array(
				'asc'  => __('Ascending', 'website'),
				'desc' => __('Descending', 'website')
			)));
			$options->addOption('list', 'filter', 'category', __('Filtering', 'website'), '', array('options' => array(
				''           => __('None', 'website'),
				'category'   => __('Category filter', 'website'),
				'tag'        => __('Tag filter', 'website')
			)));
			$options->addOption('boolean', 'pagination', false, __('Page pagination', 'website'), '', array('caption' => __('Enabled', 'website')));
			$options->addOption('number', 'per_page', 12, __('Items per page', 'website'), __('Used only if you enable pagination.', 'website'), array('min' => 1, 'max' => 100));
			$options->addOption('group', 'content', array('title', 'excerpt', 'tags'), __('Content', 'website'), '', array('multiple' => true, 'options' => array(
				'title'   => __('Title', 'website'),
				'excerpt' => __('Excerpt', 'website'),
				'tags'    => __('Tags', 'website')
			)));

		// ---------------------------------------------------------------------

		// Portfolio item options
		$portfolio_item_options = $this->getPostOptions('portfolio-item');

		// Format
		$format = $portfolio_item_options->addGroup('format', __('Format', 'website'), '', 'side');
			$format->addOption('group', 'format', 'image', '', '', array('options' => array(
				''         => __('Standard', 'website'),
				'image'    => __('Image', 'website'),
				'gallery'  => __('Slider gallery', 'website'),
				'video'    => __('Video', 'website')
			)));

		// Options
		$options = $portfolio_item_options->addGroup('options', __('Options', 'website'), __('Inherit means, it will take the option from Theme Options.', 'website'), 'side', 'low');
			foreach (array(
				'about'    => __('Author details', 'website'),
				'social'   => __('Social buttons', 'website'),
				'meta'     => __('Meta elements', 'website')
			) as $name => $label) {
				$options->addOption('list', $name, 'inherit', $label, '', array('options' => array(
					'inherit' => __('Inherit', 'website'),
					'on'      => __('Visible', 'website'),
					'off'     => __('Hidden', 'website')
				)));
			}

		// Video
		$video = $portfolio_item_options->addGroup('video', __('Video', 'website'), __('These fields impact only Video format.', 'website'));
			$video->addOption('group', 'method', 'embed', __('Method', 'website'), '', array('options' => array(
				'self'  => __('Self-hosted', 'website'),
				'embed' => __('Embedding code', 'website')
			)));
			$video->addOption('codeline', 'url', '', __('File URL', 'website'), sprintf(__('Supported formats: %s.', 'website'), '<code>mp4</code>, <code>flv</code>'));
			$video->addOption('number', 'ratio', 1.7778, __('Size ratio', 'website'), __('Divide width by height to specify correct number.', 'website'), array('float' => true, 'min' => 0.1, 'max' => 10));
			$video->addOption('code', 'code', '', __('External video code', 'website'), __('It will be used instead the URL above.', 'website'));

		// ---------------------------------------------------------------------

		// Gallery options
		$gallery_options = $this->getPostOptions('gallery');

		// Options
		$options = $gallery_options->addGroup('options', __('Options', 'website'), '', 'side');
			$options->addOption('list', 'size', 'tiny', __('Thumbnails sizes', 'website'), '', array('options' => array(
				'big'    => __('Big', 'website'),
				'medium' => __('Medium', 'website'),
				'small'  => __('Small', 'website'),
				'tiny'   => __('Tiny', 'website')
			)));
			$options->addOption('list', 'orderby', 'menu_order', __('Sort by', 'website'), '', array('options' => array(
				'title'      => __('Title', 'website'),
				'date'       => __('Date', 'website'),
				'rand'       => __('Random order', 'website'),
				'menu_order' => __('Custom order', 'website')
			)));
			$options->addOption('list', 'order', 'asc', __('Sort order', 'website'), '', array('options' => array(
				'asc'  => __('Ascending', 'website'),
				'desc' => __('Descending', 'website')
			)));
			$options->addOption('boolean', 'pagination', true, __('Page pagination', 'website'), '', array('caption' => __('Enabled', 'website')));
			$options->addOption('number', 'per_page', 12, __('Thumbnails per page', 'website'), __('Used only if you enable pagination.', 'website'), array('min' => 1, 'max' => 100));

	}

	// -------------------------------------------------------------------------

	/**
	 * Theme options event
	 *
	 * @since 1.0
	 *
	 * @param object $theme_options
	 */
	protected function onThemeOptions($theme_options)
	{

		// Sliders
		$sliders_options =
			array(
				'' => __('None', 'website')
			) +
			DroneFunc::wpPostsList(array(
				'numberposts' => -1,
				'orderby'     => 'date',
				'order'       => 'DESC',
				'post_type'   => 'slider',
				'status'      => 'any'
			));
		foreach ($theme_options->child('slider/conf')->childs() as $slider) {
			$slider->options = $sliders_options;
		}

		// Front page
		foreach (array('post', 'page') as $post_type) {
			$theme_options->child("front_page/featured/{$post_type}s")->options = DroneFunc::wpPostsList(array(
				'numberposts' => -1,
				'orderby'     => 'date',
				'order'       => 'DESC',
				'post_type'   => $post_type,
				'status'      => 'publish'
			));
		}
		$theme_options->child('front_page/posts/filter/categories')->options = DroneFunc::wpTermsList('category');
		$column_icon_options =
			array('' => __('None', 'website')) +
			DroneFunc::filesList($this->template_dir.'/data/img/icons/32', 'png', create_function('$s', 'return ucfirst(str_replace("-", " ", substr($s, 0, -4)));'));
		for ($i = 0; $i < 4; $i++) {
			$theme_options->child("front_page/columns/column/{$i}/icon")->options = $column_icon_options;
		}

	}

	// -------------------------------------------------------------------------

	/**
	 * Post options event
	 *
	 * @since 1.0
	 *
	 * @param object $post_options
	 * @param int    $post_id
	 * @param string $post_type
	 */
	protected function onPostOptions($post_options, $post_id, $post_type)
	{

		// Post, page
		if ($post_type == 'post' || $post_type == 'page') {

			// Slider
			$post_options->child('options/slider')->options =
				array(
					'inherit' => __('Inherit', 'website'),
					''        => __('None', 'website')
				) +
				DroneFunc::wpPostsList(array(
					'numberposts' => -1,
					'orderby'     => 'date',
					'order'       => 'DESC',
					'post_type'   => 'slider',
					'status'      => 'any'
				));

		}

		// Slider, portfolio
		else if ($post_type == 'slider' || $post_type == 'portfolio') {

			// Items
			$post_options->child('content/items')->options = DroneFunc::wpPostsList(array(
				'numberposts' => -1,
				'orderby'     => 'date',
				'order'       => 'DESC',
				'post_type'   => $post_type.'-item',
				'status'      => 'any'
			));

		}

	}

	// -------------------------------------------------------------------------

	/**
	 * Theme options compatybility
	 *
	 * @since 1.2
	 *
	 * @param  array  $data
	 * @param  string $version
	 */
	protected function onThemeOptionsCompatybility(&$data, $version)
	{
		if (version_compare($version, '1.2') < 0) {
			if (isset($data['nav']['top']['visible'])) {
				$data['nav']['top']['visible'] = (bool)$data['nav']['top']['visible'] ? array('desktop', 'mobile') : array();
			}
			if (isset($data['nav']['main']['visible'])) {
				$data['nav']['main']['visible'] = (bool)$data['nav']['main']['visible'] ? array('desktop', 'mobile') : array();
			}
		}
		if (version_compare($version, '1.3') < 0) {
			if (isset($data['header']['text']) && isset($data['header']['logo'])) {
				$data['header']['logo'] = array(
					'text'  => $data['header']['text'],
					'image' => $data['header']['logo']
				);
			}
			if (isset($data['nav']['breadcrumbs']) && is_array($data['nav']['breadcrumbs'])) {
				if (($key = array_search('single', $data['nav']['breadcrumbs'])) !== false) {
					$data['nav']['breadcrumbs'][$key] = 'singular[post]';
				}
			}
		}
	}

	// -------------------------------------------------------------------------

	/**
	 * Initialization
	 *
	 * @since 1.0
	 */
	protected function onLoad()
	{

		// Const
		if (file_exists($this->template_dir.'/const.php')) {
			require_once $this->template_dir.'/const.php';
		}

		// Sidebars
		$this->sidebars_def = array(
			'general' => __('General sidebar', 'website'),
			'front'   => __('Front page sidebar', 'website'),
			'blog'    => __('Blog page sidebar', 'website'),
			'search'  => __('Search results page sidebar', 'website'),
			'posts'   => __('Posts sidebar', 'website'),
			'pages'   => __('Pages sidebar', 'website'),
			'404'     => __('Not found page (404) sidebar', 'website'),
		);
		for ($i = 0; $i < (defined('WEBSITE_ADDITIONAL_SIDEBARS_COUNT') ? WEBSITE_ADDITIONAL_SIDEBARS_COUNT : 3); $i++) {
			$this->sidebars_def['additional-'.$i] = sprintf(__('Additional sidebar %d', 'website'), $i+1);
		}

	}

	// -------------------------------------------------------------------------

	/**
	 * Theme setup
	 *
	 * @since 1.0
	 */
	protected function onSetupTheme()
	{

		// Default favicon
		$default_favicon = strtolower(substr(self::getThemeOption('header/text').get_bloginfo('name'), 0, 1));
		if (preg_match('/^[a-z]$/', $default_favicon)) {
			$default_favicon = sprintf('%s/data/img/favicon/%s.png', $this->template_uri, $default_favicon);
		}

		// Theme features
		$this->addThemeFeature('ogp');
		$this->addThemeFeature('widget-unwrapped-text');
		$this->addThemeFeature('widget-twitter');
		$this->addThemeFeature('widget-flickr', array('on_photo' => array($this, 'flickrOnPhoto')));
		$this->addThemeFeature('option-favicon', array('group' => 'appearance', 'default' => $default_favicon));
		$this->addThemeFeature('option-tracking-code');
		$this->addThemeFeature('option-feed-url');
		$this->addThemeFeature('shortcode-noformat');

		// Theme supports
		add_theme_support('post-thumbnails', array('post', 'page', 'slider-item', 'portfolio-item', 'newsletter'));
		add_theme_support('post-formats', array('link', 'image', 'quote', 'status', 'video', 'audio'));

		// Menu
		register_nav_menus(array(
			'top-desktop'  => __('Top menu on desktop &amp; tablet devices', 'website'),
			'top-mobile'   => __('Top menu on mobile devices', 'website'),
			'main-desktop' => __('Main menu on desktop &amp; tablet devices', 'website'),
			'main-mobile'  => __('Main menu on mobile devices', 'website')
		));

		// Featured images
		add_image_size('post-thumbnail', 300, 225, true);

		// Sidebars
		foreach ($this->sidebars_def as $name => $label) {
			register_sidebar(array(
				'name'          => $label,
				'id'            => 'sidebar-'.$name,
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget'  => '</li>',
				'before_title'  => '<h1>',
				'after_title'   => '</h1>'
			));
		}
		register_sidebar(array(
			'name'          => __('Footer sidebar', 'website'),
			'id'            => 'sidebar-bottom',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h1>',
			'after_title'   => '</h1>'
		));

		// Slider
		register_post_type('slider', array(
			'label'               => __('Sliders', 'website'),
			'description'         => __('Sliders', 'website'),
			'public'              => false,
			'show_ui'             => true,
			'supports'            => array('title', 'revisions'),
			'menu_icon'           => $this->template_uri.'/data/img/slider.png',
			'labels'              => array(
				'name'               => __('Sliders', 'website'),
				'singular_name'      => __('Slider', 'website'),
				'add_new'            => _x('Add New', 'Slider', 'website'),
				'all_items'          => __('All Sliders', 'website'),
				'add_new_item'       => __('Add New Slider', 'website'),
				'edit_item'          => __('Edit Slider', 'website'),
				'new_item'           => __('New Slider', 'website'),
				'view_item'          => __('View Slider', 'website'),
				'search_items'       => __('Search Sliders', 'website'),
				'not_found'          => __('No Sliders found', 'website'),
				'not_found_in_trash' => __('No Sliders found in Trash', 'website'),
				'menu_name'          => __('Sliders', 'website')
			)
		));
		register_post_type('slider-item', array(
			'label'               => __('Slider Items', 'website'),
			'description'         => __('Slider Items', 'website'),
			'public'              => false,
			'show_ui'             => true,
			'supports'            => array('title', 'thumbnail', 'revisions'),
			'menu_icon'           => $this->template_uri.'/data/img/slider-item.png',
			'labels'              => array(
				'name'               => __('Slider Items', 'website'),
				'singular_name'      => __('Slider Item', 'website'),
				'add_new'            => _x('Add New', 'Slider item', 'website'),
				'all_items'          => __('All Slider Items', 'website'),
				'add_new_item'       => __('Add New Slider Item', 'website'),
				'edit_item'          => __('Edit Slider Item', 'website'),
				'new_item'           => __('New Slider Item', 'website'),
				'view_item'          => __('View Slider Item', 'website'),
				'search_items'       => __('Search Slider Items', 'website'),
				'not_found'          => __('No Slider Items found', 'website'),
				'not_found_in_trash' => __('No Slider Items found in Trash', 'website'),
				'menu_name'          => __('Slider Items', 'website')
			)
		));

		// Portfolio
		register_post_type('portfolio', array(
			'label'               => __('Portfolios', 'website'),
			'description'         => __('Portfolios', 'website'),
			'public'              => true,
			'exclude_from_search' => true,
			'supports'            => array('title', 'revisions'),
			'menu_icon'           => $this->template_uri.'/data/img/portfolio.png',
			'labels'              => array(
				'name'               => __('Portfolios', 'website'),
				'singular_name'      => __('Portfolio', 'website'),
				'add_new'            => _x('Add New', 'Portfolio', 'website'),
				'all_items'          => __('All Portfolios', 'website'),
				'add_new_item'       => __('Add New Portfolio', 'website'),
				'edit_item'          => __('Edit Portfolio', 'website'),
				'new_item'           => __('New Portfolio', 'website'),
				'view_item'          => __('View Portfolio', 'website'),
				'search_items'       => __('Search Portfolios', 'website'),
				'not_found'          => __('No Portfolios found', 'website'),
				'not_found_in_trash' => __('No Portfolios found in Trash', 'website'),
				'menu_name'          => __('Portfolios', 'website')
			)
		));
		register_post_type('portfolio-item', array(
			'label'               => __('Portfolio Items', 'website'),
			'description'         => __('Portfolio Items', 'website'),
			'public'              => true,
			'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions'),
			'menu_icon'           => $this->template_uri.'/data/img/portfolio-item.png',
			'labels'              => array(
				'name'               => __('Portfolio Items', 'website'),
				'singular_name'      => __('Portfolio Item', 'website'),
				'add_new'            => _x('Add New', 'Portfolio item', 'website'),
				'all_items'          => __('All Portfolio Items', 'website'),
				'add_new_item'       => __('Add New Portfolio Item', 'website'),
				'edit_item'          => __('Edit Portfolio Item', 'website'),
				'new_item'           => __('New Portfolio Item', 'website'),
				'view_item'          => __('View Portfolio Item', 'website'),
				'search_items'       => __('Search Portfolio Items', 'website'),
				'not_found'          => __('No Portfolio Items found', 'website'),
				'not_found_in_trash' => __('No Portfolio Items found in Trash', 'website'),
				'menu_name'          => __('Portfolio Items', 'website')
			)
		));
		register_taxonomy('portfolio-item-category', array('portfolio-item'), array(
			'label'             => __('Categories', 'website'),
			'show_in_nav_menus' => false,
			'hierarchical'      => true
		));
		register_taxonomy('portfolio-item-tag', array('portfolio-item'), array(
			'label'             => __('Tags', 'website'),
			'show_in_nav_menus' => false,
			'hierarchical'      => false
		));

		// Gallery
		register_post_type('gallery', array(
			'label'               => __('Galleries', 'website'),
			'description'         => __('Galleries', 'website'),
			'public'              => true,
			'exclude_from_search' => true,
			'supports'            => array('title', 'editor', 'revisions'),
			'menu_icon'           => $this->template_uri.'/data/img/gallery.png',
			'labels'              => array(
				'name'               => __('Galleries', 'website'),
				'singular_name'      => __('Gallery', 'website'),
				'add_new'            => _x('Add New', 'Gallery', 'website'),
				'all_items'          => __('All Galleries', 'website'),
				'add_new_item'       => __('Add New Gallery', 'website'),
				'edit_item'          => __('Edit Gallery', 'website'),
				'new_item'           => __('New Gallery', 'website'),
				'view_item'          => __('View Gallery', 'website'),
				'search_items'       => __('Search Galleries', 'website'),
				'not_found'          => __('No Galleries found', 'website'),
				'not_found_in_trash' => __('No Galleries found in Trash', 'website'),
				'menu_name'          => __('Galleries', 'website')
			)
		));

		// Styles
		require $this->template_dir.'/styles.php';

		// Leading color
		$this->addDocumentStyle(sprintf($styles['leading_color'], self::getThemeOption('appearance/color')));

		// Header height
		$this->addDocumentStyle(sprintf($styles['header_height'], self::getThemeOption('header/height')));

		// Custom background
		if (self::getThemeOption('appearance/background/enabled')) {
			$background = self::getThemeOption('appearance/background/settings', true);
			$this->addDocumentStyle(sprintf($styles['custom_background'], $background->css(), $background->property('color')));
		}

		// Custom font
		if (self::getNotEmptyThemeOption('appearance/font/enabled') && $font = self::getNotEmptyThemeOption('appearance/font/name', 'appearance/font/custom_name')) {
			if ($font != self::getThemeOption('appearance/font/name', true)->default) {
				if (strpos($font, ' ') !== false) {
					$font = "\"{$font}\"";
				}
				$this->addDocumentStyle(sprintf($styles['custom_font'], $font));
			}
		}

		// Slider height
		if (!self::getThemeOption('slider/height/full', true)->isDefault()) {
			$height = self::getThemeOption('slider/height/full');
			$ratio  = $height / 940;
			$this->addDocumentStyle(sprintf($styles['slider_height']['full'], $height, round($ratio*700), round($ratio*300), round($ratio*220))); // todo: jako stale
		}
		if (!self::getThemeOption('slider/height/one_text', true)->isDefault()) {
			$height = self::getThemeOption('slider/height/one_text');
			$ratio  = $height / 620;
			$this->addDocumentStyle(sprintf($styles['slider_height']['one_text'], $height, round($ratio*460), round($ratio*300), round($ratio*220)));
		}

		// Scripts
		if (is_active_widget(false, false, 'archives')) {
			$this->addDocumentJQueryScript("\$('#aside .widget-archive > ul').addClass('fancy');");
		}

	}

	// -------------------------------------------------------------------------

	/**
	 * Widgets setup
	 *
	 * @since 1.0
	 */
	protected function onWidgetsInit()
	{
		unregister_widget('WP_Widget_Search');
		unregister_widget('WP_Widget_Calendar');
		register_widget('WebsiteWidgetSearch');
		register_widget('WebsiteWidgetSocial');
		register_widget('WebsiteWidgetInfo');
		register_widget('WebsiteWidgetContact');
		register_widget('WebsiteWidgetFacebookLikeBox');
	}

	// -------------------------------------------------------------------------

	/**
	 * wp action
	 *
	 * @internal action: wp
	 * @since 1.1
	 */
	public function actionWP()
	{
		if (defined('WEBSITE_SCHEME_SWITCHER') && WEBSITE_SCHEME_SWITCHER && !is_admin()) {
			$cookie_name = "wordpress_{$this->name}_scheme";
			if (isset($_GET['scheme'])) {
				$scheme = $_GET['scheme'];
			} else if (isset($_COOKIE[$cookie_name])) {
				$scheme = $_COOKIE[$cookie_name];
			} else {
				$scheme = '';
			}
			if ($scheme && in_array($scheme, array('bright', 'dark'))) {
				Website::setThemeOption('appearance/scheme', $scheme);
				setcookie($cookie_name, $scheme, time()+30*86400, COOKIEPATH, COOKIE_DOMAIN);
			}
		}
	}

	// -------------------------------------------------------------------------

	/**
	 * comment_form_before action
	 *
	 * @internal action: comment_form_before
	 * @since 1.0
	 */
	public function actionCommentFormBefore()
	{
		echo '<section class="comment-form">';
	}

	// -------------------------------------------------------------------------

	/**
	 * comment_form_after action
	 *
	 * @internal action: comment_form_after
	 * @since 1.0
	 */
	public function actionCommentFormAfter()
	{
		echo '</section>';
	}

	// -------------------------------------------------------------------------

	/**
	 * the_content_more_link filter
	 *
	 * @internal filter: the_content_more_link
	 * @since 1.0
	 *
	 * @param  string $more_link_html
	 * @return string
	 */
	public function filterTheContentMoreLink($more_link_html)
	{
		return str_replace('more-link', 'more more-link', $more_link_html);
	}

	// -------------------------------------------------------------------------

	/**
	 * dynamic_sidebar_params filter
	 *
	 * @internal filter: dynamic_sidebar_params
	 * @since 1.0
	 *
	 * @param array $params
	 */
	public function filterDynamicSidebarParams($params)
	{
		$params[0]['before_widget'] = preg_replace('/widget[_a-z0-9]+/e', '"\0 ".str_replace("_", "-", "\0");', $params[0]['before_widget']);
		if ($params[0]['id'] == 'sidebar-bottom') {
			static $column = 0;
			static $layout = null;
			if (!is_array($layout)) {
				$layout = str_split(self::getThemeOption('footer/layout'), 1);
			}
			if (isset($layout[$column])) {
				switch ($layout[$column]) {
					case 's': $class = 'small';  break;
					case 'm': $class = 'medium'; break;
					case 'l': $class = 'large';  break;
					case 'f': $class = 'full';   break;
					case 'x': $class = 'fixed';  break;
					default:  $class = '';
				}
			} else {
				$class = 'none';
			}
			$params[0]['before_widget'] = str_replace('widget ', "widget {$class} ", $params[0]['before_widget']);
			$column++;
		}
		return $params;
	}

	// -------------------------------------------------------------------------

	/**
	 * the_password_form filter
	 *
	 * @internal filter: the_password_form
	 * @since 1.0
	 *
	 * @param  string $output
	 * @return string
	 */
	public function filterThePasswordForm($output)
	{

		global $wp_version, $post;

		return sprintf(

			'<form action="%1$s/%2$s" method="post">'.
				'<p>%4$s</p>'.
				'<p><input name="post_password" id="%3$s" type="password" size="20" placeholder="%5$s" /> <span class="lte-ie9 lte-ff3">%5$s</span></p>'.
				'<p><input type="submit" name="submit" value="%6$s" /></p>'.
			'</form>',

			get_option('siteurl'),
			version_compare($wp_version, '3.4') >= 0 ? 'wp-login.php?action=postpass' : 'wp-pass.php',
			'pwbox-'.(empty($post->ID) ? rand() : $post->ID),

			__('This post is password protected. To view it please enter your password below:'),
			__('password', 'website'),
			esc_attr__('Submit')

		);

	}

	// -------------------------------------------------------------------------

	/**
	 * post_gallery filter
	 *
	 * @internal filter: post_gallery
	 * @since 1.0
	 *
	 * @param  null   $depricated
	 * @param  array  $atts
	 * @return string
	 */
	public function filterPostGallery($depricated, $atts)
	{

		extract(shortcode_atts(array(
			'id'         => get_the_ID(),
			'link'       => 'post',
			'orderby'    => 'menu_order ID',
			'order'      => 'ASC',
			'columns'    => 3,
			'include'    => '',
			'exclude'    => '',
			'border'     => 'inherit'
		), $atts));

		$params = array(
			'numberposts'    => -1,
			'post_parent'    => $id,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'orderby'        => $orderby,
			'order'          => $order
		);
		if (!empty($include)) {
			unset($params['post_parent']);
			$params['include'] = preg_replace('/[^0-9,]+/', '', $include);
		} else if (!empty($exclude)) {
			$params['exclude'] = preg_replace('/[^0-9,]+/', '', $exclude);
		}
		$attachments = get_posts($params);

		$output = ' ';
		foreach ($attachments as $num => $attachment) {

			list($src) = wp_get_attachment_image_src($attachment->ID, ''); // todo: bez '' na koncu obrazki w galleri beda jak thumbnaile w wp (kwadratowe)
			$url = $link == 'file' ? $src : get_attachment_link($attachment->ID); // wtedy nie $src

			if ($num % $columns == 0) {
				$output .= sprintf('<div class="columns gallery gallery-%d">', $id);
			}

			$output .= sprintf( // todo: uzyc DroneHTML
				'<div class="column col-1-%d %s">'.
					'<figure class="attachment-%d full-width-mobile %s">'.
						'<a href="%s" title="%s" class="%s" rel="gallery-%d">%s</a>'.
						'<figcaption>%s</figcaption>'.
					'</figure>'.
				'</div>',
				$columns,
				($num+1) % $columns == 0 ? 'last' : '',
				$attachment->ID,
				$border == 'inherit' ? $this->getThemeOption('appearance/image/border') : $border,
				$url,
				esc_attr($attachment->post_excerpt),
				$link == 'file' ? 'fancybox' : '',
				$id,
				self::getResponsiveImage($src)->html(),
				$attachment->post_excerpt
			);

			if (($num+1) % $columns == 0 || $num == count($attachments)-1) {
				$output .= '</div>';
			}

		}

		return $output;

	}

	// -------------------------------------------------------------------------

	/**
	 * img_caption_shortcode filter
	 *
	 * @internal filter: img_caption_shortcode
	 * @since 1.0
	 *
	 * @param  null   $depricated
	 * @param  array  $atts
	 * @param  string $content
	 * @return string
	 */
	public function filterImgCaptionShortcode($depricated, $atts, $content = null)
	{

		// Attributes
		extract(shortcode_atts(array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => '',
			'border'  => 'inherit'
		), $atts));

		// Image source
		if (preg_match('/^attachment_([0-9]+)$/i', $id, $matches)) {
			list($src) = wp_get_attachment_image_src((int)$matches[1], '');
		} else if (preg_match('/src="(.+?)"/i', $content, $matches)) {
			$src = $matches[1];
		} else {
			return;
		}

		// Parameters
		$href  = preg_match('/href="(.+?)"/', $content, $matches) ? $matches[1] : '';
		$class = preg_match('/wp-image-[0-9]+/', $content, $matches) ? $matches[0] : '';

		// Figure
		$figure = DroneHTML::make('figure')
			->addClass('full-width-mobile')
			->addClass($align)
			->addClass($border == 'inherit' ? $this->getThemeOption('appearance/image/border') : $border)
			->style(sprintf('width: %s;', (integer)$width > 0 ? $width.'px' : '100%'));

		// Image
		$img = self::getResponsiveImage($src)->addClass($class)->alt($caption);

		// Hyperlink
		if ($href) {
			$a = $figure->addNew('a')->href($href)->add($img);
			if ($this->getThemeOption('appearance/image/fancybox') && preg_match('/\.(jpe?g|png|gif|bmp)/i', $href)) {
				$a->class('fancybox')->title($caption);
			} else if (preg_match('/target="(.+?)"/', $content, $matches)) {
				$a->target($matches[1]);
			}
		} else {
			$figure->add($img);
		}

		// Caption
		if ($caption) {
			$figure->addNew('figcaption')->add($caption);
		}

		// Result
		return $figure->html();

	}

	// -------------------------------------------------------------------------

	/**
	 * the_content filter
	 *
	 * @internal filter: the_content, 1
	 * @since 1.0
	 *
	 * @param  string $content
	 * @return string
	 */
	public function filterTheContent($content)
	{
		return preg_replace_callback('|(\[caption.*?\])?((<a.*?>)?(<img.*? />)(</a>)?)|i', array($this, 'filterTheContentCallback'), $content);
		/* return preg_replace_callback('|(?<!\])(<a.*?>)?(<img.*? />)(</a>)?(?!\[/caption\])(?!</a>)\s*|i', array($this, 'filterTheContentCallback'), $content); */
	}

	// -------------------------------------------------------------------------

	/**
	 * the_content filter helper function
	 *
	 * @since 1.0
	 *
	 * @param  array  $matches
	 * @return string
	 */
	public function filterTheContentCallback($matches)
	{
		$image = trim($matches[2]);
		if ($matches[1] || preg_match('/class=".*no-responsive.*"/i', $image)) {
			return $matches[0];
		}
		$id    = preg_match('/class=".*wp-image-([0-9]+).*"/i', $image, $matches) ? 'attachment_'.$matches[1] : '';
		$align = preg_match('/class=".*(align(none|left|right)).*"/i', $image, $matches) ? strtolower($matches[1]) : '';
		$width = preg_match('/width="([0-9]+)"/', $image, $matches) ? $matches[1] : '';
		return sprintf(
			'[caption id="%s" align="%s" width="%s"]%s[/caption]'."\n\n",
			$id, $align, $width, $image
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * previous_post_link, next_post_link filter
	 *
	 * @internal filter: previous_post_link
	 * @internal filter: next_post_link
	 * @since 1.3
	 *
	 * @param  string $format
	 * @return string
	 */
	public function filterPreviousPostLink($format)
	{
		if (preg_match('/rel="(prev|next)"/', $format, $matches)) {
			$rel = $matches[1];
			return preg_replace(
				'|^<a href="(.*?)".*?>(.*?)</a>$|ie',
				"'<a href=\"\\1\" class=\"{$rel}\" rel=\"{$rel}\">".
					"<span class=\"hide-lte-tablet\">'.DroneFunc::stringCut('\\2', 32, '&hellip;', 2).'</span>".
					"<span class=\"tablet\">'.DroneFunc::stringCut('\\2', 20, '&hellip;', 2).'</span>".
				"</a>'",
				$format
			);
		} else {
			return $format;
		}
	}

	// -------------------------------------------------------------------------

	/**
	 * Dropcap shortcode
	 *
	 * @internal shortcode: dropcap
	 * @internal shortcode: dc
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeDropcap($atts, $content = null, $code = '')
	{
		return sprintf(
			'<span class="dropcap">%s</span>',
			DroneFunc::wpShortcodeContent($content, 'inline', false)
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * Hr shortcode
	 *
	 * @internal shortcode: hr
	 * @internal shortcode: line
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeHr($atts, $content = null, $code = '')
	{
		return '<hr />';
	}

	// -------------------------------------------------------------------------

	/**
	 * Mark shortcode
	 *
	 * @internal shortcode: mark
	 * @internal shortcode: highlight
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeMark($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'color' => ''
		), $atts));
		return sprintf(
			'<mark class="%s">%s</mark>',
			$color,
			DroneFunc::wpShortcodeContent($content, 'inline')
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * Quote shortcode
	 *
	 * @internal shortcode: quote
	 * @since 1.4
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeQuote($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'align' => 'none',
			'width' => '100%'
		), $atts));
		return sprintf(
			'<blockquote class="align%s" style="width: %s;">%s</blockquote>',
			$align,
			$width,
			DroneFunc::wpShortcodeContent($content, 'block', false)
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * Icon shortcode
	 *
	 * @internal shortcode: icon
	 * @since 1.3
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeIcon($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'name' => '',
			'size' => 'small'
		), $atts));
		$size = $size == 'big' ? 32 : 16;
		return sprintf(
			'<img src="%1$s" class="icon" width="%2$d" height="%2$d" alt="" />',
			"{$this->template_uri}/data/img/icons/{$size}/{$name}.png",
			$size
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * List shortcode
	 *
	 * @internal shortcode: list
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeList($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'icon' => 'check'
		), $atts));
		$content = preg_replace('/^<ul>$/im', sprintf('<ul class="list %s">', $icon), $content);
		return DroneFunc::wpShortcodeContent($content, 'inline', false);
	}

	// -------------------------------------------------------------------------

	/**
	 * Tooltip shortcode
	 *
	 * @internal shortcode: tooltip
	 * @internal shortcode: tip
	 * @since 1.2
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeTooltip($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'title'   => '',
			'gravity' => 'n'
		), $atts));
		return sprintf(
			'<span class="tooltip" title="%s" data-gravity="%s">%s</span>',
			$title,
			$gravity,
			DroneFunc::wpShortcodeContent($content, 'inline')
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * Button shortcode
	 *
	 * @internal shortcode: button
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeButton($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'type'   => 'normal',
			'url'    => '',
			'target' => 'self',
			'icon'   => '',
		), $atts));
		$class = $type;
		$attr = '';
		if (($type == 'normal' || $type == 'big') && $icon) {
			$size = $type == 'big' ? 32 : 16;
			$class .= ' icon-'.$size;
			$attr .= " style=\"background-image: url({$this->template_uri}/data/img/icons/{$size}/{$icon}.png);\"";
		}
		if ($url) {
			$attr .= " data-href=\"{$url}\"";
			if ($target) {
				$attr .= sprintf(' data-target="%s"', ltrim($target, '_'));
			}
		}
		return sprintf(
			'<button class="%s"%s>%s</button>',
			$class,
			$attr,
			DroneFunc::wpShortcodeContent($content, 'inline', false)
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * Box shortcode
	 *
	 * @internal shortcode: box
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeBox($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'color' => 'blue',
			'icon'  => '',
			'size'  => 'small'
		), $atts));
		$class = $color;
		$attr = '';
		if ($icon) {
			$size = $size == 'small' ? 16 : 32;
			$class .= ' icon-'.$size;
			$attr .= " style=\"background-image: url({$this->template_uri}/data/img/icons/{$size}/{$icon}.png);\"";
		}
		return sprintf(
			'<div class="frame %s"%s>%s</div>',
			$class,
			$attr,
			DroneFunc::wpShortcodeContent($content, 'block')
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * Column shortcode
	 *
	 * @internal shortcode: column
	 * @internal shortcode: col
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeColumn($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
				'width'  => '1/2',
				'first'  => '',
				'last'   => ''
		), $atts));
		$s = '';
		if ($first) {
			$s .= '<div class="columns">';
		}
		$s .= sprintf(
			'<div class="column col-%s%s">%s</div>',
			str_replace(array('/', '\\', '.', ',', ' '), '-', $width),
			$last ? ' last' : '',
			DroneFunc::wpShortcodeContent($content, 'block')
		);
		if ($last) {
			$s .= '</div>';
		}
		return $s;
	}

	// -------------------------------------------------------------------------

	/**
	 * Tab shortcode
	 *
	 * @internal shortcode: tab
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeTab($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'label'  => '',
			'first'  => '',
			'last'   => '',
			'active' => ''
		), $atts));
		$attr = '';
		if ($active) {
			$attr .= ' data-active="true"';
		}
		$s = '';
		if ($first) {
			$s .= '<div class="tabs">';
		}
		$s .= sprintf(
			'<div class="clear" data-label="%s"%s>%s</div>',
			$label,
			$attr,
			DroneFunc::wpShortcodeContent($content, 'block')
		);
		if ($last) {
			$s .= '</div>';
		}
		return $s;
	}

	// -------------------------------------------------------------------------

	/**
	 * Media shortcode
	 *
	 * @internal shortcode: media
	 * @since 1.0
	 *
	 * @param  string $atts
	 * @param  string $content
	 * @param  string $code
	 * @return string
	 */
	public function shortcodeMedia($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'version' => 'all',
			'visible' => 'yes',
			'type'    => 'block'
		), $atts));
		if (!$visible || $visible == 'no' || $visible == 'false') {
			$version = 'hide-'.$version;
		}
		if ($type != 'block') {
			$type = 'inline';
		}
		return sprintf(
			'<%1$s class="%2$s">%3$s</%1$s>',
			$type == 'block' ? 'div' : 'span',
			$version,
			DroneFunc::wpShortcodeContent($content, $type)
		);
	}

	// -------------------------------------------------------------------------

	/**
	 * Get JWPlayer path
	 *
	 * @since 1.3
	 *
	 * @return string
	 */
	public static function getJWPlayerPath()
	{
		$path = Website::getThemeOption('advanced/jwplayer/path');
		if ($path && file_exists(self::get('template_dir').'/'.$path)) {
			return self::get('template_uri').'/'.$path;
		} else {
			return '';
		}
	}

	// -------------------------------------------------------------------------

	/**
	 * JWPlayer path
	 *
	 * @since 1.3
	 */
	public static function jwplayerPath()
	{
		echo self::getJWPlayerPath();
	}

	// -------------------------------------------------------------------------

	/**
	 * Get JWPlayer skin file
	 *
	 * @since 1.3
	 *
	 * @return string
	 */
	public static function getJWPlayerSkinFile()
	{
		$file = Website::getThemeOption('advanced/jwplayer/skin/file');
		if ($file && file_exists(self::get('template_dir').'/'.$file)) {
			return self::get('template_uri').'/'.$file;
		} else {
			return '';
		}
	}

	// -------------------------------------------------------------------------

	/**
	 * JWPlayer skin file
	 *
	 * @since 1.3
	 */
	public static function jwplayerSkinFile()
	{
		echo self::getJWPlayerSkinFile();
	}

	// -------------------------------------------------------------------------

	/**
	 * Get responsive image
	 *
	 * @since 1.2
	 *
	 * @param  string $src
	 * @return object
	 */
	public static function getResponsiveImage($src)
	{
		$img = DroneHTML::make('img')->alt('');
		$relative_src = DroneFunc::wpRelativeImageSrc($src);
		if (!is_feed() && self::getThemeOption('advanced/timthumb/enabled') && stripos($relative_src, 'wp-content') === 0 && preg_match('/\.(jpe?g|png|bmp)/i', $src)) {
			$img
				->class('responsive')
				->src('/')
				->attr('data-src', $relative_src);
		} else {
			$img->src($src);
		}
		return $img;
	}

	// -------------------------------------------------------------------------

	/**
	 * Responsive image
	 *
	 * @since 1.2
	 *
	 * @param  string $src
	 */
	public static function responsiveImage($src)
	{
		self::getResponsiveImage($src)->ehtml();
	}

	// -------------------------------------------------------------------------

	/**
	 * Get responsive thumbnail
	 *
	 * @since 1.2
	 *
	 * @param  int    $id
	 * @return object
	 */
	public static function getResponsiveThumbnail($id = 0)
	{
		list($src) = wp_get_attachment_image_src($id === 0 ? get_post_thumbnail_id() : $id, '');
		return self::getResponsiveImage($src);
	}

	// -------------------------------------------------------------------------

	/**
	 * Responsive thumbnail
	 *
	 * @since 1.2
	 *
	 * @param int $id
	 */
	public static function responsiveThumbnail($id = 0)
	{
		self::getResponsiveThumbnail()->ehtml();
	}

	// -------------------------------------------------------------------------

	/**
	 * Navigation menu
	 *
	 * @since 1.2
	 *
	 * @param string $nav
	 */
	public static function navMenu($nav)
	{
		extract(self::getThemeOption('nav/'.$nav, true)->toArray());
		if (empty($visible)) {
			return;
		}
		$menu = DroneHTML::make('nav')->id('nav-'.$nav)->class('clear');
		foreach ($visible as $device) {
			$class = sprintf('%slte-mobile', $device == 'desktop' ? 'hide-' : '');
			$nav_menu = wp_nav_menu(array(
				'theme_location' => "{$nav}-{$device}",
				'echo'           => false,
				'container'      => '',
				'menu_id'        => "nav-{$nav}-{$device}",
				'menu_class'     => $class,
				'fallback_cb'    => create_function('',
					"return '<ul class=\"{$class}\">'.wp_list_{$content}(array('title_li' => '', 'depth' => 0, 'echo' => false)).'</ul>';"
				)
			));
			$menu->add($nav_menu);
		}
		if (count($visible) == 1) {
			$menu->addClass($class);
		}
		$menu->ehtml();
	}

	// -------------------------------------------------------------------------

	/**
	 * Comment template
	 *
	 * @since 1.0
	 *
	 * @param object $comment
	 * @param array  $args
	 * @param int    $depth
	 */
	public static function comment($comment, $args, $depth)
	{
		$GLOBALS['comment'] = $comment;
		$comment_reply_args = array(
			'reply_text' => __('Reply', 'website'),
			'depth'      => $depth
		);
		?>
		<article id="comment-<?php comment_ID(); ?>" <?php comment_class('level-'.($depth-1)); ?>>
			<?php echo get_avatar($comment, 35); ?>
			<div class="meta">
				<cite><?php comment_author_link(); ?></cite>
				<div class="date">
					<time datetime="<?php printf('%sT%sZ', get_comment_date('Y-m-d'), get_comment_time('H:i')); ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?></time> &bull;
					<?php comment_reply_link(array_merge($args, $comment_reply_args)); ?>
					<?php edit_comment_link(__('Edit', 'website'), ' &bull; '); ?>
				</div>
			</div>
			<div class="content">
				<?php if ($comment->comment_approved == '0') : ?>
					<p><em><?php _e('Your comment is awaiting moderation.', 'website'); ?></em></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
		</article>
		<?php
	}

	// -------------------------------------------------------------------------

	/**
	 * Contact form field template
	 *
	 * @since 1.0
	 *
	 * @param  string $field
	 * @param  bool   $required
	 * @param  string $label
	 * @return string
	 */
	public static function contactFormField($field, $required, $label)
	{
		if ($field == 'message') {
			$s = '<p><textarea name="%1$s"></textarea></p>';
		} else {
			$s = '<p><input type="text" name="%1$s" placeholder="%2$s%3$s" /> <span class="lte-ie9 lte-ff3">%2$s%3$s</span></p>';
		}
		return sprintf($s, $field, strtolower($label), $required ? '*' : '');
	}

	// -------------------------------------------------------------------------

	/**
	 * Get sidebar name
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public static function getSidebarName()
	{
		if (is_singular()) {
			$sidebar = self::getPostOption('options/sidebar');
		}
		if (!isset($sidebar) || $sidebar == 'inherit') {
			$sidebar = DroneFunc::wpContitionTagSwitch(self::getThemeOption('sidebar/conf', true)->toArray());
		}
		return $sidebar;
	}

	// -------------------------------------------------------------------------

	/**
	 * Get slider name
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public static function getSliderName()
	{
		if (is_singular()) {
			$slider = self::getPostOption('options/slider');
		}
		if (!isset($slider) || $slider == 'inherit') {
			$slider = DroneFunc::wpContitionTagSwitch(self::getThemeOption('slider/conf', true)->toArray());
		}
		return $slider;
	}

	// -------------------------------------------------------------------------

	/**
	 * Get content section class
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public static function getContentClass()
	{
		if (self::getSidebarName()) {
			return self::getThemeOption('appearance/sidebar') == 'right' ? 'alpha' : 'beta';
		} else {
			return '';
		}
	}

	// -------------------------------------------------------------------------

	/**
	 * Content section class
	 *
	 * @since 1.0
	 */
	public static function contentClass()
	{
		echo self::getContentClass();
	}

}

// -----------------------------------------------------------------------------

Website::create('Website');


// make category use parent category template
function load_cat_parent_template($template) {

    $cat_ID = absint( get_query_var('cat') );
    $category = get_category( $cat_ID );

    $templates = array();

    if ( !is_wp_error($category) )
        $templates[] = "category-{$category->slug}.php";

    $templates[] = "category-$cat_ID.php";

    // trace back the parent hierarchy and locate a template
    if ( !is_wp_error($category) ) {
        $category = $category->parent ? get_category($category->parent) : '';

        if( !empty($category) ) {
            if ( !is_wp_error($category) )
                $templates[] = "category-{$category->slug}.php";

            $templates[] = "category-{$category->term_id}.php";
        }
    }

    $templates[] = "category.php";
    $template = locate_template($templates);

    return $template;
}
add_action('category_template', 'load_cat_parent_template');
