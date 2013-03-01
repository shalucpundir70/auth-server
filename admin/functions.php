<?php
/**
 * Generate token form submission using ajax 
 */
add_action("wp_ajax_form_submit_action", "generate_token_key");

function generate_token_key() {
    //check the request
    //nonce validate
    //if we are here, we are assuming, we recieved a valid request
    
    //get domain value from input field 
    $domain = $_POST['site_domain'];
    //if domain is empty or not valid format ,show a error message 
    
    if (empty($domain) || !fused_validate_domain($domain)) {
        //we have got an error, this is not a valid request
        //tell the user that you must enter a domain name
        $message = array('message' => 'Your domain is empty or invalid', 'status' => 'error');
        echo json_encode($message);
       
        exit(0);
    }

    //if we are here,mean domain is not empty or also with valid url
    //all is well now, so we can proceed further and update the database info
    //let us build a unique secret key

    $time = time();
    $domain = trim($domain);
    $data = array($domain, $time, SECURE_AUTH_KEY);
    shuffle($data);
    $uniquekey = md5(join(":", $data)); //unique key

    $updated = false;

    $entry = array('domain' => $domain, 'key' => $uniquekey);
    $options = get_site_option('auth_key');

    if (!$options)
        $options = array();
    //find if the entry already exists
    //for updating
    foreach ($options as $key => $info) {

        if ($info['domain'] == $domain) {
            //remove old entry
            unset($options[$key]);
            $options[$uniquekey] = $entry;
            $updated = true;
            break;
        }
    }

    if (!$updated) {
        $options[$uniquekey] = $entry;
    }
    update_option('auth_key', $options);
    
    echo json_encode(array('message' => 'Auth key generated successfully . Click on view auth key button above.', 'status' => 'success'));
    exit(0);
}


/**
 * Delete added record using ajax when you click cross image in front of every token listing 
 */
add_action("wp_ajax_record_delete_action", "delete_record");

function delete_record(){
    
    $record_id = $_POST['record_id'];
    $options = get_site_option('auth_key');
    
   //here we check particuler delete record id exist in database or not
    if($options[$record_id]['key'] == $record_id ){
       
        //here we unset the arrry if it match in database
        unset($options[$record_id]);
        //update the array again in database
        update_option('auth_key', $options);
        echo json_encode(array('message' => 'Record Deleted Succesfully', 'status' => 'deleted'));
        exit(0);
    }
    
   
}

/**
 * This function validate domain entered by you 
 * we used this function inside generate_token_key() above
 * 
 * @param type $domain
 * @return type 
 */
function fused_validate_domain($domain) {

     return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $domain);
    //return true;
}
/**
 * Call file accodingly 
 * 
 * @global type $wpdb 
 */
function auth_screen() {
   
    global $wpdb;

    $current_page = isset($_GET['sub']) ? $_GET['sub'] : '';
    switch ($current_page) {

        case 'auth_add_clientdomain':
            include('auth-form.php');
            break;
        default:
            include('auth-dscreen.php');
            break;
    }
}

    ?>