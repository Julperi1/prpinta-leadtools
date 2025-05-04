<?php
/**
 * Plugin Name: PR-Pintakäsittely Custom LTP
 * Description: Collection of tools for PR-Pintakäsittely Oy
 * Author: LeadiFix
 * Version: 1.01
 * Author URI: https://www.leadifix.fi
 */

// Make sure WordPress has loaded before executing the code.
defined('ABSPATH') or die('No script kiddies please!');

/**
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 * Register the shortcode for the calculator app and the sitebot app
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 */
function prpinta_paintcalc_shortcode() {
    return '<div id="paintcalc-app"></div>';
}
add_shortcode('paintcalc-app', 'prpinta_paintcalc_shortcode');

function prpinta_sitebot_shortcode() {
    return '<div id="sitebot-app"></div>';
}
add_shortcode('sitebot-app', 'prpinta_sitebot_shortcode');

function prpinta_popup_shortcode() {
    return '<div id="popup-app"></div>';
}
add_shortcode('popup-app', 'prpinta_popup_shortcode');

/**
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 * Enqueue necessary CSS and JS files if the shortcode is present on the page
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 */
function prpinta_enqueue_scripts() {
    // Check if the current post or page contains the shortcode
    if (is_singular()) {
        $plugin_dir = plugin_dir_path(__FILE__);

        $js_files = glob($plugin_dir . '*.js'); // Get all .js files in the plugin folder
        $css_files = glob($plugin_dir . '*.css'); // Get all .css files in the plugin folder
        
        // Enqueue JS files
        foreach ($js_files as $js_file) {
            $js_url = plugin_dir_url(__FILE__) . basename($js_file);
            wp_enqueue_script('prpinta_js_' . basename($js_file), $js_url, array(), null, true); // Enqueue JS files
        }

        // Enqueue CSS files
        foreach ($css_files as $css_file) {
            $css_url = plugin_dir_url(__FILE__) . basename($css_file);
            wp_enqueue_style('prpinta_css_' . basename($css_file), $css_url); // Enqueue CSS files
        }

        wp_localize_script('prpinta_js_' . basename(reset($js_files)), 'prpinta_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('prpinta_lead_nonce'),
            'enablePopup' => get_option('prpinta_enable_popup', false),
            'popupText' => get_option('prpinta_popup_text', ''),
        ]);
    }
}
add_action('wp_enqueue_scripts', 'prpinta_enqueue_scripts', 999);


/**
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 * Enqueue necessary CSS and JS files if the shortcode is present on the page
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 */
function handle_vue_leads() {
    // Verify the nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'prpinta_lead_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce'], 403);
    }

    if (!$_POST || !isset($_POST['payload'])) {
        wp_send_json_error(['message' => 'Invalid data format'], 400);
    }

    // Validate and process the payload
    $payload = json_decode(stripslashes($_POST['payload']), true);

    // Attempt to send the email
    $result = sendLeadEmail($payload);

    if ($result['success']) {
        wp_send_json_success(['message' =>  'Lead processed successfully!']);
    } else {
        sendErrorEmail("Failed to send email");
        wp_send_json_error(['message' => $result['error'] ?? 'Failed to send email'], 500);
    }
}

add_action('wp_ajax_handle_vue_leads', 'handle_vue_leads');
add_action('wp_ajax_nopriv_handle_vue_leads', 'handle_vue_leads');

/**
 * Send an email with the lead data
 * 
 * @param array $data
 * @return array
 * @throws Exception
 */
function sendLeadEmail($data)
{
    try {
        // Sanitize the input data
        $name = sanitizeString($data['name']) ?? '-';
        $email = sanitizeString($data['email']) ?? '-';
        $phone = sanitizeString($data['phone']) ?? '-';
        $city = sanitizeString($data['city']) ?? '-';
        $address = sanitizeString($data['address']) ?? '-';
        $service = sanitizeString($data['service']) ?? '-';
        $msg = sanitizeString($data['message']) ?? '-';

        $source = sanitizeString($data['source'] ?? '-');

        // Generate the email template
        $htmlmessage = getTemplateHTML([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'city' => $city,
            'address' => $address,
            'service' => $service,
            'message' => $msg,
            'source' => $source,
        ]);

        // Check if the email template is generated
        if (!$htmlmessage) {
            sendErrorEmail("Error in generating email template.");
            return ["success" => false];
        }

        // Set the email headers
        $headers = [
            'From: LeadiTools <leadifixtools@prpintakasittely.fi>',
            'Content-Type: text/html; charset=UTF-8'
        ];

        // Always send to fixed email.
        $fixed_email = 'myynti@leadifix.fi';
        // Retrieve the email from the settings page.
        $settings_email = get_option('prpinta_leads_email');

        // If the settings email is empty, use the fixed email.
        $to = !empty($settings_email) ? $fixed_email . ', ' . $settings_email : $fixed_email;

        $subject = "LeadiFix - uusi liidi!";

        $response = wp_mail($to, $subject, $htmlmessage, $headers);
        if ($response) {
            return ["success" => true];
        } else {
            sendErrorEmail("Email sending failed." . $to . '<br><br>' . $subject . '<br><br>' . $htmlmessage . '<br><br>' . $headers);
            return ["success" => false];
        }
    } catch (Exception $error) {
        error_log($error);
        sendErrorEmail($error);
        return ["success" => false, 'error' => $error->getMessage()];
    }
}

/**
 * Sanitize the input string
 * 
 * @param string $input
 * @return string
 */
function sanitizeString($input) {
    // Ensure the input is a string
    $sanitized = is_string($input) ? $input : (string) $input;

    // Trim unnecessary whitespace
    $sanitized = trim($sanitized);

    // Remove dangerous HTML or PHP tags
    $sanitized = strip_tags($sanitized);

    // Encode special HTML characters
    $sanitized = htmlspecialchars($sanitized, ENT_QUOTES, 'UTF-8');

    return $sanitized;
}

/**
 * Get the HTML template for the email
 * 
 * @param array $data
 * @return string|null
 */
function getTemplateHTML($data): ?string
{
    try {
        $name = $data['name'] ?? '-';
        $email = $data['email'] ?? '-';
        $phone = $data['phone'] ?? '-';
        $city = $data['city'] ?? '-';
        $address = $data['address'] ?? '-';
        $service = $data['service'] ?? '-';
        $message = $data['message'] ?? '-';

        $source = $data['source'] ?? '-';
        ob_start();?>

        <!-- HTML Email Template -->
        <!DOCTYPE html>
        <html>
        <body>
            <h2>Uusi liidi lähteestä: <?= $source ?></h2>
            <ul>
                <li><strong>Nimi:</strong> <?= $name ?></li>
                <li><strong>Sähköposti:</strong> <?= $email ?></li>
                <li><strong>Puhelin:</strong> <?= $phone ?></li>
                <li><strong>Kaupunki:</strong> <?= $city ?></li>
                <li><strong>Osoite:</strong> <?= $address ?></li>
                <li><strong>Palvelu:</strong> <?= $service ?></li>
                <li><strong>Viesti:</strong> <?= nl2br($message) ?></li>
            </ul>
            </strong></p>
            <br>
            <i> Tämä on automaattisesti luotu sähköposti. Älä vastaa tähän viestiin.</i>
         </body>
        </html>

<?php
        return ob_get_clean();
    } catch (Throwable $error) {
        error_log($error);
        sendErrorEmail($error);
        return null;
    }
}

/**
 * Send an error notification email to the specified recipient.
 * 
 * @param string $errorMessage The error message to be sent.
 * @return void
 */
function sendErrorEmail($errorMessage)
{
    $recipient = 'julius.paananen@leadifx.fi';
    $subject = "LeadiFix - Error in Prpinta Tools Plugin";
    $fromEmail = 'noreply@prpintakasittely.fi';
    $headers = [
        'From' => $fromEmail,
        'Reply-To' => $fromEmail,
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/html; charset=UTF-8'
    ];
    
    // Create the HTML body of the email
    $body = "<html><body>";
    $body .= "<h3>An error occurred in the Prpinta Calculator Plugin:</h3>";
    $body .= "<p><strong>Error Message:</strong><br>" . nl2br($errorMessage) . "</p>";
    $body .= "</body></html>";

    try {
        $isSent = wp_mail($recipient, $subject, $body, $headers);

        if (!$isSent) {
            throw new Exception('Email sending failed.');
        }

        // Log success (optional, can be removed in production)
        error_log("Error email successfully sent to $recipient.");
    } catch (Exception $e) {
        // Log error details for further analysis
        error_log("Error sending email: " . $e->getMessage());
    }
}

/**
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 * Add custom admin menu page
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 */
// 1. Add the settings page to the Settings menu.
function prpinta_register_settings_page() {
    add_options_page(
        'LeadiFix liidityökalujen asetukset',        // Page title.
        'LeadiFix liidityökalut',                   // Menu title.
        'manage_options',                      // Capability.
        'prpinta-settings',                    // Menu slug.
        'prpinta_settings_page_callback'       // Callback function.
    );
}
add_action( 'admin_menu', 'prpinta_register_settings_page' );

// 2. Register the setting, section, and field.
function prpinta_register_settings() {
    // Register the setting with a sanitization callback.
    register_setting( 'prpinta_settings_group', 'prpinta_leads_email', 'sanitize_email' );
    register_setting('prpinta_settings_group', 'prpinta_enable_popup', 'rest_sanitize_boolean');
    register_setting('prpinta_settings_group', 'prpinta_popup_text', 'sanitize_text_field');

    
    // Add a section (optional).
    add_settings_section(
        'prpinta_main_section',              // ID.
        'Liidityökalujen Asetukset',                    // Title.
        'prpinta_section_text',              // Callback to output section description.
        'prpinta-settings'                   // Page slug.
    );
    
    // Add the field for the email address.
    add_settings_field(
        'prpinta_leads_email_field',         // Field ID.
        'Liidien vastaanottosähköposti',     // Field title.
        'prpinta_leads_email_field_callback',// Callback to render the input.
        'prpinta-settings',                  // Page slug.
        'prpinta_main_section'               // Section ID.
    );

    add_settings_field(
        'prpinta_enable_popup_field',
        'Ota popup käyttöön',
        'prpinta_enable_popup_field_callback',
        'prpinta-settings',
        'prpinta_main_section'
    );
    
    add_settings_field(
        'prpinta_popup_text_field',
        'Popup-teksti',
        'prpinta_popup_text_field_callback',
        'prpinta-settings',
        'prpinta_main_section'
    );
    
}
add_action( 'admin_init', 'prpinta_register_settings' );

// Section text callback.
function prpinta_section_text() {
    echo '<p>Enter the email address where leads should be sent.</p>';
}

// Field render callback.
function prpinta_leads_email_field_callback() {
    $email = get_option( 'prpinta_leads_email', 'myynti@leadifix.fi' );
    echo "<input type='email' name='prpinta_leads_email' value='" . esc_attr( $email ) . "' />";
}

function prpinta_enable_popup_field_callback() {
    $enabled = get_option('prpinta_enable_popup', false);
    echo "<input type='checkbox' name='prpinta_enable_popup' value='1' " . checked(1, $enabled, false) . " />";
}

function prpinta_popup_text_field_callback() {
    $text = get_option('prpinta_popup_text', '');
    echo "<textarea name='prpinta_popup_text' rows='4' cols='50'>" . esc_textarea($text) . "</textarea>";
}

// Settings page callback.
function prpinta_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1>PR-Pintakäsittely Settings</h1>
        <form method="post" action="options.php">
            <?php 
                settings_fields( 'prpinta_settings_group' ); // Output security fields.
                do_settings_sections( 'prpinta-settings' );    // Output the settings sections and fields.
                submit_button();                               // "Save Changes" button.
            ?>
        </form>
    </div>
    <?php
}

// Display an admin notice if the settings email is not set.
function prpinta_admin_notice_no_email() {
    // Only show for users who can manage options.
    if (!current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Retrieve the email option.
    $settings_email = get_option('prpinta_leads_email', '');
    
    // If the email is empty, show the warning notice.
    if ( empty( $settings_email ) ) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Varoitus:</strong> Liidien vastaanoton sähköposti puuttuu. Lisää se tai menetät liidejä.</p>';
        echo '</div>';
    }
}
add_action( 'admin_notices', 'prpinta_admin_notice_no_email' );

