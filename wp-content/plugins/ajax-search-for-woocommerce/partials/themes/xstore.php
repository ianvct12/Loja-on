<?php
// Exit if accessed directly
if ( ! defined( 'DGWT_WCAS_FILE' ) ) {
	exit;
}

add_action( 'wp_head', function () {
	?>
	<style>
		.et_b_header-search > form {
			display: none;
		}
	</style>
	<?php
} );

add_action( 'wp_footer', function () {
	$search_type_desktop      = get_theme_mod( 'search_type_et-desktop', 'input' );
	$search_type_mobile       = get_theme_mod( 'search_type_et-mobile', 'icon' );

	if ( $search_type_desktop === 'input' ) {
		echo '<div id="wcas-desktop-search" style="display: none;">' . do_shortcode( '[fibosearch]' ) . '</div>';
		?>
		<script>
			var desktopSearch = document.querySelector('.header-wrapper .et_b_header-search > form');
			if (desktopSearch !== null) {
				desktopSearch.replaceWith(document.querySelector('#wcas-desktop-search > div'));
			}
			document.querySelector('#wcas-desktop-search').remove()
		</script>
		<style>
			.header-wrapper .dgwt-wcas-search-wrapp {
				max-width: none;
			}
		</style>
		<?php
	} elseif ( $search_type_desktop === 'icon' || $search_type_desktop === 'popup' ) {
		echo '<div id="wcas-desktop-search" style="display: none;">' . do_shortcode( '[fibosearch layout="icon"]' ) . '</div>';
		?>
		<script>
			var desktopSearch = document.querySelector('.header-wrapper .et_b_header-search > .et_b_search-icon');
			if (desktopSearch !== null) {
				desktopSearch.replaceWith(document.querySelector('#wcas-desktop-search > div'));
				<?php if ($search_type_desktop === 'popup') { ?>
				document.querySelector('.header-wrapper .et_b_header-search').classList.remove('search-full-width');
				<?php } ?>
			}
			document.querySelector('#wcas-desktop-search').remove();
		</script>
		<style>
			.header-wrapper .et_b_header-search .dgwt-wcas-ico-magnifier-handler {
				max-width: 18px;
				width: 1.5em !important;
				height: 1.5em !important;
			}
		</style>
		<?php
	}

	if ( $search_type_mobile === 'input' ) {
		echo '<div id="wcas-mobile-search" style="display: none;">' . do_shortcode( '[fibosearch]' ) . '</div>';
		?>
		<script>
			var mobileSearch = document.querySelector('.mobile-header-wrapper .et_b_header-search > form');
			if (mobileSearch !== null) {
				mobileSearch.replaceWith(document.querySelector('#wcas-mobile-search > div'));
			}
			document.querySelector('#wcas-mobile-search').remove();
		</script>
		<?php
	} elseif ( $search_type_mobile === 'icon' || $search_type_mobile === 'popup' ) {
		echo '<div id="wcas-mobile-search" style="display: none;">' . do_shortcode( '[fibosearch layout="icon"]' ) . '</div>';
		?>
		<script>
			var mobileSearch = document.querySelector('.mobile-header-wrapper .et_b_header-search > .et_b_search-icon');
			if (mobileSearch !== null) {
				mobileSearch.replaceWith(document.querySelector('#wcas-mobile-search > div'));
				<?php if ($search_type_mobile === 'popup') { ?>
				var mobileSearchWrappers = document.querySelectorAll('.mobile-header-wrapper .et_b_header-search');
				for (let i = 0; i < mobileSearchWrappers.length; ++i) {
					mobileSearchWrappers[i].classList.remove('search-full-width');
				}
				<?php } ?>
			}
			document.querySelector('#wcas-mobile-search').remove();
		</script>
		<style>
			.mobile-header-wrapper .dgwt-wcas-search-wrapp {
				max-width: 30px !important;
				min-width: 30px;
			}

			.mobile-header-wrapper .et_b_header-search .dgwt-wcas-ico-magnifier-handler {
				max-width: 18px;
				width: 1.5em !important;
				height: 1.5em !important;
			}

			.dgwt-wcas-search-wrapp {
				color: currentColor;
			}
		</style>
		<?php
	}
	?>
	<script>
		(function ($) {
			$('.et-mobile-panel-wrapper .et_b_mobile-panel-search').on('click', function () {
				var $searchHandler = $(document).find('.js-dgwt-wcas-enable-mobile-form');

				if ($searchHandler.length) {
					$searchHandler[0].click();
				}
			});
		})(jQuery);
	</script>
	<?php
} );

add_filter( 'dgwt/wcas/form/magnifier_ico', function ( $html, $class ) {
	if ( $class === 'dgwt-wcas-ico-magnifier-handler' ) {
		// Icon from theme.
		$html = '<span class="et_b-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24"><path d="M23.784 22.8l-6.168-6.144c1.584-1.848 2.448-4.176 2.448-6.576 0-5.52-4.488-10.032-10.032-10.032-5.52 0-10.008 4.488-10.008 10.008s4.488 10.032 10.032 10.032c2.424 0 4.728-0.864 6.576-2.472l6.168 6.144c0.144 0.144 0.312 0.216 0.48 0.216s0.336-0.072 0.456-0.192c0.144-0.12 0.216-0.288 0.24-0.48 0-0.192-0.072-0.384-0.192-0.504zM18.696 10.080c0 4.752-3.888 8.64-8.664 8.64-4.752 0-8.64-3.888-8.64-8.664 0-4.752 3.888-8.64 8.664-8.64s8.64 3.888 8.64 8.664z"></path></svg></span>';
	}

	return $html;
}, 10, 2 );
