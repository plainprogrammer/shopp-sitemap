<?php if ( ! defined( 'ABSPATH' ) ) die( "Can't load this file directly" ); ?>

<div class="wrap">
	<h2>Shopp Sitemap Settings</h2>
	<?php if ( $updated ): ?>
		<div id="message" class="updated fade">
			<p>
				Settings <strong>updated</strong> and cache <strong>rebuilt</strong>.
			</p>
		</div>
	<?php endif ?>

	<p>This plugin adds categories and products from your Shopp storefront to an XML sitemap created by the Google XML Sitemaps plugin. When enabled, each time a Shopp category or product is created or modified the sitemap will be rebuilt. If your sitemap is missing new products or categories, you can reset the Shopp Sitemap cache by clicking "Save Changes" below. The cache will be rebuilt and your sitemap will be updated.</p>
	<form method="post" action="options.php">
	  <?php wp_nonce_field('update-options'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="shoppsitemap_index_cat">Include Shopp Categories</label></th>
				<td>
					<select id="shoppsitemap_index_cat" name="shoppsitemap_index_cat">
						<option <?php if ( get_option( 'shoppsitemap_index_cat', 1 ) ) echo 'selected="selected"'; ?> value="1">Yes</option>
						<option <?php if ( ! get_option( 'shoppsitemap_index_cat', 1 ) ) echo 'selected="selected"'; ?> value="0">No</option>
					</select><br />
					<select id="shoppsitemap_cat_cf" name="shoppsitemap_cat_cf">
						<option <?php if ( get_option( 'shoppsitemap_cat_cf', 'weekly' ) == 'always' ) echo 'selected="selected"'; ?> value="always">Always</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_cf', 'weekly' ) == 'hourly' ) echo 'selected="selected"'; ?> value="hourly">Hourly</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_cf', 'weekly' ) == 'daily' ) echo 'selected="selected"'; ?> value="daily">Daily</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_cf', 'weekly' ) == 'weekly' ) echo 'selected="selected"'; ?> value="weekly">Weekly</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_cf', 'weekly' ) == 'monthly') echo 'selected="selected"'; ?> value="monthly">Monthly</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_cf', 'weekly' ) == 'yearly' ) echo 'selected="selected"'; ?> value="yearly">Yearly</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_cf', 'weekly' ) == 'never' ) echo 'selected="selected"'; ?> value="never">Never</option>
					</select><small style="margin-left:10px;">Change Frequency</small><br />
					<select id="shoppsitemap_cat_p" name="shoppsitemap_cat_p">
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.0' ) echo 'selected="selected"'; ?>  value="0.0">0.0</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.1' ) echo 'selected="selected"'; ?>  value="0.1">0.1</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.2' ) echo 'selected="selected"'; ?>  value="0.2">0.2</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.3' ) echo 'selected="selected"'; ?>  value="0.3">0.3</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.4' ) echo 'selected="selected"'; ?>  value="0.4">0.4</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.5' ) echo 'selected="selected"'; ?>  value="0.5">0.5</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.6' ) echo 'selected="selected"'; ?>  value="0.6">0.6</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.7' ) echo 'selected="selected"'; ?>  value="0.7">0.7</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.8' ) echo 'selected="selected"'; ?>  value="0.8">0.8</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '0.9' ) echo 'selected="selected"'; ?>  value="0.9">0.9</option>
						<option <?php if ( get_option( 'shoppsitemap_cat_p', '0.3' ) == '1.0' ) echo 'selected="selected"'; ?>  value="1.0">1.0</option>
					</select><small style="margin-left:36px;">Priority</small>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><label for="shoppsitemap_index_prod">Include Shopp Products</label></th>
				<td>
					<select id="shoppsitemap_index_prod" name="shoppsitemap_index_prod">
						<option <?php if ( get_option( 'shoppsitemap_index_prod', 1 ) ) echo 'selected="selected"'; ?> value="1">Yes</option>
						<option <?php if ( ! get_option( 'shoppsitemap_index_prod', 1 ) ) echo 'selected="selected"'; ?> value="0">No</option>
					</select><br />
					<select id="shoppsitemap_prod_cf" name="shoppsitemap_prod_cf">
						<option <?php if ( get_option( 'shoppsitemap_prod_cf', 'monthly' ) == 'always' ) echo 'selected="selected"'; ?> value="always">Always</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_cf', 'monthly' ) == 'hourly' ) echo 'selected="selected"'; ?> value="hourly">Hourly</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_cf', 'monthly' ) == 'daily' ) echo 'selected="selected"'; ?> value="daily">Daily</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_cf', 'monthly' ) == 'weekly' ) echo 'selected="selected"'; ?> value="weekly">Weekly</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_cf', 'monthly' ) == 'monthly') echo 'selected="selected"'; ?> value="monthly">Monthly</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_cf', 'monthly' ) == 'yearly' ) echo 'selected="selected"'; ?> value="yearly">Yearly</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_cf', 'monthly' ) == 'never' ) echo 'selected="selected"'; ?> value="never">Never</option>
					</select><small style="margin-left:10px;">Change Frequency</small><br />
					<select id="shoppsitemap_prod_p" name="shoppsitemap_prod_p">
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.0' ) echo 'selected="selected"'; ?>  value="0.0">0.0</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.1' ) echo 'selected="selected"'; ?>  value="0.1">0.1</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.2' ) echo 'selected="selected"'; ?>  value="0.2">0.2</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.3' ) echo 'selected="selected"'; ?>  value="0.3">0.3</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.4' ) echo 'selected="selected"'; ?>  value="0.4">0.4</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.5' ) echo 'selected="selected"'; ?>  value="0.5">0.5</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.6' ) echo 'selected="selected"'; ?>  value="0.6">0.6</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.7' ) echo 'selected="selected"'; ?>  value="0.7">0.7</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.8' ) echo 'selected="selected"'; ?>  value="0.8">0.8</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '0.9' ) echo 'selected="selected"'; ?>  value="0.9">0.9</option>
						<option <?php if ( get_option( 'shoppsitemap_prod_p', '0.6' ) == '1.0' ) echo 'selected="selected"'; ?>  value="1.0">1.0</option>
					</select><small style="margin-left:36px;">Priority</small>
				</td>
			</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			<?php settings_fields( 'shoppsitemap-options' ); ?>
		</p>
	</form>
</div>