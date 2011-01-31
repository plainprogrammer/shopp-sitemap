<?php
/*
Plugin Name: Shopp Sitemap
Plugin URI: http://shopptools.com
Description: Shopp E-Commerce & Google XML Sitemap Integration
Version: 0.9
Author: Palms Development
Author URI: http://palmsdevelopment.com
*/

if ( ! defined( 'ABSPATH' ) )
	die( "Can't load this file directly" );

class ShoppSitemap
{
  private $db;
  private $products_table;
  private $categories_table;
	private $shopp;
	
	function __construct() {
		global $Shopp;
		
		$this->db = DB::get();
		$this->products_table = DatabaseObject::tablename(Product::$table);
		$this->categories_table = DatabaseObject::tablename(Category::$table);
		
		$this->shopp =& $Shopp;

		//add_action( 'admin_menu', array( &$this, 'action_admin_menu' ) );
		//add_action( 'admin_init', array( &$this, 'action_register_settings' ) );
		add_action( 'admin_notices', array( &$this, 'action_admin_notices' ) );

		if ( get_option( 'shoppsitemap_index_cat', 1 ) )
			add_action( 'shopp_category_saved', array( &$this, 'action_category_saved' ) );
			
		if ( get_option( 'shoppsitemap_index_prod', 1 ) )
			add_action( 'shopp_product_saved', array( &$this, 'action_product_saved' ) );
		
		add_action( 'sm_buildmap', array( &$this, 'action_add_urls' ) );
			
		register_activation_hook( __FILE__, array( &$this, 'action_activate' ) );
		
		add_action('shopp_init', array(&$this, 'action_register_settings' ) );
		add_action('shopp_init', array(&$this, 'init'));
	}
	
	public function init() {
    add_action('admin_menu', array(&$this, 'add_menu'));
  }
     
  public function add_menu() {
    global $Shopp;
    
    add_submenu_page(
      $Shopp->Flow->Admin->MainMenu,
      __('Shopp Sitemap', 'shoppsitemap'),
      __('Shopp Sitemap','shoppsitemap'),
      defined('SHOPP_USERLEVEL') ? SHOPP_USERLEVEL : 'manage_options',
      'shoppsitemap',
      array($this, 'admin_settings' ));
  }
	
	function action_activate() {
		if ( is_plugin_active( 'shopp/Shopp.php' ) && is_plugin_active( 'google-sitemap-generator/sitemap.php' ) ) {
			$this->rebuild_url_cache();
		}
	}
	
	function action_add_urls() {
		$generatorObject = &GoogleSitemapGenerator::GetInstance();
		
		if( $generatorObject != null ) {
		  $categories = $this->db->query("SELECT * FROM $this->categories_table");
		  $frequency = get_option( 'shoppsitemap_cat_cf' );
			$priority = get_option( 'shoppsitemap_cat_p' );
		  
		  foreach ($categories as $category) {
		    if ( ! empty( $category->slug ) ) {
          $permalink = shoppurl(SHOPP_PRETTYURLS?$category->slug:array('shopp_cid'=>$category->id));
          $timestamp = $generatorObject->GetTimestampFromMySql($category->modified);
        
          $generatorObject->AddUrl($permalink, $timestamp, $frequency, $priority);
        }
		  }
      
      $products = $this->db->query("SELECT * FROM $this->products_table WHERE status='publish'", AS_ARRAY);
      $frequency = get_option( 'shoppsitemap_prod_cf' );
      $priority = get_option( 'shoppsitemap_prod_p' );
      
      foreach ($products as $product) {
        if ( ! empty( $product->slug ) ) {
          $permalink = shoppurl(SHOPP_PRETTYURLS?$product->slug:array('shopp_pid'=>$product->id));
          $timestamp = $generatorObject->GetTimestampFromMySql($product->modified);
        
          $generatorObject->AddUrl($permalink, $timestamp, $frequency, $priority);
        }
      }
		}
	}
	
  // function action_admin_menu() {
  //  add_submenu_page( 'plugins.php', 'Shopp Sitemap', 'Shopp Sitemap', SHOPP_USERLEVEL, 'shopp-sitemap-xml', array( $this, 'admin_settings' ) );
  // }
	
	function action_admin_notices() {
		$errors = array();
		if ( ! is_plugin_active( 'google-sitemap-generator/sitemap.php' ) )
			$errors[] = 'Shopp Sitemap requires that the <a href="http://www.arnebrachhold.de/redir/sitemap-home/">Google XML Sitemaps</a> plugin be active.  Please install the plugin to continue.';
		
		if ( ! is_plugin_active( 'shopp/Shopp.php' ) )
			$errors[] = 'Shopp Sitemap requires that the <a href="http://www.shopplugin.net/">Shopp</a> plugin be active.  Please install the plugin to continue.';
			
		foreach ( $errors as $error ) {
			echo "<div class='error'><p>{$error}</p></div>";
		}
	}
	
	function action_product_saved( $product ) {
		$prod_urls = get_option( 'shoppsitemap_products' );
		$permalink = $this->shopp->shopuri . $product->slug;
		if ( ! isset( $prod_urls[$product->id] ) || $prod_urls[$product->id] != $permalink ) {
			$prod_urls[$product->id] = $permalink;
			update_option( 'shoppsitemap_products', $prod_urls );
			do_action( "sm_rebuild" );
		}
	}
	
	function action_category_saved( $category ) {
		$cat_urls = get_option( 'shoppsitemap_categories' );
		$permalink = trailingslashit( $this->shopp->link( 'catalog' ) )."category/{$category->slug}";
		if ( ! isset( $cat_urls[$category->id] ) || $cat_urls[$category->id] != $permalink ) {
			$cat_urls[$category->id] = $permalink;
			update_option( 'shoppsitemap_categories', $cat_urls );
			do_action( "sm_rebuild" );
		}
	}
	
	function action_register_settings() {
		// register_setting( 'shoppsitemap-options', 'shoppsitemap_index_cat' );
		//    register_setting( 'shoppsitemap-options', 'shoppsitemap_index_prod' );
		//    register_setting( 'shoppsitemap-options', 'shoppsitemap_cat_cf' );
		//    register_setting( 'shoppsitemap-options', 'shoppsitemap_cat_p' );
		//    register_setting( 'shoppsitemap-options', 'shoppsitemap_prod_cf' );
		//    register_setting( 'shoppsitemap-options', 'shoppsitemap_prod_p' );
	}
	
	function admin_settings() {
		$updated = false;
		
		if ( $_GET['updated'] == 'true' ) {
			$this->rebuild_url_cache();
			$updated = true;
		}
		
		include( 'shoppsitemap_admin.php' );
	}
	
	function rebuild_url_cache() {
		$cat_urls = array();
		$prod_urls = array();
		
		if ( get_option( 'shoppsitemap_index_cat', 1 ) ) {
			$catalog = new Catalog();
			$catalog->outofstock = true;
			$results = $catalog->load_categories(false,false,true);
			foreach ( $results as $category ) {
				if ( ! empty( $category->slug ) ) {
					$permalink = trailingslashit( $this->shopp->link( 'catalog' ) )."category/{$category->slug}";
					$cat_urls[$category->id] = $permalink;
				}
			}
			update_option( 'shoppsitemap_categories', $cat_urls );
		}
		
		if ( get_option( 'shoppsitemap_index_prod', 1 ) ) {
			// create a dummy category, and load products from all categories
			$category = new Category();
			$catalogtable = DatabaseObject::tablename(Catalog::$table);
			$category->load_products();

			foreach ( $category->products as $product ) {
				if ( ! empty( $product->slug ) ) {
					$permalink = $this->shopp->shopuri . $product->slug;
					$prod_urls[$product->id] = $permalink;
				}
			}
			
			update_option( 'shoppsitemap_products', $prod_urls );
		}
		
		do_action( 'sm_rebuild' );
	}
}

function shopp_sitemap_init_event() {
}

function load_shopp_sitemap() {
	global $shopp_sitemap;

	$shopp_sitemap = new ShoppSitemap();
}

add_action('init', 'shopp_sitemap_init_event');
add_action('plugins_loaded', 'load_shopp_sitemap');
// eof
