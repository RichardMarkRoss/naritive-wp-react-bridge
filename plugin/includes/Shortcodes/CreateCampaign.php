<?php
namespace NaritiveBridge\Shortcodes;

use NaritiveBridge\CampaignCPT;
use NaritiveBridge\CampaignMeta;

if (!defined('ABSPATH')) exit;

class CreateCampaign {
    private const NONCE_ACTION = 'naritive_create_campaign';
    private const NONCE_NAME = 'naritive_nonce';

    public function register(): void {
        add_shortcode('naritive_create_campaign', [$this, 'render']);
        add_action('init', [$this, 'handle_submit']);
    }

    public function render(): string {
        $status_options = [
            'active' => 'Active',
            'paused' => 'Paused',
        ];

        $out = '';

        if (!empty($_GET['naritive_created'])) {
            $out .= '<div style="padding:10px;border:1px solid #46b450;margin:10px 0;">Campaign created successfully.</div>';
        }

        $out .= '<form method="POST">';
        $out .= wp_nonce_field(self::NONCE_ACTION, self::NONCE_NAME, true, false);

        $out .= '<p><label>Campaign Title<br><input name="nar_title" required></label></p>';
        $out .= '<p><label>Client Name<br><input name="nar_client" required></label></p>';
        $out .= '<p><label>Budget<br><input type="number" step="0.01" min="0" name="nar_budget" required></label></p>';
        $out .= '<p><label>Start Date<br><input type="date" name="nar_start_date" required></label></p>';

        $out .= '<p><label>Status<br><select name="nar_status" required>';
        foreach ($status_options as $val => $label) {
            $out .= '<option value="' . esc_attr($val) . '">' . esc_html($label) . '</option>';
        }
        $out .= '</select></label></p>';

        $out .= '<p><button type="submit" name="nar_submit_campaign" value="1">Create Campaign</button></p>';
        $out .= '</form>';

        return $out;
    }

    public function handle_submit(): void {
        if (empty($_POST['nar_submit_campaign'])) return;

        if (!isset($_POST[self::NONCE_NAME]) || !wp_verify_nonce($_POST[self::NONCE_NAME], self::NONCE_ACTION)) {
            wp_die('Security check failed (invalid nonce).');
        }

        $title  = sanitize_text_field($_POST['nar_title'] ?? '');
        $client = sanitize_text_field($_POST['nar_client'] ?? '');
        $budget = isset($_POST['nar_budget']) ? floatval($_POST['nar_budget']) : 0;
        $start  = sanitize_text_field($_POST['nar_start_date'] ?? '');
        $status = sanitize_key($_POST['nar_status'] ?? '');

        if ($title === '' || $client === '' || $budget < 0 || $start === '' || !in_array($status, ['active','paused'], true)) {
            wp_die('Validation failed. Please go back and correct the form.');
        }

        $post_id = wp_insert_post([
            'post_type' => CampaignCPT::POST_TYPE,
            'post_status' => 'publish',
            'post_title' => $title,
        ], true);

        if (is_wp_error($post_id)) {
            wp_die('Failed to create campaign.');
        }

        update_post_meta($post_id, CampaignMeta::META_CLIENT, $client);
        update_post_meta($post_id, CampaignMeta::META_BUDGET, $budget);
        update_post_meta($post_id, CampaignMeta::META_START,  $start);
        update_post_meta($post_id, CampaignMeta::META_STATUS, $status);

        // Redirect to avoid form resubmission
        $redirect = add_query_arg('naritive_created', '1', wp_get_referer() ?: home_url('/'));
        wp_safe_redirect($redirect);
        exit;
    }
}
