<?php
namespace NaritiveBridge;

if (!defined('ABSPATH')) exit;

final class Plugin {
    private static ?Plugin $instance = null;

    public static function instance(): Plugin {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    public function boot(): void {
        require_once NARITIVE_BRIDGE_PATH . 'includes/CampaignCPT.php';
        require_once NARITIVE_BRIDGE_PATH . 'includes/CampaignMeta.php';
        require_once NARITIVE_BRIDGE_PATH . 'includes/RestController.php';
        require_once NARITIVE_BRIDGE_PATH . 'includes/Shortcodes/CreateCampaign.php';

        (new CampaignCPT())->register();
        (new CampaignMeta())->register();
        (new RestController())->register();
        (new Shortcodes\CreateCampaign())->register();
    }
}
