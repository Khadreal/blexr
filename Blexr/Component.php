<?php
/**
 * Component namespace
*/
namespace Symphony\Blexr;


use DateTime;

class Component
{
	/** const */
	public const SHORTCODE = 'blexr-odd';

	/** const */
	public const API_KEY = 'd630cb5bb47507fd608fffc69897f54a';

	/** const */
	public const ENDPOINT = 'https://api.the-odds-api.com/v4/sports/';

	/**
	 *Endpoint */
	public const FILTER_ENDPOINT = 'blexr-odd-filter';

	/**
	 * Initialisation
	 * 
	 * @return void
	 */
	public function init() : void
	{
		$this->registerCallbacks();
	}

	/**
	 * Register callbacks
	 * 
	 * @return void
	 */
	public function registerCallbacks() : void
	{
		add_shortcode( self::SHORTCODE, [ $this, 'shortcode' ] );
        add_shortcode( 'blexr-calculator', [ $this, 'shortcodeCalculator' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'actionCheckScripts' ] );
		add_action( 'init', [ $this, 'registerFilterEndpoint' ] );
		add_filter( 'request', [ $this, 'filterOddFilterRequest' ] );
	}


	/**
     * Calculator shortcode
     * @param array $attributes
     *
     * @return string
	*/
	public function shortcodeCalculator( $attributes = [] ) : string
    {
        ob_start();

        $type = $attributes['type'] ?? 'all';
        include_once 'templates/calculator.php';

        return ob_get_clean();
    }

    /**
     * Odds table shortcode
     *
     * @param array $attributes
     *
     * @return string
     */
	public function shortcode( $attributes = [] ) : string
	{
		$data = $this->initialTableData();
		ob_start();

        $type = $attributes['type'] ?? 'all';
		include_once 'templates/calculator.php';

		return ob_get_clean();
	}

	/**
	 * Load script. Check if shortcode is present before loading scripts
	 */
	public function actionCheckScripts()
	{
		global $post;

		// Check if shortcode is loaded before css/js is loaded.
		if(
		    is_a( $post, 'WP_Post' )
            && ( has_shortcode( $post->post_content, self::SHORTCODE ) || has_shortcode( $post->post_content, 'blexr-calculator' ) )
        ) {
        	add_action( 'wp_head', [ $this, 'loadStylesheet' ] );
    	}

		// Load ajax_url to handle ajax submission.
		$this->loadScript();
	}

	/**
     * Load script and ajax
     *
     * @return void
	*/
	public function loadScript() : void
    {
        $pluginDir = plugin_dir_url( __FILE__ );
        wp_enqueue_script(
            'blexr-js',
            $pluginDir . 'assets/js/main.js',
            [ 'jquery' ],
            '1.0',
            true
        );

        wp_localize_script( 'blexr-js', 'ajax_object', [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ] );
    }


    public function getSports()
    {
    	$url = self::ENDPOINT . '?apiKey='. self::API_KEY;
    	$retval = wp_remote_get( $url );

    	return ! is_wp_error( $retval ) ? json_decode( $retval['body'], true ) : [];
    }


	/**
	 * 
	 * @return void
	*/
	public function loadStylesheet() : void
	{
		$pluginDir = plugin_dir_url( __FILE__ );
        
        wp_enqueue_style(
            'blexr-css',
            $pluginDir . 'assets/css/style.css',
            [],
            '1.0',
            'all'
        );
	}


	/**
	 * Add new endpoint for filter
	 * 
	 * @return void
	 */
	public function registerFilterEndpoint() : void
	{
		add_rewrite_endpoint( self::FILTER_ENDPOINT, EP_ALL );
	}


	/**
     * Filter and validate route
     *
     * @param array $vars
     *
     * @return array
     */
    public function filterOddFilterRequest( array $vars ) : array
    {
        if( isset( $vars[ self::FILTER_ENDPOINT ] )
            || ( isset( $vars['pagename'] ) && $vars['pagename'] === self::FILTER_ENDPOINT )
        ) {
        	$sport = $_REQUEST['sports'] ?? 'soccer_epl';

        	$query = [
        		'apiKey' => self::API_KEY,
        		'regions' => sanitize_text_field( $_REQUEST['regions'] ) ?? 'eu',
        		//'markets' => $_REQUEST['markets'] ?? 'h2h'
        	];

            $data =  $this->getOddsDataFromAPI( $query, $sport );

            ob_start();

            include_once 'templates/partial-odd-data.php';

            $contents = ob_get_contents();

		    ob_end_clean();

		    echo $contents; 

		    die;
        }

        return $vars;
    }



    /**
     * @param array $query
     * @param string $sport
     * 
     * @return 
     */
    private function getOddsDataFromAPI( array $query, $sport = 'soccer_epl' )
    {
    	$url = self::ENDPOINT . $sport . '/odds?' . http_build_query( $query );
    	$retval = wp_remote_get( $url );

    	return ! is_wp_error( $retval ) ? json_decode( $retval['body'], true ) : [];
    }


	/**
	 * Initial table data
	 * 
	 */
	public function initialTableData()
	{
		$query = [
			'apiKey' => self::API_KEY,
        	'regions' => 'eu',
		];
		
		return $this->getOddsDataFromAPI( $query, 'soccer_epl' );
	}

	/**
     * Format time
     * @param string $dateTime
     *
     * @return string
	*/
	public function formatDate( string $dateTime ): string
    {
        $timestamp = strtotime( $dateTime );
        $date = new DateTime();
        $date->setTimestamp( $timestamp );
        $date->setTimezone( new \DateTimeZone( date_default_timezone_get() ) );

        return $date->format( 'F d Y h:i A' );
    }
}