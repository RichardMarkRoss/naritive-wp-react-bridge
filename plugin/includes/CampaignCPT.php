<?php
namespace NaritiveBridge;

if (!defined('ABSPATH')) exit;

class CampaignCPT {
    public const POST_TYPE = 'naritive_campaign';

    public function register(): void {
        add_action('init', [$this, 'register_post_type']);
    }

    public function register_post_type(): void {
        $labels = [
            'name' => 'Campaigns',
            'singular_name' => 'Campaign',
            'add_new_item' => 'Add New Campaign',
            'edit_item' => 'Edit Campaign',
        ];

        register_post_type(self::POST_TYPE, [
            'labels' => $labels,
            'public' => true,
            'show_in_rest' => false, // we expose via our custom endpoint
            'has_archive' => true,
            'menu_icon' => 'dashicons-megaphone',
            'supports' => ['title'],
        ]);
    }
}
