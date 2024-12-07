<?php

class Custom_Comments_View {
    public function render_admin_page() {
        if ($_POST['update_settings']) {
            update_option('custom_comments_blacklist', explode("\n", sanitize_textarea_field($_POST['blacklist'])));
            update_option('custom_comments_banned_users', explode("\n", sanitize_textarea_field($_POST['banned_users'])));
            echo '<div class="updated"><p>Settings saved.</p></div>';
        }

        $blacklist = implode("\n", get_option('custom_comments_blacklist', []));
        $banned_users = implode("\n", get_option('custom_comments_banned_users', []));

        ?>
        <div class="wrap">
            <h1>Custom Comments Settings</h1>
            <form method="post">
                <h2>Word Blacklist</h2>
                <textarea name="blacklist" rows="10" cols="50"><?php echo esc_textarea($blacklist); ?></textarea>
                <h2>Banned Users (Emails)</h2>
                <textarea name="banned_users" rows="10" cols="50"><?php echo esc_textarea($banned_users); ?></textarea>
                <p><input type="submit" name="update_settings" value="Save Settings" class="button button-primary"></p>
            </form>
        </div>
        <?php
    }
}
