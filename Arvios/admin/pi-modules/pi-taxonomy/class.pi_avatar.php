<?php 
class piAvatar extends piCore 
{
    public function __construct()
    {
        // Add upload photo
        add_action( 'personal_options', array($this, 'pi_profile_fields') );
        add_action( 'personal_options_update', array($this,'pi_profile_update') );    
        add_action( 'edit_user_profile_update', array($this,'pi_profile_update') );
        add_action('admin_enqueue_scripts', array($this,'pi_enqueue_scripts'));
    }

    public function pi_profile_fields( $user ) {
        
        $meta_value = get_user_meta( $user->ID, '_pi_avatar', true ); 
      
        $meta_value = !empty($meta_value) ? $meta_value : 'http://placehold.it/240x240';
        ?>
        <table class="form-table">
            <tr>
                <th>
                    <label for="tc_location"><?php _e('Avatar', 'wiloke'); ?></label>
                </th>
                <td>
                    <button class="roll_upload js_upload single button button-primary" data-geturl="true" data-use="siblings" data-method="html" data-insertto=".rwmb-images">Upload</button>
                    <input type="text" value="<?php echo esc_attr( $meta_value ); ?>" name="avatar" />
                    <div class="rwmb-images rwmb-uploaded" style="margin-top: 20px">
                        <?php 
                            printf('<img src="%s" width="150"  height="150" alt="">', esc_url($meta_value));
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        <?php
    }

    public function pi_profile_update($user_id)
    {
        if ( current_user_can('edit_user',$user_id) )
        {   

            if ( isset($_POST['avatar']) && !empty($_POST['avatar']) )
            {
                update_user_meta($user_id, "_pi_avatar", $_POST['avatar']);
            }
        }
    }

    public function pi_enqueue_scripts()
    {
        $screen = get_current_screen();
        
        if ( isset($screen->id) && ($screen->id == 'profile' || $screen->id == 'user-edit') )
        {
            $piUrl = get_template_directory_uri() . '/admin/pi-assets/';
            wp_register_style('pi_profile', $piUrl . 'css/profile.css', array(), '1.0');
            wp_enqueue_style('pi_profile');
            wp_enqueue_media();
        }
    }
    

}