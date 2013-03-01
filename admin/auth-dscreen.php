<?php 
//here we check if option conatcin any value in database
$get_opt = get_option('auth_key');

?>
<div class="wrap">

<h2><?php _e('Auth Server Screen');?>  
    <a class="button" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=auth-server&amp;sub=auth_add_clientdomain">
        <?php _e('Generate Auth Key','auth_server'); ?>
    </a>
   
</h2>

<p><?php _e('All auth key will be listed here if exist');?></p>

<p class="message"></p>
<table class="widefat listtoken">
<thead>
    <tr>
        <th>Id</th>
        <th>Domain</th>      
        <th>Auth Key</th>
         <th>Action</th>
    </tr>
</thead>
<tfoot>
    <tr>
    <th>Id</th>
    <th>Domain</th>
    <th>Auth Key</th>
    <th>Action</th>
    </tr>
</tfoot>
<tbody>
    <?php if($get_opt):
        $count =1;
        foreach($get_opt as $key=>$info):
    ?>
    <tr id="token_<?php echo $info['key']?>">
        <td><?php echo $count;?>
        <td><?php echo $info['domain'];?></td>
        <td><?php echo $info['key'];?></td>
        <td><img id="<?php echo $info['key']?>" class="del_button" src="<?php echo AUTH_IMAGE_DIR?>remove.png"/></td>
    </tr>
    <?php $count++;endforeach;?>
    <?php else: ?>
        <tr>
        <td colspan="4"><?php _e('No auth key found');?></td>
        </tr>
    <?php endif; ?>
   
     
  
</tbody>
</table>
</div>