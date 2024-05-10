<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="dgwt-wcas-analytics-module-critical">
	<h3><?php _e( 'Critical searches without result', 'ajax-search-for-woocommerce' ); ?></h3>
	<?php if ( ! empty( $vars['critical-searches'] ) ): ?>
		<p class="dgwt-wcas-analytics-subtitle">
			<?php printf( _n( 'The FiboSearch analyzer found <b>1 critical search phrase</b>.', 'The FiboSearch analyzer found <b>%d critical search phrases</b>.', $vars['critical-searches-total'], 'ajax-search-for-woocommerce' ), $vars['critical-searches-total'] );
			echo ' ';
			printf( _n( 'These phrases have been typed by users over the last 1 day.', 'These phrases have been typed by users over the last %d days.', $vars['days'], 'ajax-search-for-woocommerce' ), $vars['days'] );
			echo ' ';
			_e( "These phrases don`t return any search results. It's time to fix it.", 'ajax-search-for-woocommerce' );
			?>
		</p>
		<div class="dgwt-wcas-analytics-module-critical-body">
			<div>
				<table class="widefat fixed dgwt-wcas-analytics-table">
					<thead>
					<tr>
						<th>#</th>
						<th><?php _e( 'Phrase', 'ajax-search-for-woocommerce' ); ?></th>
						<th><?php _e( 'Repetitions', 'ajax-search-for-woocommerce' ); ?></th>
						<th><?php _e( "Check if it's been solved", 'ajax-search-for-woocommerce' ); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php
					$i = 1;
					foreach ( $vars['critical-searches'] as $row ) {
						require DGWT_WCAS_DIR . 'partials/admin/stats/critical-searches-row.php';
						$i ++;
					}

					if ( $vars['critical-searches-more'] > 0 ): ?>
						<tr class="dgwt-wcas-analytics-load-more-row">
							<td colspan="4">
								<div>
						<span class="js-dgwt-wcas-critical-searches-load-more">
							<span><?php printf( _n( 'load another %d phrase', 'load another %d phrases', $vars['critical-searches-more'], 'ajax-search-for-woocommerce' ), $vars['critical-searches-more'] ); ?></span>
							<span class="dashicons dashicons-arrow-down-alt2"></span>
						</span>
								</div>
							</td>

						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				<?php
				if ( $vars['critical-searches-total'] > 0 ) {
					printf( '<a class="js-dgwt-wcas-analytics-export-csv" data-context="" href="#">%s</a>', __( 'Export CSV', 'ajax-search-for-woocommerce' ) ) . '<span class="dgwt-wcas-ajax-loader"></span>';
				}
				?>
			</div>
			<div class="dgwt-wcas-analytics-module-critical-info">
				<h4><?php _e( 'How to fix it?', 'ajax-search-for-woocommerce' ); ?></h4>
				<div>
					<p><?php _e( 'There are several ways to solve these problems. Every phrase may require a different approach. See what methods you could use:', 'ajax-search-for-woocommerce' ); ?></p>
					<ol>
						<li><p><?php _e( "<b>Adding the phrase to the product name</b> - just add the phrase to the product name, description, SKU, custom field, tag or anything else that's in your current search scope", 'ajax-search-for-woocommerce' ); ?></p></li>
						<li><p><?php printf( __( '<b>Synonyms</b> - if the phrase is an alternate version of any other words, add it as a synonym. Learn more about <a href="%s" target="_blank">the synonyms feature.', 'ajax-search-for-woocommerce' ), $vars['links']['synonyms'] ); ?></a></p></li>
						<li>
							<p><?php printf( __( '<b>Varied naming convention</b> - this issue occurs when users may type a phrase in several different way – eg. you have SKU "CB-978-8-7290", but users might type it in a different way: "CB978 8 7290", "CB/978/8/7290", "CB97887290" and so on. To solve such problems, contact our <a href="%s" target="_blank">technical support</a>, because the solution may be different for each case.',
									'ajax-search-for-woocommerce' ), $vars['links']['support'] ); ?></p></li>
					</ol>
				</div>
			</div>
		</div>


	<?php else: ?>
		<p class="dgwt-wcas-analytics-subtitle"><?php printf( __( "Fantastic! The FiboSearch analyzer hasn't found any critical search phrases for the last %d days.", 'ajax-search-for-woocommerce' ), $vars['days'] ); ?></p>
	<?php endif; ?>


</div>

<?php if ( ! defined( 'DGWT_WCAS_ANALYTICS_ONLY_CRITICAL' ) || ! DGWT_WCAS_ANALYTICS_ONLY_CRITICAL ): ?>
	<div class="dgwt-wcas-analytics-module-tiles">
		<h3><?php printf( __( 'Searches stats (last %d days)', 'ajax-search-for-woocommerce' ), $vars['days'] ); ?></h3>

		<div class="dgwt-wcas-analytics-tiles">
			<div class="dgwt-wcas-analytics-tile">
				<div class="dgwt-wcas-analytics-tile__values">
					<span><?php _e( 'Total searches', 'ajax-search-for-woocommerce' ); ?></span>
					<span><?php _e( 'autocomplete', 'ajax-search-for-woocommerce' ); ?></span>
					<span><?php echo esc_html( $vars['autocomplete']['total-results'] ); ?></span>
				</div>
				<div class="dgwt-wcas-analytics-tile__icon">
					<?php echo \DgoraWcas\Helpers::getIcon( 'magnifier-pirx' ) ?>
				</div>
			</div>

			<div class="dgwt-wcas-analytics-tile">
				<div class="dgwt-wcas-analytics-tile__values">
					<span><?php _e( 'Total searches', 'ajax-search-for-woocommerce' ); ?></span>
					<span><?php _e( 'search results page', 'ajax-search-for-woocommerce' ); ?></span>
					<span><?php echo esc_html( $vars['search-page']['total-results'] ); ?></span>
				</div>
				<div class="dgwt-wcas-analytics-tile__icon">
					<?php echo \DgoraWcas\Helpers::getIcon( 'magnifier-pirx' ) ?>
				</div>
			</div>

			<div class="dgwt-wcas-analytics-tile">
				<div class="dgwt-wcas-analytics-tile__values">
					<span><?php _e( 'Searches', 'ajax-search-for-woocommerce' ); ?></span>
					<span><?php _e( 'returning results', 'ajax-search-for-woocommerce' ); ?></span>
					<span><?php echo esc_html( $vars['returning-results-percent'] ); ?>%</span>
				</div>
				<div class="dgwt-wcas-analytics-tile__icon">
					<?php
					if ( ! empty( $vars['returning-results-percent'] ) ) {
						if ( $vars['returning-results-percent-satisfying'] ) {
							echo \DgoraWcas\Helpers::getIcon( 'face-smile', 'dgwt-wcas-stats-icon-smile' );
						} else {
							echo \DgoraWcas\Helpers::getIcon( 'face-sad', 'dgwt-wcas-stats-icon-sad' );
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<br/>

	<div class="dgwt-wcas-analytics-module-tables">
		<div class="dgwt-wcas-analytics-module-table">
			<h3><?php _e( 'Top searches - autocomplete', 'ajax-search-for-woocommerce' ); ?></h3>
			<p class="dgwt-wcas-analytics-subtitle"><?php _e( 'The list of phrases with results is displayed to users as a drop down list with auto suggestions.', 'ajax-search-for-woocommerce' ); ?></p>

			<table class="widefat fixed dgwt-wcas-analytics-table">
				<thead>
				<tr>
					<th>#</th>
					<th><?php _e( 'Phrase', 'ajax-search-for-woocommerce' ); ?></th>
					<th><?php _e( 'Repetitions', 'ajax-search-for-woocommerce' ); ?></th>
				</tr>

				</thead>
				<tbody>
				<?php if ( ! empty( $vars['autocomplete']['with-results'] ) ): ?>

					<?php
					$i = 1;
					foreach ( $vars['autocomplete']['with-results'] as $row ) {
						require DGWT_WCAS_DIR . 'partials/admin/stats/ac-searches-row.php';
						$i ++;
					}

					if ( $vars['autocomplete']['total-with-results-uniq'] > count( $vars['autocomplete']['with-results'] ) ): ?>
						<tr class="dgwt-wcas-analytics-load-more-row">
							<td colspan="3">
								<div>
						<span class="js-dgwt-wcas-autocomplete-with-results-load-more">
							<span><?php _e( 'show top 100 phrases', 'ajax-search-for-woocommerce' ); ?></span>
							<span class="dashicons dashicons-arrow-down-alt2"></span>
						</span>
								</div>
							</td>
						</tr>
					<?php endif; ?>

				<?php else: ?>
					<tr>
						<td colspan="3">
							<?php _e( '0 searches with results', 'ajax-search-for-woocommerce' ); ?>
						</td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
			<?php
			if ( ! empty( $vars['autocomplete']['with-results'] ) ) {
				printf( '<a class="js-dgwt-wcas-analytics-export-csv" data-context="autocomplete" href="#">%s</a>', __( 'Export CSV', 'ajax-search-for-woocommerce' ) ) . '<span class="dgwt-wcas-ajax-loader"></span>';
			}
			?>

		</div>
		<div class="dgwt-wcas-analytics-module-table">

			<h3><?php _e( 'Top searches - WooCommerce search results page', 'ajax-search-for-woocommerce' ); ?></h3>
			<p class="dgwt-wcas-analytics-subtitle"><?php _e( 'Here is the list of phrases that were typed by users who followed the pattern: type the phrase into the bar → clicked “See all results” or just hit enter/return (for Mac users)', 'ajax-search-for-woocommerce' ); ?></p>


			<table class="widefat fixed dgwt-wcas-analytics-table">
				<thead>
				<tr>
					<th>#</th>
					<th><?php _e( 'Phrase', 'ajax-search-for-woocommerce' ); ?></th>
					<th><?php _e( 'Repetitions', 'ajax-search-for-woocommerce' ); ?></th>
				</tr>

				</thead>
				<tbody>
				<?php if ( ! empty( $vars['search-page']['with-results'] ) ): ?>

					<?php
					$i = 1;
					foreach ( $vars['search-page']['with-results'] as $row ) {
						require DGWT_WCAS_DIR . 'partials/admin/stats/sp-searches-row.php';
						$i ++;
					}

					if ( $vars['search-page']['total-with-results-uniq'] > count( $vars['search-page']['with-results'] ) ): ?>
						<tr class="dgwt-wcas-analytics-load-more-row">
							<td colspan="3">
								<div>
						<span class="js-dgwt-wcas-search-page-with-results-load-more">
							<span><?php _e( 'show top 100 phrases', 'ajax-search-for-woocommerce' ); ?></span>
							<span class="dashicons dashicons-arrow-down-alt2"></span>
						</span>
								</div>
							</td>
						</tr>
					<?php endif; ?>

				<?php else: ?>
					<tr>
						<td colspan="3">
							<?php _e( '0 searches with results', 'ajax-search-for-woocommerce' ); ?>
						</td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
			<?php
			if ( ! empty( $vars['search-page']['with-results'] ) ) {
				printf( '<a class="js-dgwt-wcas-analytics-export-csv" data-context="search-results-page" href="#">%s</a>', __( 'Export CSV', 'ajax-search-for-woocommerce' ) ) . '<span class="dgwt-wcas-ajax-loader"></span>';
			}
			?>
		</div>
	</div>

<?php endif; ?>


<div class="dgwt-wcas-analytics-module-reset">
	<h3><?php _e( 'Maintenance', 'ajax-search-for-woocommerce' ) ?></h3>
	<?php if ( defined( 'DGWT_WCAS_ANALYTICS_ONLY_CRITICAL' ) && DGWT_WCAS_ANALYTICS_ONLY_CRITICAL ): ?>
		<p class="dgwt-wcas-analytics-subtitle">
			<span class="dgwt-wcas-analytics-red-color"><b><?php _e( 'Warning:', 'ajax-search-for-woocommerce' ); ?></b> </span>
			<?php
			/* Translators: %s PHP constant name. */
			printf( __( "You have defined %s constant and it's set to <code>true</code>. It means only critical searches will be stored in the database. Other modules than Critical Searches are not visible in this mode.", 'ajax-search-for-woocommerce' ), '<code>DGWT_WCAS_ANALYTICS_ONLY_CRITICAL</code>' ) ?>
		</p>
	<?php endif; ?>
	<p class="dgwt-wcas-analytics-subtitle">
		<?php
		$reset = sprintf( '<a class="js-dgwt-wcas-analytics-reset" href="#">%s</a>', __( 'reset your stats', 'ajax-search-for-woocommerce' ) ) . '<span class="dgwt-wcas-ajax-loader"></span>';
		$size  = $vars['autocomplete']['total-results'] > 0 ? $vars['table-info']['data'] + $vars['table-info']['index'] : 0;
		?>
		<?php printf( _x( 'The stats older than %d days are removed from your database on a daily basis. Now you have %d records in the DB that weigh %.2fMB. You can %s now and start collecting them all over again.', 'The last placeholder is a button with text "reset your stats"', 'ajax-search-for-woocommerce' ),
			$vars['days'], esc_html( $vars['autocomplete']['total-results'] ), $size, $reset ); ?>
	</p>
</div>
