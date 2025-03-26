<?php
/**
 * Plugin Name: PR-Pintakäsittely PPC
 * Description: Paintjob Price Calculator for PR-Pintakäsittely Oy
 * Author: LeadiFix
 * Version: 1.0
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
        ]);
    }
}
add_action('wp_enqueue_scripts', 'prpinta_enqueue_scripts');


/**
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 * Enqueue necessary CSS and JS files if the shortcode is present on the page
 * --------------------------------------------------------------------------
 * --------------------------------------------------------------------------
 */
function handle_tools_leads() {
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
        wp_send_json_success(['message' => 'Lead processed successfully!']);
    } else {
        wp_send_json_error(['message' => 'Failed to process lead'], 500);
    }
}

add_action('wp_ajax_handle_tools_leads', 'handle_tools_leads');
add_action('wp_ajax_nopriv_handle_tools_leads', 'handle_tools_leads');

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
        $name = sanitizeString($data['name']);
        $email = sanitizeString($data['email']);
        $phone = sanitizeString($data['phone']);
        $city = sanitizeString($data['city']);
        $address = sanitizeString($data['address']);
        $service = sanitizeString($data['service']);
        $message = sanitizeString($data['message']);

        // Generate the email template
        $message = getTemplateHTML([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'city' => $city,
            'address' => $address,
            'service' => $service,
            'message' => $message,
        ]);

        // Check if the email template is generated
        if (!$message) {
            sendErrorEmail("Error in generating email template.");
            return ["success" => false];
        }

        // Set the email headers
        $headers = "From: noreply@prpinta.fi" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

        // Set the recipient email address
        //$to = 'asiakaspalvelu@prpinta.fi, jaakko.rantanilkku@prpinta.fi, myynti@leadifix.fi';
        $to = 'myynti@leadifix.fi';
        $subject = "LeadiFix - uusi laskuriliidi!";

        $response = wp_mail($to, $subject, $message, $headers);
        if ($response) {
            return ["success" => true];
        } else {
            sendErrorEmail("Email sending failed." . $to . '<br><br>' . $subject . '<br><br>' . $message . '<br><br>' . $headers);
            return ["success" => false];
        }
    } catch (Exception $error) {
        error_log($error);
        return ["success" => false];
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
        $angle = $data['angle'] . '°';
        $battery = ($data['battery'] === 'yes') ? 'Kyllä' : 'Ei';
        $batteryPossibility = ($data['batteryPossibility'] === 'yes') ? 'Kyllä' : 'Ei';
        $consumption = $data['consumption'];
        $height = ($data['height'] === 'over3') ? 'Yli 3m' : 'Alle 3m';
        $roof = ($data['roof'] === 'angled') ? 'Harjakatto' : 'Tasakatto';
        $type = ($data['type'] === '"house"') ? 'Omakotitalo' : 'Mökki (sähköverkossa)';
        $price = $data['price'] . '€';

        $phone = $data['phone'];
        $email = $data['email'];

        ob_start();
?>
        <!DOCTYPE html>
        <html>
        <!-- Email template for the lead data -->
        </html>

<?php
        return ob_get_clean();
    } catch (Throwable $error) {
        error_log($error);
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