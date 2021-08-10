<?php
/*
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 * 
 */

/*
 * @author Sylwester Zdanowski
 */

/* CONFIGURATION */

function custom_plugin_register_settings() {

register_setting('lms_plugin_options_group', 'lms_url');
register_setting('lms_plugin_options_group', 'lms_class');
register_setting('lms_plugin_options_group', 'lms_verifyhost');
register_setting('lms_plugin_options_group', 'lms_verifypeer');

register_setting('lms_plugin_options_group', 'lms_data_format');

register_setting('lms_plugin_options_group', 'lms_enablestock');
register_setting('lms_plugin_options_group', 'lms_enablegenieacs');

}
add_action('admin_init', 'custom_plugin_register_settings');

add_action( 'admin_menu', 'lms_plugin_menu' );


function lms_plugin_menu() {
	add_options_page( 'LMS configuration', 'LMS configuration', 'manage_options', 'lms-configuration', 'lms_plugin_options' );
}


function lms_plugin_options() {

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
   <div class="wrap">
        <h2>LMS Plugin Setting</h2>
        <form method="post" action="options.php">
            <?php settings_fields('lms_plugin_options_group'); ?>
 
        <table class="form-table">
            <tr>
                <th><label for="lms_url_id">LMS url:</label></th>
                <td>
<input type = 'text' class="regular-text" id="lms_url_id" name="lms_url" value="<?php echo get_option('lms_url'); ?>">
                </td>
            </tr>
            <tr>
                <th><label for="lms_class_id">LMS class:</label></th>
                <td>
<input type = 'text' class="regular-text" id="lms_class_id" name="lms_class" value="<?php echo get_option('lms_class'); ?>">
                </td>
            </tr>
            <tr>
                <th><label for="lms_class_id">LMS data format:</label></th>
                <td>
<input type = 'text' class="regular-text" id="lms_data_format_id" name="lms_data_format" value="<?php echo get_option('lms_data_format'); ?>">
                </td>
            </tr>
            <tr>
                <th><label for="lms_verifyhost_id">Verifyhost:</label></th>
                <td>
					<SELECT size="1" id="lms_verifyhost_id" name="lms_verifyhost">
            			<OPTION VALUE="0"<?php if(!get_option('lms_verifyhost')){echo 'SELECTED';}?>>Disable</OPTION>
           				<OPTION value="1"<?php if(get_option('lms_verifyhost')==1){echo 'SELECTED';}?>>Enable</OPTION>
					</SELECT>
                </td>
            </tr>
            <tr>
                <th><label for="lms_verifypeer_id">Verify peer:</label></th>
                <td>
					<SELECT size="1" id="lms_verifypeer_id" name="lms_verifypeer">
            			<OPTION VALUE="0"<?php if(!get_option('lms_verifypeer')){echo 'SELECTED';}?>>Disable</OPTION>
           				<OPTION value="1"<?php if(get_option('lms_verifypeer')==1){echo 'SELECTED';}?>>Enable</OPTION>
					</SELECT>
                </td>
            </tr>
            <tr>
                <th><label for="lms_verifyhost_id">Stock (Required plugin in LMS):</label></th>
                <td>
					<SELECT size="1" id="lms_enablestock_id" name="lms_enablestock">
            			<OPTION VALUE="0"<?php if(!get_option('lms_enablestock')){echo 'SELECTED';}?>>Disable</OPTION>
           				<OPTION value="1"<?php if(get_option('lms_enablestock')==1){echo 'SELECTED';}?>>Enable</OPTION>
					</SELECT>
                </td>
            </tr>
            <tr>
                <th><label for="lms_verifyhost_id">GenieACS (Required plugin in LMS):</label></th>
                <td>
					<SELECT size="1" id="lms_enablegenieacs_id" name="lms_enablegenieacs">
            			<OPTION VALUE="0"<?php if(!get_option('lms_enablegenieacs')){echo 'SELECTED';}?>>Disable</OPTION>
           				<OPTION value="1"<?php if(get_option('lms_enablegenieacs')==1){echo 'SELECTED';}?>>Enable</OPTION>
					</SELECT>
                </td>
            </tr>
		<?php echo $html ?>
        </table>
        <?php submit_button(); ?>
 
    </div>
<?php 

}
?>
