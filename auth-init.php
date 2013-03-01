<?php

/*
  Plugin Name: Auth Server
  Plugin URI:http://fusedpress.com
  Description: Basically this plugin copy userinfo from server to client that all is bases on the token we generated here.This plugin work with other plugin name(Auth Clin)
  Author: Shalu
  Version: 1.6
  Author URI:
 */

class AuthServerHelper {

    private static $instance;

    private function __construct() {

        global $wpdb;
       
        define('AUTH_IMAGE_DIR', plugin_dir_url(__FILE__) . '/admin/images/');

        add_action('init', array($this, 'check_auth_request')); //initialize load theme setting
        add_action('init', array($this, 'load_module')); //initialize load theme setting
        add_action('admin_menu', array($this, 'add_menu')); //initilize admin menu
        add_action('admin_head', array($this, 'load_css')); // load css 
        add_action('admin_print_scripts', array($this, 'load_js')); //initialize load js
    }

    public static function get_instance() {

        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    function load_module() {
        include_once 'admin/functions.php';
    }

    function add_menu() {
        //here we are adding top level menu in wp-admin dashboard
        //syntax:add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page(
                'Auth Server', //page title
                'Auth Server', //menu title
                'manage_options', //capability
                'auth-server', //menu slug
                'auth_screen' //function
        );
    }

    function load_css() {

        wp_register_style('auth-css', plugin_dir_url(__FILE__) . '/admin/style.css');
        wp_enqueue_style('auth-css');
    }

    function load_js() {

        wp_register_script("auth_script", plugin_dir_url(__FILE__) . 'admin/auth.js', array('jquery'));
        wp_enqueue_script('auth_script');
    }

    function check_auth_request() {


        if ($_GET['auth']) {

            //here is all posted date using curl from other server(client server)
            $secretkey = trim($_POST['authkey']);
            $user_name = trim($_POST['username']);
            $user_pass = trim($_POST['password']);
            $domain_name = trim($_POST['domainname']);


            // get option value using option name ="auth_key"
            $get_option = get_option('auth_key');

            //unserlize get option vcalue here
            $un_get_option = maybe_unserialize($get_option);

            /*
             * after unserlize it show result something like this if you added two website to generate token
             * Array
              (
              [207992f6377433e860064f22deb7a731] => Array
              (
              [domain] => http://localhost/user
              [key] => 207992f6377433e860064f22deb7a731
              )

              [1f89797a21e6ed15f63005228ba3882a] => Array
              (
              [domain] => http://localhost/abc
              [key] => 1f89797a21e6ed15f63005228ba3882a
              )

              )
             */


            //after that you need to check if posted secret key exist in this array or not 
            //if exist then you have to check you need to compare the posted domain and domain name correspnding
            // to exist secret key in array 
            // check for $domain_name equal to $un_get_option[$secretkey][domain]
            //here we checking posted secret key exist in array or not 

            if (array_key_exists($secretkey, $un_get_option)) {

                //if secret key exist in array then here we get corresponding domain name
                $rdomain = $un_get_option[$secretkey]['domain'];
                //here we compare both domain (exist in array or posted domain name from client server) equal
                if ($rdomain == $domain_name) {
                    //if domain and secret key both matach only then user info wiill be added to client server
                    //echo "domain match";
                    $resp = array('messgae' => 'domain match succesfully');
                    //echo maybe_serialize($resp);



                    if (username_exists($user_name)) {

                        //get userdata on the basis of loginname 
                        $user = get_user_by('login', $user_name);

                        if (is_wp_error($user)) {

                            $resp = array('auth' => 0, 'user' => $user, 'message' => $user->get_error_message());
                            echo maybe_serialize($resp);
                            exit(0);
                        }
                        //if we are here, the system was able to find the user ,now check for pass word for same user
                        if (wp_check_password($user_pass, $user->user_pass, $user->ID)) {
                            //ok, the user exists and the password matched correctly
                            //let us notify the client
                            //echo"user name and pass bot correct";
                            $message = "Authentication successfull";
                            $resp = array('auth' => 1, 'user' => $user, 'message' => "Authentication successfull");
                            echo maybe_serialize($resp);
                            //exit(0);
                        }
                    } else {

                        $resp = array('auth' => 0, 'register_new' => 1, 'user' => null, 'message' => "The User name you entered does not exist");
                        echo maybe_serialize($resp);
                        exit(0);
                    }
                }
            } else {
                $resp = array('messgae' => 'key not match successfully please check for both key is same at client server and remote server');
                echo maybe_serialize($resp);
            }





            //does the user exist?


            exit(0);
        }
    }

}

AuthServerHelper::get_instance(); //instantiate the helper
   



