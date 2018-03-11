<?php
/**
 * my_newsportal Admin Class.
 *
 * @author  my_newsportal
 * @package my_newsportal
 * @since   1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'my_newsportal_Admin' ) ) :

/**
 * my_newsportal_Admin Class.
 */
class my_newsportal_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_loaded', array( __CLASS__, 'hide_notices' ) );
		add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$theme = wp_get_theme( get_template() );

		$page = add_theme_page( esc_html__( 'About', 'my_newsportal' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'my_newsportal' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'my_newsportal-welcome', array( $this, 'welcome_screen' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {
		global $my_newsportal_version;

		wp_enqueue_style( 'my_newsportal-welcome', get_template_directory_uri() . '/css/admin/welcome.css', array(), $my_newsportal_version );
	}

	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $my_newsportal_version, $pagenow;

		wp_enqueue_style( 'my_newsportal-message', get_template_directory_uri() . '/css/admin/message.css', array(), $my_newsportal_version );

		// Let's bail on theme activation.
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			update_option( 'my_newsportal_admin_notice_welcome', 1 );

		// No option? Let run the notice wizard again..
		} elseif( ! get_option( 'my_newsportal_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function hide_notices() {
		if ( isset( $_GET['my_newsportal-hide-notice'] ) && isset( $_GET['_my_newsportal_notice_nonce'] ) ) {
			if ( ! wp_verify_nonce( $_GET['_my_newsportal_notice_nonce'], 'my_newsportal_hide_notices_nonce' ) ) {
				wp_die( __( 'Action failed. Please refresh the page and retry.', 'my_newsportal' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Cheatin&#8217; huh?', 'my_newsportal' ) );
			}

			$hide_notice = sanitize_text_field( $_GET['my_newsportal-hide-notice'] );
			update_option( 'my_newsportal_admin_notice_' . $hide_notice, 1 );
		}
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		?>
		<div id="message" class="updated my_newsportal-message">
			<a class="my_newsportal-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'my_newsportal-hide-notice', 'welcome' ) ), 'my_newsportal_hide_notices_nonce', '_my_newsportal_notice_nonce' ) ); ?>"><?php esc_html_e( 'Dismiss', 'my_newsportal' ); ?></a>
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing my_newsportal! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'my_newsportal' ), '<a href="' . esc_url( admin_url( 'themes.php?page=my_newsportal-welcome' ) ) . '">', '</a>' ); ?></p>
			<p class="submit">
				<a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=my_newsportal-welcome' ) ); ?>"><?php esc_html_e( 'Get started with my_newsportal', 'my_newsportal' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		global $my_newsportal_version;
		$theme = wp_get_theme( get_template() );

		// Drop minor version if 0
		$major_version = substr( $my_newsportal_version, 0, 3 );
		?>
		<div class="my_newsportal-theme-info">
				<h1>
					<?php esc_html_e('About', 'my_newsportal'); ?>
					<?php echo $theme->display( 'Name' ); ?>
					<?php printf( '%s', $major_version ); ?>
				</h1>

			<div class="welcome-description-wrap">
				<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

				<div class="my_newsportal-screenshot">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
				</div>
			</div>
		</div>

		<p class="my_newsportal-actions">
			<a href="<?php echo esc_url( 'https://themegrill.com/themes/my_newsportal/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'my_newsportal' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'my_newsportal_pro_theme_url', 'https://demo.themegrill.com/my_newsportal/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'my_newsportal' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'my_newsportal_pro_theme_url', 'https://themegrill.com/themes/my_newsportal-pro/' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'my_newsportal' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'my_newsportal_pro_theme_url', 'https://wordpress.org/support/theme/my_newsportal/reviews/?filter=5' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'my_newsportal' ); ?></a>
		</p>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'my_newsportal-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'my_newsportal-welcome' ), 'themes.php' ) ) ); ?>">
				<?php echo $theme->display( 'Name' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'my_newsportal-welcome', 'tab' => 'supported_plugins' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Supported Plugins', 'my_newsportal' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'my_newsportal-welcome', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Free Vs Pro', 'my_newsportal' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'my_newsportal-welcome', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Changelog', 'my_newsportal' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}

		// Fallback to about screen.
		return $this->about_screen();
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<div class="changelog point-releases">
				<div class="under-the-hood two-col">
               <div class="col">
                  <h3><?php esc_html_e( 'Import Demo', 'my_newsportal' ); ?></h3>
                  <p><?php esc_html_e( 'Needs ThemeGrill Demo Importer plugin.', 'my_newsportal' ) ?></p>
                  <p><a href="<?php echo esc_url( network_admin_url( 'plugin-install.php?tab=search&type=term&s=themegrill-demo-importer' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install', 'my_newsportal' ); ?></a></p>
               </div>

					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'my_newsportal' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'my_newsportal' ) ?></p>
						<p><a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'my_newsportal' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Documentation', 'my_newsportal' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'my_newsportal' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themegrill.com/theme-instruction/my_newsportal/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Documentation', 'my_newsportal' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'my_newsportal' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'my_newsportal' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themegrill.com/support-forum/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support', 'my_newsportal' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Need more features?', 'my_newsportal' ); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'my_newsportal' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themegrill.com/themes/my_newsportal-pro/' ); ?>" class="button button-secondary"><?php esc_html_e( 'View PRO version', 'my_newsportal' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got sales related question?', 'my_newsportal' ); ?></h3>
						<p><?php esc_html_e( 'Please send it via our sales contact page.', 'my_newsportal' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themegrill.com/contact/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Contact Page', 'my_newsportal' ); ?></a></p>
					</div>

					<div class="col">
						<h3>
							<?php
							esc_html_e( 'Translate', 'my_newsportal' );
							echo ' ' . $theme->display( 'Name' );
							?>
						</h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'my_newsportal' ) ?></p>
						<p>
							<a href="<?php echo esc_url( 'https://translate.wordpress.org/projects/wp-themes/my_newsportal' ); ?>" class="button button-secondary">
								<?php
								esc_html_e( 'Translate', 'my_newsportal' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</a>
						</p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard my_newsportal">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'my_newsportal' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'my_newsportal' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'my_newsportal' ) : esc_html_e( 'Go to Dashboard', 'my_newsportal' ); ?></a>
			</div>
		</div>
		<?php
	}

		/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		global $wp_filesystem;

		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'View changelog below:', 'my_newsportal' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'my_newsportal_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
		<?php
	}

	/**
	 * Parse changelog from readme file.
	 * @param  string $content
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}


	/**
	 * Output the supported plugins screen.
	 */
	public function supported_plugins_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'my_newsportal' ); ?></p>
			<ol>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/social-icons/'); ?>" target="_blank"><?php esc_html_e('Social Icons', 'my_newsportal'); ?></a>
					<?php esc_html_e(' by ThemeGrill', 'my_newsportal'); ?>
				</li>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/easy-social-sharing/'); ?>" target="_blank"><?php esc_html_e('Easy Social Sharing', 'my_newsportal' ); ?></a>
					<?php esc_html_e(' by ThemeGrill', 'my_newsportal'); ?>
				</li>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/contact-form-7/'); ?>" target="_blank"><?php esc_html_e('Contact Form 7', 'my_newsportal'); ?></a></li>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/wp-pagenavi/'); ?>" target="_blank"><?php esc_html_e('WP-PageNavi', 'my_newsportal'); ?></a></li>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/woocommerce/'); ?>" target="_blank"><?php esc_html_e('WooCommerce', 'my_newsportal'); ?></a></li>
				<li>
					<a href="<?php echo esc_url('https://wordpress.org/plugins/polylang/'); ?>" target="_blank"><?php esc_html_e('Polylang', 'my_newsportal'); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'my_newsportal'); ?>
				</li>
				<li>
					<a href="<?php echo esc_url('https://wpml.org/'); ?>" target="_blank"><?php esc_html_e('WPML', 'my_newsportal'); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'my_newsportal'); ?>
				</li>
			</ol>

		</div>
		<?php
	}

	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'my_newsportal' ); ?></p>

			<table>
				<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e('Features', 'my_newsportal'); ?></h3></th>
						<th><h3><?php esc_html_e('my_newsportal', 'my_newsportal'); ?></h3></th>
						<th><h3><?php esc_html_e('my_newsportal Pro', 'my_newsportal'); ?></h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h3><?php esc_html_e('Support', 'my_newsportal'); ?></h3></td>
						<td><?php esc_html_e('Forum', 'my_newsportal'); ?></td>
						<td><?php esc_html_e('Forum + Emails/Support Ticket', 'my_newsportal'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Color Options', 'my_newsportal'); ?></h3></td>
						<td><?php esc_html_e('1', 'my_newsportal'); ?></td>
						<td><?php esc_html_e('22', 'my_newsportal'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Primary color option', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Font Size Options', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Google Fonts Options', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e('600+', 'my_newsportal'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Custom Widgets', 'my_newsportal'); ?></h3></td>
						<td><?php esc_html_e('7', 'my_newsportal'); ?></td>
						<td><?php esc_html_e('16', 'my_newsportal'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Social Icons', 'my_newsportal'); ?></h3></td>
						<td><?php esc_html_e('6', 'my_newsportal'); ?></td>
						<td><?php esc_html_e('18 + 6 Custom', 'my_newsportal'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Social Sharing', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Custom Menu', 'my_newsportal'); ?></h3></td>
						<td><?php esc_html_e('1', 'my_newsportal'); ?></td>
						<td><?php esc_html_e('2', 'my_newsportal'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Footer Sidebar', 'my_newsportal'); ?></h3></td>
						<td><?php esc_html_e('4', 'my_newsportal'); ?></td>
						<td><?php esc_html_e('7', 'my_newsportal'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Site Layout Option', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Options in Breaking News', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Unique Post System', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Change Read More Text', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Related Posts', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Author Biography', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Author Biography with Social Icons', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Footer Copyright Editor', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: 125x125 Advertisement', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: 300x250 Advertisement', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: 728x90 Advertisement', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Category Slider', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Highlighted Posts', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Random Posts Widget', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Tabbed Widget', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Videos', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 1)', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 2)', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 3)', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 4)', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 5)', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 6)', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 7)', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Category Color Options', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WPML Compatible', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Polylang Compatible', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WooCommerce Compatible', 'my_newsportal'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'my_newsportal_pro_theme_url', 'https://themegrill.com/themes/my_newsportal-pro/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Pro', 'my_newsportal' ); ?></a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
		<?php
	}
}

endif;

return new my_newsportal_Admin();
