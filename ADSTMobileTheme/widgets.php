<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

// -----------------------------------------------------------------------------

class WebsiteWidgetSearch extends DroneWidget
{

	// -------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct(__('Search', 'website'), __('A search form for your site.', 'website'));
	}

	// -------------------------------------------------------------------------

	public function widget($args, $instance)
	{

		parent::widget($args, $instance);

		$html = DroneHTML::make('form')->action(esc_url(home_url('/')))->method('get')->add(
			DroneHTML::make('input')->type('submit')->value(''),
			DroneHTML::make('div')->class('input')->add(
				DroneHTML::make('input')->name('s')->type('text')->placeholder(esc_attr__('search', 'website'))->value(get_search_query())
			)
		);
		$this->htmlOutput($args, '', $html);

	}

}

// -----------------------------------------------------------------------------

class WebsiteWidgetSocial extends DroneWidget
{

	// -------------------------------------------------------------------------

	private function getSlotCount()
	{
		return defined('WEBSITE_SOCIAL_WIDGET_SLOT_COUNT') ? WEBSITE_SOCIAL_WIDGET_SLOT_COUNT : 8;
	}

	// -------------------------------------------------------------------------

	protected function onSetupOptions($widget_options)
	{
		$widget_options->addOption('list', 'type', 'vertical', __('Type', 'website'), '', array('options' => array(
			'vertical'   => __('Vertical', 'website'),
			'horizontal' => __('Horizontal', 'website')
		)));
		$widget_options->addOption('boolean', 'target_blank', false, '', '', array('caption' => __('Open links in new window', 'website')));
		$icons = array_merge(
			array('' => ''),
			DroneFunc::filesList(self::$_theme_instance->template_dir.'/data/img/bright/social', 'png', create_function('$s', 'return ucfirst(substr($s, 0, -4));'))
		);
		for ($i = 0; $i < $this->getSlotCount(); $i++) {
			$widget_options->addOption('list', "slot_{$i}_icon", '', sprintf(__('Slot %d icon', 'website'), $i+1), '', array('options' => $icons));
			$widget_options->addOption('text', "slot_{$i}_title", '', sprintf(__('Slot %d title', 'website'), $i+1));
			$widget_options->addOption('codeline', "slot_{$i}_url", '', sprintf(__('Slot %d url', 'website'), $i+1));
		}
	}

	// -------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct(__('Social media', 'website'), __('Social media icons.', 'website'));
	}

	// -------------------------------------------------------------------------

	public function widget($args, $instance)
	{

		parent::widget($args, $instance);

		$scheme = Website::getThemeOption('appearance/scheme');
		if ($args['id'] == 'sidebar-bottom') {
			$scheme = $scheme == 'bright' ? 'dark' : 'bright';
		}

		extract($this->getWidgetOption('', true)->toArray());

		$slot_count = $this->getSlotCount();
		while ($slot_count > 0) {
			if (${'slot_'.($slot_count-1).'_icon'}) {
				break;
			} else {
				$slot_count--;
			}
		}

		$html = DroneHTML::make('ul')->class($type)->add();
		for ($i = 0; $i < $slot_count; $i++) {
			$icon  = ${"slot_{$i}_icon"};
			$title = ${"slot_{$i}_title"};
			$url   = ${"slot_{$i}_url"};
			if (($icon && $title && $url) || $type == 'horizontal') {
				$_html = DroneHTML::make('li')->add();
				if ($icon && $url) {
					$_html->addNew('a')
						->href($url)
						->title($title)
						->style(sprintf('background-image: url(%s/data/img/%s/social/%s);', self::$_theme_instance->template_uri, $scheme, $icon))
						->add($title);
					if ($target_blank) {
						$_html->child(0)->target('blank');
					}
				}
				$html->add($_html);
			}
		}
		$this->htmlOutput($args, '', $html);

	}

}

// -----------------------------------------------------------------------------

class WebsiteWidgetInfo extends DroneWidget
{

	// -------------------------------------------------------------------------

	protected function onSetupOptions($widget_options)
	{
		$widget_options->addOption('text', 'title', get_bloginfo('name'), __('Site title', 'website'));
		$widget_options->addOption('text', 'tagline', get_bloginfo('description'), __('Tagline', $this->theme_name));
	}

	// -------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct(__('Site info', 'website'), __('Website title and tagline.', 'website'));
	}

	// -------------------------------------------------------------------------

	public function widget($args, $instance)
	{

		parent::widget($args, $instance);

		$html = DroneHTML::make('hgroup')->add(
			DroneHTML::make('h1')->add($this->getWidgetOption('title')),
			DroneHTML::make('h2')->add($this->getWidgetOption('tagline'))
		);
		$this->htmlOutput($args, '', $html);

	}

}

// -----------------------------------------------------------------------------

class WebsiteWidgetContact extends DroneWidget
{

	// -------------------------------------------------------------------------

	protected function onSetupOptions($widget_options)
	{
		$widget_options->addOption('text', 'title', '', __('Title', 'website'));
	}

	// -------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct(__('Contact form', 'website'), __('It displays only required fields from the contact form configured it in the Appereance / Theme Options / Contact Form section.', 'website'));
	}

	// -------------------------------------------------------------------------

	public function contactFormField($field, $required, $label)
	{
		switch ($field) {
			case 'name':
			case 'email':
				$s = '<p><input type="text" name="%1$s" placeholder="%2$s%3$s" /> <span class="lte-ie9 lte-ff3">%2$s%3$s</span></p>';
				break;
			case 'message':
				$s = '<p><textarea name="%1$s"></textarea></p>';
				break;
			default:
				return '';
		}
		return sprintf($s, $field, strtolower($label), $required ? '*' : '');
	}

	// -------------------------------------------------------------------------

	public function widget($args, $instance)
	{

		parent::widget($args, $instance);

		$contact_form_after = sprintf(
			'<p class="frame message"></p>'.
			'<p><input type="submit" value="%s" /><img class="load" src="%s/data/img/%s/%s.gif" alt="" width="16" height="16" /></p>',
			__('Send', 'website'),
			self::$_theme_instance->template_uri,
			Website::getThemeOption('appearance/scheme'),
			$args['id'] == 'sidebar-bottom' ? 'load-bottom' : 'load'
		);

		$html = DroneHTML::make()->add(
			Website::contactForm(array($this, 'contactFormField'), '', $contact_form_after, true)
		);
		$this->htmlOutput($args, $this->getWidgetOption('title'), $html);

	}

}


// -----------------------------------------------------------------------------

class WebsiteWidgetFacebookLikeBox extends DroneWidget
{

	// -------------------------------------------------------------------------

	protected function onSetupOptions($widget_options)
	{
		$widget_options->addOption('codeline', 'href', '', __('Facebook page URL', 'website'), sprintf(__('E.g. %s', 'website'), '<code>http://www.facebook.com/platform</code>'));
		$widget_options->addOption('number', 'height', 292, __('Height', 'website'), '', array('unit' => 'px', 'min' => 50, 'max' => 1000));
		$widget_options->addOption('boolean', 'header', true, '', '', array('caption' => __('Show header', 'website')));
		$widget_options->addOption('boolean', 'show_faces', true, '', '', array('caption' => __('Show faces', 'website')));
		$widget_options->addOption('boolean', 'stream', false, '', '', array('caption' => __('Show stream', 'website')));
	}

	// -------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct(__('Facebook Like Box', 'website'), __('Configurable Facebook widget.', 'website'), 'widget-custom');
	}

	// -------------------------------------------------------------------------

	public function widget($args, $instance)
	{

		parent::widget($args, $instance);

		$scheme = Website::getThemeOption('appearance/scheme');
		if ($args['id'] == 'sidebar-bottom') {
			$scheme = $scheme == 'bright' ? 'dark' : 'bright';
		}

		extract($this->getWidgetOption('', true)->toArray());

		$html = DroneHTML::make('div')
			->style(sprintf('height: %dpx;', $height))
			->add(
				DroneHTML::make('div')
					->class('fb-like-box')
					->attr('data-href', $href)
					->attr('data-width', 220)
					->attr('data-height', $height)
					->attr('data-header', DroneFunc::boolToString($header))
					->attr('data-show-faces', DroneFunc::boolToString($show_faces))
					->attr('data-stream', DroneFunc::boolToString($stream))
					->attr('data-colorscheme', $scheme == 'bright' ? 'light' : 'dark')
					->attr('data-border_color', $scheme == 'bright' ? '#cfcfcf' : '#3b3b3b')
			);

		$this->htmlOutput($args, '', $html);

	}

}