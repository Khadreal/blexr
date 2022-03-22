<?php


namespace Symphony\Blexr;


class Admin
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
        add_action( 'admin_init', [ $this, 'actionRegisterSettings' ] );
	}

	
	public function actionRegisterSettings()
	{
        add_settings_section(
            'blexr_betting_odd_setting',
            __( 'Betting Odds Setting', 'blexr-odd' ),
            [ $this, 'callbackSettingsSection' ],
            'general'
        );

        add_settings_field(
            'blexr_api_key',
            __( 'API key', 'blexr-odd' ),
            [ $this, 'callbackJobSettingsFields' ],
            'general',
            'blexr_betting_odd_setting',
            [
                'name' => 'blexr_api_key',
                'type' => 'text',
            ]
        );

        register_setting( 'general', 'blexr_api_key' );
	}

	/**
     *  Renders the options fields.
     *
     * @param array $args
     *
     * @return void
	*/
    public function callbackJobSettingsFields( array $args ) : void
    {
        $settingName = $args['name'] ?? null;
        $desc = $args['desc'] ?? '';
        $placeholder = $args['placeholder'] ?? '';
        $default = $args['default'] ?? '';

        if( empty( $settingName ) ) {
            return;
        }

        $settingValue = get_option( $settingName, $default );

        printf(
            '<input type="text" class="regular-text" placeholder="%s" value="%s" name="%s"><p class="help">%s</p>',
            $placeholder,
            $settingValue,
            $settingName,
            $desc
        );
    }

    /**
     * Blexr settings section callback.
     *
     * @return void
     */
	public function callbackSettingsSection() : void
    {
        printf( '<p>%s</p>', __( 'Add api key', 'blexr-odd' ) );
    }
}