<?php
namespace NaritiveBridge;

if (!defined('ABSPATH')) exit;

class CampaignMeta {
    public const META_CLIENT = '_nar_client_name';
    public const META_BUDGET = '_nar_budget';
    public const META_START  = '_nar_start_date';
    public const META_STATUS = '_nar_status';

    public function register(): void {
        add_action('init', [$this, 'register_meta']);
    }

    public function register_meta(): void {
        $common = [
            'single' => true,
            'show_in_rest' => false,
            'auth_callback' => '__return_true',
        ];

        register_post_meta(CampaignCPT::POST_TYPE, self::META_CLIENT, array_merge($common, ['type' => 'string']));
        register_post_meta(CampaignCPT::POST_TYPE, self::META_BUDGET, array_merge($common, ['type' => 'number']));
        register_post_meta(CampaignCPT::POST_TYPE, self::META_START,  array_merge($common, ['type' => 'string']));
        register_post_meta(CampaignCPT::POST_TYPE, self::META_STATUS, array_merge($common, ['type' => 'string']));
    }
}
