<?php

class Custom_Comments_Controller {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new Custom_Comments_Model();
        $this->view = new Custom_Comments_View();
    }

    public function init() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_submit_comment', [$this, 'handle_ajax_request']);
        add_action('wp_ajax_nopriv_submit_comment', [$this, 'handle_ajax_request']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }

    public function enqueue_scripts() {
        if (is_single() && comments_open()) {
            wp_enqueue_script(
                'custom-comments-js',
                CUSTOM_COMMENTS_URL . 'assets/js/custom-comments.js',
                ['jquery'],
                null,
                true
            );

            wp_localize_script('custom-comments-js', 'customCommentsAjax', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('custom_comments_nonce'),
            ]);
        }
    }

    public function handle_ajax_request() {
        check_ajax_referer('custom_comments_nonce', 'nonce');

        $data = [
            'post_id' => intval($_POST['post_id']),
            'author' => sanitize_text_field($_POST['author']),
            'email' => sanitize_email($_POST['email']),
            'comment' => sanitize_textarea_field($_POST['comment']),
        ];

        $result = $this->model->process_comment($data);

        if ($result['success']) {
            wp_send_json_success(['message' => $result['message']]);
        } else {
            wp_send_json_error(['message' => $result['message']]);
        }
    }

    public function add_admin_menu() {
        add_menu_page(
            'Custom Comments Settings',
            'Comments Settings',
            'manage_options',
            'custom-comments-settings',
            [$this->view, 'render_admin_page']
        );
    }
}
