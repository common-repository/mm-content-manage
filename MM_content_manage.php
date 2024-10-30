<?php
/*
Plugin Name: MM Content Manage
Plugin URI: http://plugin.sipl.it/mm-cm/
Description:  Visualizza in homepage e nella pagina degli archivi un riassunto per ogni articolo. Se l'utente &egrave; loggato verr&agrave visualizzato il post completo.
Version: 1.1
Author: Mancabelli M
Author URI: http://plugin.sipl.it
*/

function MMContentManage_filter($text) {
 
	global $current_user;
  $MMCM_show_option = get_post_meta( get_the_ID(), '_mm_content_manage_option', true );
  $MMCM_show_cap = get_post_meta( get_the_ID(), '_mm_content_manage_cap', true );
	//return $text;

	if(strpos($text,'[MORE]') > 0){
		$parts = explode("[MORE]",$text);		
		$excerpt = $parts[0]." [...]";
		$content = str_replace("[MORE]","",$text);
	}
	else{
		$parts = explode(" ",$text);
		array_splice($parts, 20);
		$excerpt = implode(" ",$parts)." [...]";
		$content = $text;
	}
  if(is_home() || is_archive()){
  	if($MMCM_show_option == "EXCERPT" || $MMCM_show_option == "PRIVATE")
      return $excerpt;
    else
      return $content;
  }
  else{
    if($MMCM_show_option == "PRIVATE"){
      if(current_user_can($MMCM_show_cap))
    	return $content;
      else
        return $excerpt." ".__('<p><strong>Il contenuto completo &egrave; riservato agli utenti registrati.</strong></p>','MM-content-manage');
    }
    else{
    	return $content;
    }
  }
}

// Apply the filters, to get things going
add_filter('the_content', 'MMContentManage_filter');

//MetaBOX
add_action( 'add_meta_boxes', 'MMContentManage_add_CustBox' );

// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'myplugin_add_custom_box', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'MMContentManage_save_postdata' );

load_plugin_textdomain('MM-content-manage', false, 'mm-content-manage/languages');


/* Adds a box to the main column on the Post and Page edit screens */
function MMContentManage_add_CustBox() {
    $screens = array( 'post', 'page' );
    foreach ($screens as $screen) {
        add_meta_box(
            'mm_content_manage_id',
            __( 'Opzioni di Pubblicazione', 'MM-content-manage' ),
            'MMContentManage_inner_custom_box',
            $screen
        );
    }
}

/* Prints the box content */
function MMContentManage_inner_custom_box($post) {

  // Use nonce for verification
  //wp_nonce_field( plugin_basename( __FILE__ ), 'MMContentManage_Setup' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $value = get_post_meta( $post->ID, '_mm_content_manage_option', true );
  $capabil = get_post_meta( $post->ID, '_mm_content_manage_cap', true );
  
  echo '<label>'.__("Nella home mostra: ", 'MM-content-manage' ).'</label>';    
	//'.esc_attr($value).'
  echo '<p><input type="radio" id="MM_content_manage_radio_content" name="MM_content_manage_radio" value="CONTENT" '.MM_checked($value,"CONTENT").'/> <label for="MM_content_manage_radio_content">'.__( 'Testo completo.', 'MM-content-manage' ).'</label></p>';
  echo '<p><input type="radio" id="MM_content_manage_radio_excerpt" name="MM_content_manage_radio" value="EXCERPT" '.MM_checked($value,"EXCERPT").'/> <label for="MM_content_manage_radio_excerpt">'.__( 'Riassunto.', 'MM-content-manage' ).'</label></p>';
  echo '<p><input type="radio" id="MM_content_manage_radio_private" name="MM_content_manage_radio" value="PRIVATE" '.MM_checked($value,"PRIVATE").'/> <label for="MM_content_manage_radio_private">'.__( 'Riassunto e testo riservato a:', 'MM-content-manage' ).'</label> ';

  echo '<select name="MM_content_manage_text_cap" id="MM_content_manage_text_cap"><option value="0">'.__('--scegli--','MM-content-manage').'</option>';
  
  global $wp_roles; 
  $roles = $wp_roles->roles;
  foreach($roles as $role){
    foreach($role['capabilities'] as $k => $v){
  		$caps[$k] = $k;
    }
  }
  foreach($caps as $item){
    if ($capabil == $item)
      $ch = ' selected';
    else
      $ch = '';
    
    echo '<option value="'.$item.'"'.$ch.'>'.$item.'</option>';
  }
  echo '</select></p>';
}

function MM_checked($OrVal,$ChVal){
	if($OrVal == $ChVal)
		return "checked";
	else
    	return "";
}

// When the post is saved, saves our custom data 
function MMContentManage_save_postdata( $post_id ) {

  // First we need to check if the current user is authorised to do this action. 
  if ( 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
  }

  //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  //sanitize user input
  $mydata = sanitize_text_field( $_POST['MM_content_manage_radio'] );
  $mycap = sanitize_text_field( $_POST['MM_content_manage_text_cap'] );

  // Do something with $mydata 
  // either using 
  add_post_meta($post_ID, '_mm_content_manage_option', $mydata, true) or
    update_post_meta($post_ID, '_mm_content_manage_option', $mydata);

  add_post_meta($post_ID, '_mm_content_manage_cap', $mycap, true) or
    update_post_meta($post_ID, '_mm_content_manage_cap', $mycap);
  
  // or a custom table (see Further Reading section below)
}

?>