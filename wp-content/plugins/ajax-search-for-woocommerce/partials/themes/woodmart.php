<?php
// Exit if accessed directly
if ( ! defined( 'DGWT_WCAS_FILE' ) ) {
	exit;
}

add_action( 'wp_footer', function () {
	echo '<div id="wcas-desktop-search-form" style="display: none;"><div class="wd-header-search-form">' . do_shortcode( '[fibosearch]' ) . '</div></div>';
	echo '<div id="wcas-desktop-search-icon" style="display: none;"><div class="wd-tools-element">' . do_shortcode( '[fibosearch layout="icon"]' ) . '</div></div>';
	echo '<div id="wcas-mobile-search-form" style="display: none;"><div class="wd-search-form wd-header-search-form-mobile">' . do_shortcode( '[fibosearch]' ) . '</div></div>';
	echo '<div id="wcas-mobile-search-nav" style="display: none;">' . do_shortcode( '[fibosearch]' ) . '</div>';
	?>
	<script>
		var desktopSearchForm = document.querySelector('.whb-main-header .wd-header-search-form');
		if (desktopSearchForm !== null) {
			desktopSearchForm.replaceWith(document.querySelector('#wcas-desktop-search-form > div'));
		}
		document.querySelector('#wcas-desktop-search-form').remove();

		var desktopSearchIcon = document.querySelector('.whb-main-header .wd-header-search');
		if (desktopSearchIcon !== null) {
			desktopSearchIcon.replaceWith(document.querySelector('#wcas-desktop-search-icon > div'));
		}
		document.querySelector('#wcas-desktop-search-icon').remove();

		var mobileSearchForm = document.querySelector('.whb-main-header .wd-header-search-form-mobile');
		if (mobileSearchForm !== null) {
			mobileSearchForm.replaceWith(document.querySelector('#wcas-mobile-search-form > div'));
		}
		document.querySelector('#wcas-mobile-search-form').remove();

		var mobileSearch = document.querySelector('.mobile-nav .wd-search-form');
		if (mobileSearch !== null) {
			mobileSearch.replaceWith(document.querySelector('#wcas-mobile-search-nav > div'));
		}
		document.querySelector('#wcas-mobile-search-nav').remove();
	</script>

	<style>
		.dgwt-wcas-ico-magnifier, .dgwt-wcas-ico-magnifier-handler {
			max-width: none;
			fill: var(--wd-header-el-color);
		}

		.dgwt-wcas-ico-magnifier:hover, .dgwt-wcas-ico-magnifier-handler:hover {
			fill: var(--wd-header-el-color-hover);
		}

		.whb-main-header .wd-header-search-form-mobile .dgwt-wcas-style-pirx .dgwt-wcas-sf-wrapp {
			padding: 0;
		}

		.whb-main-header .wd-header-search-form-mobile .dgwt-wcas-style-pirx .dgwt-wcas-sf-wrapp button.dgwt-wcas-search-submit {
			margin-top: -10px;
			margin-left: -10px;
		}
	</style>
	<?php
} );
