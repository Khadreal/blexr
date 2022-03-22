<?php


namespace Symphony\Blexr;


class Ajax
{
	/**
	 * Initialiasation
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
		add_action( 'wp_ajax_nopriv_get_blexr_filter', [ $this, 'actionOddsFilter' ] );
	}

	
	public function actionOddsFilter()
	{
		
	}
}