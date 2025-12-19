<?php
namespace NaritiveBridge;

use WP_REST_Request;
use WP_REST_Response;

if (!defined('ABSPATH')) exit;

class RestController
{
    private const NAMESPACE = 'naritive/v1';
    private const ROUTE = '/campaigns';

    public function register(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route(self::NAMESPACE, self::ROUTE, [
                'methods'  => 'GET',
                'callback' => [$this, 'get_campaigns'],
                'permission_callback' => '__return_true', // public read-only
                'args' => [
                    'page' => [
                        'default' => 1,
                        'sanitize_callback' => 'absint',
                        'validate_callback' => fn($v) => is_numeric($v) && (int)$v >= 1,
                    ],
                    'per_page' => [
                        'default' => 10,
                        'sanitize_callback' => 'absint',
                        'validate_callback' => fn($v) => is_numeric($v) && (int)$v >= 1 && (int)$v <= 50,
                    ],
                    'status' => [
                        'sanitize_callback' => 'sanitize_key',
                        'validate_callback' => fn($v) => $v === '' || in_array($v, ['active', 'paused'], true),
                    ],
                    'budget_min' => [
                        'sanitize_callback' => fn($v) => is_numeric($v) ? (float)$v : null,
                        'validate_callback' => fn($v) => $v === null || is_numeric($v),
                    ],
                    'budget_max' => [
                        'sanitize_callback' => fn($v) => is_numeric($v) ? (float)$v : null,
                        'validate_callback' => fn($v) => $v === null || is_numeric($v),
                    ],
                    'search' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ]);
        });
    }

    public function get_campaigns(WP_REST_Request $request): WP_REST_Response
    {
        $page     = max(1, (int)$request->get_param('page'));
        $per_page = min(50, max(1, (int)$request->get_param('per_page')));

        $status    = (string)($request->get_param('status') ?? '');
        $budgetMin = $request->get_param('budget_min');
        $budgetMax = $request->get_param('budget_max');
        $search    = trim((string)($request->get_param('search') ?? ''));

        // Build meta_query safely
        $meta_query = ['relation' => 'AND'];

        if ($status !== '') {
            $meta_query[] = [
                'key'     => CampaignMeta::META_STATUS,
                'value'   => $status,
                'compare' => '=',
            ];
        }

        if ($budgetMin !== null && $budgetMin !== '') {
            $meta_query[] = [
                'key'     => CampaignMeta::META_BUDGET,
                'value'   => (float)$budgetMin,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            ];
        }

        if ($budgetMax !== null && $budgetMax !== '') {
            $meta_query[] = [
                'key'     => CampaignMeta::META_BUDGET,
                'value'   => (float)$budgetMax,
                'type'    => 'NUMERIC',
                'compare' => '<=',
            ];
        }

        if ($search !== '') {
            // Search by Client Name meta (LIKE)
            $meta_query[] = [
                'key'     => CampaignMeta::META_CLIENT,
                'value'   => $search,
                'compare' => 'LIKE',
            ];
        }

        $args = [
            'post_type'      => CampaignCPT::POST_TYPE,
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $page,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'meta_query'     => count($meta_query) > 1 ? $meta_query : [],
        ];

        $query = new \WP_Query($args);

        $data = [];
        foreach ($query->posts as $post) {
            $post_id = (int)$post->ID;

            $client = (string)get_post_meta($post_id, CampaignMeta::META_CLIENT, true);
            $budget = (float)get_post_meta($post_id, CampaignMeta::META_BUDGET, true);
            $start  = (string)get_post_meta($post_id, CampaignMeta::META_START, true);
            $stat   = (string)get_post_meta($post_id, CampaignMeta::META_STATUS, true);

            $data[] = [
                'id'          => $post_id,
                'title'       => get_the_title($post_id),
                'client_name' => $client,
                'budget'      => $budget,
                'start_date'  => $start,
                'status'      => $stat,
            ];
        }

        $total       = (int)$query->found_posts;
        $total_pages = (int)$query->max_num_pages;

        $payload = [
            'data' => $data,
            'meta' => [
                'page'        => $page,
                'per_page'    => $per_page,
                'total'       => $total,
                'total_pages' => $total_pages,
            ],
        ];

        return new WP_REST_Response($payload, 200);
    }
}
