<?php

class Custom_Comments_Model {
    public function process_comment($data) {
        $blacklist = get_option('custom_comments_blacklist', []);
        $banned_users = get_option('custom_comments_banned_users', []);

        // Check blacklist
        foreach ($blacklist as $word) {
            if (strpos(strtolower($data['comment']), strtolower($word)) !== false) {
                return ['success' => false, 'message' => 'Your comment contains prohibited words.'];
            }
        }

        // Check banned users
        if (in_array($data['email'], $banned_users)) {
            return ['success' => false, 'message' => 'You are banned from commenting.'];
        }

        // Insert comment
        $comment_data = [
            'comment_post_ID' => $data['post_id'],
            'comment_author' => $data['author'],
            'comment_author_email' => $data['email'],
            'comment_content' => $data['comment'],
            'comment_type' => '',
        ];

        $comment_id = wp_new_comment($comment_data);

        if (is_wp_error($comment_id)) {
            return ['success' => false, 'message' => 'Error submitting your comment.'];
        }

        return ['success' => true, 'message' => 'Comment submitted successfully!'];
    }
}
