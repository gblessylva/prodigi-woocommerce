<?php
class CreateProdigiSettingsPage {
    private $plugin_options;

    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));

    }

  

    
    public function add_plugin_page() {
        add_options_page(
            'Prodigi Dropshipping Settingss',       // Page title
            'Prodigi Dropshipping Settings',                // Menu title
            'manage_options',           // Capability required
            'prodigidro-setting',       // Menu slug
            array($this, 'create_admin_page') // Callback function
        );
    }

    public function create_admin_page() {
        // Initialize plugin options
        $this->plugin_options = get_option('prodigidro_options');

        ?>
        <div class="wrap bg-slate-300 text-white py-4 px-7 flex flex-col items-center h-[700px]">
            <h1 class="text-3xl font-bold text-teal-800">Settings Prodigi Dropshipping</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('prodigidro_options_group');
                do_settings_sections('prodigidro-settings');
                do_action('prodigidro_custom_fields');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function page_init() {
        register_setting(
            'prodigidro_options_group',
            'prodigidro_options',
            array($this, 'sanitize')
        );

        add_settings_section(
            'prodigidro_settings_section',
            'General Settings',
            array($this, 'section_callback'),
            'prodigidro-settings'
        );

        add_settings_field(
            'prodigidro_live_api_key',
            'Live API Key',
            array($this, 'live_api_key_callback'),
            'prodigidro-settings',
            'prodigidro_settings_section'
        );

        add_settings_field(
            'prodigidro_test_api_key',
            'Test API Key',
            array($this, 'test_api_key_callback'),
            'prodigidro-settings',
            'prodigidro_settings_section'
        );

        add_settings_field(
            'prodigidro_test_api_url',
            'Test API URL',
            array($this, 'test_api_url_callback'),
            'prodigidro-settings',
            'prodigidro_settings_section'
        );

        add_settings_field(
            'prodigidro_live_api_url',
            'Test API URL',
            array($this, 'live_api_url_callback'),
            'prodigidro-settings',
            'prodigidro_settings_section'
        );

        add_settings_field(
            'prodigidro_is_live',
            'Is Live',
            array($this, 'is_live_callback'),
            'prodigidro-settings',
            'prodigidro_settings_section'
        );
    }

    public function sanitize($input) {
        $sanitized_input = array();

        if (isset($input['prodigidro_live_api_key'])) {
            $sanitized_input['prodigidro_live_api_key'] = sanitize_text_field($input['prodigidro_live_api_key']);
        }
        
        if (isset($input['prodigidro_test_api_key'])) {
            $sanitized_input['prodigidro_test_api_key'] = sanitize_text_field($input['prodigidro_test_api_key']);
        }

        if (isset($input['test_api_url_callback'])) {
            $sanitized_input['test_api_url_callback'] = sanitize_text_field($input['test_api_url_callback']);
        }

        if (isset($input['live_api_url_callback'])) {
            $sanitized_input['live_api_url_callback'] = sanitize_text_field($input['live_api_url_callback']);
        }

        if (isset($input['prodigidro_is_live'])) {
            $sanitized_input['prodigidro_is_live'] = intval($input['prodigidro_is_live']);
        }
       
        

        return $sanitized_input;
    }

    public function section_callback() {
        echo '<p>Enter your settings here.</p>';
    }

    public function live_api_key_callback() {
        $value = isset($this->plugin_options['prodigidro_live_api_key']) ? $this->plugin_options['prodigidro_live_api_key'] : '';
        echo '<input type="text" id="prodigidro_live_api_key" name="prodigidro_options[prodigidro_live_api_key]" value="' . esc_attr($value) . '" />';
    }

    public function test_api_key_callback() {
        $value = isset($this->plugin_options['prodigidro_test_api_key']) ? $this->plugin_options['prodigidro_test_api_key'] : '';
        echo '<input type="text" id="prodigidro_test_api_key" name="prodigidro_options[prodigidro_test_api_key]" value="' . esc_attr($value) . '" />';
        echo apply_filters('custom_input_field', 'text');
    }
    public function test_api_url_callback(){
        $value = isset($this->plugin_options['prodigidro_test_api_url']) ? $this->plugin_options['prodigidro_test_api_url'] : '';
        echo '<input type="text" id="prodigidro_test_api_url" name="prodigidro_options[prodigidro_test_api_url]" value="' . esc_attr($value) . '" />';
    }

    public function live_api_url_callback(){
        $value = isset($this->plugin_options['prodigidro_live_api_url']) ? $this->plugin_options['prodigidro_live_api_url'] : '';
        echo '<input type="text" id="prodigidro_live_api_url" name="prodigidro_options[prodigidro_live_api_url]" value="' . esc_attr($value) . '" />';
    }

    public function is_live_callback() {
        $value = isset($this->plugin_options['prodigidro_is_live']) ? $this->plugin_options['prodigidro_is_live'] : '';
        echo '<input type="checkbox" id="prodigidro_is_live" name="prodigidro_options[prodigidro_is_live]" value="1" ' . checked(1, $value, false) . ' />';
    }
    // Add more callback functions for additional settings fields or sections

}

// Create an instance of the CreateProdigiSettingsPage class
$prodigi_dropshipping_settings_page = new CreateProdigiSettingsPage();
