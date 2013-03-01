<div class="wrap">
<h2 id=""><?php _e('Add Client Domain') ?>
    <a class="button viewtoken button-primary" style="display:none;" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=auth-server">
        <?php _e('View Auth Key','auth-server'); ?>
    </a>
</h2>
<p class="description"><?php _e('Add client server domain for which you want to generate a unique auth key <b>(It will automatic generate a auth key for your client server site when you hit "Generate Key")</b>');?></p>
<p class="message"></p>
<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="createtoken">
    <table class="form-table">
        <tbody>
             <tr class="form-field form-required">
                <th scope="row"><label for="siteurl">Client Domain <span class="description">(required *)</span></label></th>
                <td ><input type="text" aria-required="true" value="" id="site_domain" name="site_domain"><p class="description">for ex:http://localhost/authclient</p></td>
            </tr>
            
        </tbody>
    </table>
    
    <?php submit_button( __('Generate Key'), 'primary', 'generate-auth-key'); ?>
</form
</div>


