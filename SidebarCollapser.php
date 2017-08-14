<?php
/*
Plugin Name: Sidebar Widget Collapser
Plugin URI: http://freepressblog.org/wordpress-plugins-2/sidebar-widget-collapser/
Description: Collapses Sidebar
Author: Jared Bangs
Author URI: http://freepressblog.org/
Version: 1.4
*/


function fp_sidebarcollapse_prepare_scripts() {

    $fp_sidebarcollapse_version = '1.4';

    $options = get_option('fp_sidebarcollapse');

	// Initialize defaults
	if ( !is_array($options) ) {
		$options = array('sidebarID'=>'sidebar',
			'sidebarListEl'=>'UL',
			'sidebarListItemEl'=>'LI',
			'sidebarListItemPartialClassName'=>'widget',
			'sidebarWidgetTitlePartialClassName'=>'widgettitle',
			'show'=>' [+]',
			'hide'=>' [-]',
            'widgetidsdefaultcollapse' => ''
		);
	}

    //$_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
    $_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR;

    wp_enqueue_script('sidebarcollapser_script', $_url.'/sidebar-widget-collapser/SidebarCollapserScript.js', array('scriptaculous-effects'), $fp_sidebarcollapse_version);

    wp_localize_script( 'sidebarcollapser_script', 'SBCS', array(
        'sidebarID' => $options['sidebarID'],
        'sidebarListEl' => $options['sidebarListEl'],
        'sidebarListItemEl' => $options['sidebarListItemEl'],
        'sidebarListItemPartialClassName' => $options['sidebarListItemPartialClassName'],
        'sidebarWidgetTitlePartialClassName' => $options['sidebarWidgetTitlePartialClassName'],
        'show' => $options['show'],
        'hide' => $options['hide'],
        'widgetidsdefaultcollapse' => $options['widgetidsdefaultcollapse']
        ));
}

/* Admin Stuff -- BEGIN */

function fp_sidebarcollapse_admin_page() {
	add_options_page('Sidebar Collapser', 'Sidebar Collapser',10, "SidebarCollapser", 'SidebarCollapser_admin');
}

function SidebarCollapser_admin() {

	// Get our options and see if we're handling a form submission.
	$options = get_option('fp_sidebarcollapse');

	// Initialize defaults
	if ( !is_array($options) ) {
		$options = array('sidebarID'=>'sidebar',
			'sidebarListEl'=>'UL',
			'sidebarListItemEl'=>'LI',
			'sidebarListItemPartialClassName'=>'widget',
			'sidebarWidgetTitlePartialClassName'=>'widgettitle',
			'show'=>' [+]',
			'hide'=>' [-]',
            'widgetidsdefaultcollapse' => ''
		);
	}

	// Process the post to update the options
	if ( $_POST['fp_sidebarcollapse_options_save'] ) {

		// Remember to sanitize and format use input appropriately.
		$options['sidebarID'] = strip_tags(stripslashes($_POST['sidebarID']));
		$options['sidebarListEl'] = strip_tags(stripslashes($_POST['sidebarListEl']));
		$options['sidebarListItemEl'] = strip_tags(stripslashes($_POST['sidebarListItemEl']));
		$options['sidebarListItemPartialClassName'] = strip_tags(stripslashes($_POST['sidebarListItemPartialClassName']));
		$options['sidebarWidgetTitlePartialClassName'] = strip_tags(stripslashes($_POST['sidebarWidgetTitlePartialClassName']));
		$options['show'] = strip_tags(stripslashes($_POST['sidebarShow']));
		$options['hide'] = strip_tags(stripslashes($_POST['sidebarHide']));
		$options['widgetidsdefaultcollapse'] = strip_tags(stripslashes($_POST['widgetidsdefaultcollapse']));

		update_option('fp_sidebarcollapse', $options);
	}

	?>

	<div class="wrap">
		<h2>Sidebar Collapser</h2>

		<form name="fp_sidebarcollapse_options" action="options-general.php?page=SidebarCollapser" method="POST" id="fp_sidebarcollapse_options">
  			<fieldset>
  				<!--<legend></legend>-->

					<p><label for="sidebarID">Sidebar IDs: <input style="width: 200px;" id="sidebarID" name="sidebarID" type="text" value="<?php echo $options['sidebarID']; ?>" /></label></p>
                    <p>Comma separated list of IDs. If you have only one, it could be "sidebar". If you have two, it may be "primary,secondary".</p><br />
					<p><label for="sidebarListEl">Sidebar List Element: <input style="width: 200px;" id="sidebarListEl" name="sidebarListEl" type="text" value="<?php echo $options['sidebarListEl']; ?>" /></label></p>
					<p><label for="sidebarListItemEl">Sidebar Widget List Item Element: <input style="width: 200px;" id="sidebarListItemEl" name="sidebarListItemEl" type="text" value="<?php echo $options['sidebarListItemEl']; ?>" /></label></p>
					<p><label for="sidebarListItemPartialClassName">Sidebar Widget List Item Partial Class Name: <input style="width: 200px;" id="sidebarListItemPartialClassName" name="sidebarListItemPartialClassName" type="text" value="<?php echo $options['sidebarListItemPartialClassName']; ?>" /></label></p>
					<p><label for="sidebarWidgetTitlePartialClassName">Sidebar Widget Title Partial Class Name: <input style="width: 200px;" id="sidebarWidgetTitlePartialClassName" name="sidebarWidgetTitlePartialClassName" type="text" value="<?php echo $options['sidebarWidgetTitlePartialClassName']; ?>" /></label></p>
					<p><label for="sidebarShow">Show Link: <input style="width: 200px;" id="sidebarShow" name="sidebarShow" type="text" value="<?php echo $options['show']; ?>" /></label></p>
					<p><label for="sidebarHide">Hide Link: <input style="width: 200px;" id="sidebarHide" name="sidebarHide" type="text" value="<?php echo $options['hide']; ?>" /></label></p>
					<p><label for="widgetidsdefaultcollapse">Widget IDs to collapse by default: <input style="width: 200px;" id="widgetidsdefaultcollapse" name="widgetidsdefaultcollapse" type="text" value="<?php echo $options['widgetidsdefaultcollapse']; ?>" /></label></p>

  			</fieldset>
			<br />
  			<input type="submit" name="fp_sidebarcollapse_options_save" value="Save" class="button" style="font-size: 140%"  />
		</form>
	</div>

<?php }

/* Admin Stuff -- END */

if (function_exists('add_action')) {
    fp_sidebarcollapse_prepare_scripts();
    add_action('admin_menu', 'fp_sidebarcollapse_admin_page');
}

?>