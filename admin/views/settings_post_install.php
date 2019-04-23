<style type="text/css">
  form {
  background: #fff;
  padding: 10px;
  margin: 10px;
  border: 1px solid #dadada;
  }
  .flex_container {
    display:flex;
    flex-wrap: wrap;
   }
  .half_width{
    flex: 0 0 46%; /* fg: 0, fs: 0, fb: 100% */
    margin: 1%;
    padding: 1%;
    clear:none;
    background: rgb(239, 239, 239);	
  }
  .full_width {
    flex: 0 0 96%; /* fg: 0, fs: 0, fb: 100% */
    margin: 1%;
    padding: 1%;
    clear:none;
    background: rgb(239, 239, 239);	
  }
  li {
    margin-left: 20px;
    list-style: disc;
  }
  button {
  margin:5px!important;
  }
  .imported {
    background: red!important;
  }
  
</style>
<script type="text/javascript">
function cnrswebkit_default_content_load(form) {
    if (confirm("Are you sure you want import/load CNRS Webkit default content?")) {
    form.submit();
    }
}
</script>

<form method="post">
	<h2><?php _e('CNRS Webkit Post-install/Upgrade Settings :','cnrswebkit'); ?></h2>
    <div class="flex_container">
       <div class ="half_width">
        	<b><?php _e('Load default Pods values','cnrswebkit'); ?></b><br/><br/>
        	<p>
        	Coming soon (only for fresh install)
        	</p>
        	<ul>
        		<li>-----</li>
        		<li>-------</li>
        	</ul>
        	</p>
        </div> 
       <div class ="half_width">
        	<b><?php _e('Import default cnrswebkit content (pages, news, events, contacts...)','cnrswebkit'); ?></b><br/><br/>
        	<?php
        	$cnrswebkit_default_content_load = get_transient( 'cnrswebkit_default_content_load');

    	    global $wp_filesystem;
    	    // Initialize the WP filesystem
    	    if (empty($wp_filesystem)) {
    	        require_once (ABSPATH . '/wp-admin/includes/file.php');
    	        WP_Filesystem();
    	    }
    	    $files = $wp_filesystem->dirlist(CNRS_WEBKIT_DIR . '/assets/content');
    	    $default_contents= array(); 
    	    $some_content_to_import=false;
    	    foreach ($files as $file) {
    	        if ('xml' === pathinfo($file['name'], PATHINFO_EXTENSION)) {
    	            $filename = pathinfo($file['name'], PATHINFO_FILENAME);
    	            
    	            if ($cnrswebkit_default_content_load) {
    	                set_transient ('cnrswebkit_default_content_load'.$filename, true);
    	                $default_contents[$filename] = true;
    	                $some_content_to_import=true;
    	            } else {
    	                $default_contents[$filename] = get_transient ('cnrswebkit_default_content_load'.$filename);
    	                if ($default_contents[$filename] ) {
    	                    $some_content_to_import=true;
    	                }
    	            }
    	        }
    	    }
    	    if ($cnrswebkit_default_content_load) {
    	        // Delete the global transient cnrswebkit_default_content_load
    	        delete_transient( 'cnrswebkit_default_content_load');
    	    }
        	?>
        	<ul>
            	<?php 
            	if (! $some_content_to_import) {
            	?>
             		<li style="color:red;" ><?php _e('Importing default content is only proposed at CNRS webkit install.','cnrswebkit'); ?></li>
             		<li style="color:red;" ><?php _e('This is not your case so it seems that you don\'t need this feature. Nevertheless, the import feature is provided below in case you really need it.','cnrswebkit'); ?></li>
            	<?php     
            	} 
                ?>
                <li><?php _e('This will import and load all content usefull for testing the CNRS Webkit on a fresh Wordpress install','cnrswebkit'); ?></li>
         		<li><?php _e('This will not erase existing content','cnrswebkit'); ?></li>
         		<li><?php _e('This should not duplicate existing content','cnrswebkit'); ?></li>
          	</ul>
        	<?php 
        	echo '<p style = "color:#0085ba;">'. __('Blue button correspond to content that were not already imported','cnrswebkit') . '</p>';
        	foreach ($default_contents as $file => $to_import) {
        	    $class = $default_contents[$filename]? 'imported':'';
        	   echo '<button type="submit" name="default_content_load" class="button button-primary ' . $class . '" value="' . $file . '">' . 
                    $file . '</button>'; 
        	}
        	?>
        	<?php echo '<p style = "color:red;">'. __('Red button correspond to content already imported','cnrswebkit') . '</p>'; ?>
        </div>
		<div class ="half_width">
        	<b><?php _e('Reorder Pods fields in "template settings"','cnrswebkit'); ?></b><br/><br/>
        	<p>
        		<?php _e('When updating CNRS Webkit theme, and when new field are added to pods "Template settings"; these new fields appears at the end of the list. There is 2 ways to reorder fields inside "Template settings"','cnrswebkit'); ?><br />
        	</p>
        	<ul>
        		<li>
        			<a href="/wp-admin/admin.php?page=pods"><?php _e('Manual reordering of pods : ','cnrswebkit'); ?></a> 
        			<?php /* Translators: additionnal text for "Manual reordering of pods" link */ _e('is achieved by dragging and dropping fields in pods administration','cnrswebkit'); ?>
        			
        		</li>
        		<li><?php _e('Automatic reordering of pods fields: this uses the fields order defined in CNRS Webkit theme. Be aware that <strong>automatic reordering will remove your proper manual ordering !</strong>','cnrswebkit'); ?></li>
        	</ul>
        	</p>
        	<button type="submit" name="Reorder_template_settings_Pods" class="button button-primary button-large" value="Reorder_template_settings_Pods"><?php _e('Automatic reorder pods fields', 'cnrswebkit'); ?></button>
        </div>       
        <div class ="full_width">
        	<b>TODO (coming soon) ! </b><br/><br/>
        	<p>
        	Mise à jour des traductions des pods à partir des traductions du thème CNRS (sans surcharger/effacer les traduction de l'utilisateur)
        	</p>
        </div>
        </div>

        <?php wp_nonce_field('settings_post_install'); ?>	
    </div>
</form>
