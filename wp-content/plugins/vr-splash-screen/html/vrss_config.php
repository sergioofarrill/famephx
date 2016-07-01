<div class="wrap">

	<div id="icon-options-general" class="icon32"><br/></div>
    <h2><?php _e('Configuration du Splash Screen', 'vr-splash-screen');?></h2>
	
	<?php if ($_GET["updated"] == "true"): ?>
		<div class="updated settings-error" id="setting-error-settings_updated"> 
			<p><strong><?php _e('Options enregistrées', 'vr-splash-screen');?>.</strong></p>
		</div>
	<?php endif; ?>
	
	<p><?php _e('Configurez ici votre Splash Screen', 'vr-splash-screen');?>.</p>
	
    <form method="post" action="">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="activer_ss"><?php _e('Activer le Splash Screen', 'vr-splash-screen');?> :</label>
				</th>
				<td>
					<input type="checkbox" name="activer_ss" id="activer_ss" <?php if (get_option('activer_ss', 'off') == 'on') echo 'checked'; ?> />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="cookie_ss"><?php _e('Durée du cookie (en seconde)', 'vr-splash-screen');?> :</label>
				</th>
				<td>
					<input type="text" class="regular-text code" name="cookie_ss" id="cookie_ss" value="<?php echo get_option('cookie_ss', 86400); ?>" />
				</td>
			</tr>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="background_color_ss"><?php _e('Couleur de fond', 'vr-splash-screen');?> :</label>
				</th>
				<td>
					<input type="text" class="regular-text code" name="background_color_ss" id="background_color_ss" value="<?php echo get_option('background_color_ss', "#000"); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="upload_image_ss"><?php _e('Image du Splash Screen', 'vr-splash-screen');?> :</label>
				</th>
				<td>
					<label for="upload_image_ss">
						<input id="upload_image_ss" type="text" size="36" name="upload_image_ss" value="" />
						<input id="upload_image_button" type="button" value="<?php _e('Upload Image', 'vr-splash-screen');?>" />
						<br /><?php _e("Entrez l'URL ou uploadez une nouvelle image", 'vr-splash-screen');?>.
					</label>
					
					<?php if (get_option('upload_image_ss', '') != ''):?>
						<br/><img src="<?php echo get_option('upload_image_ss');?>" height="100" alt="" />
					<?php endif; ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="bg_position_ss"><?php _e('Background position (CSS)', 'vr-splash-screen');?> : </label>
				</th>
				<td>
					<input type="text" class="regular-text code" name="bg_position_ss" id="bg_position_ss" value="<?php echo get_option('bg_position_ss', "center top"); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="etirer_image_ss"><?php _e("Ou étirer l'image à 100%", 'vr-splash-screen');?> :</label>
				</th>
				<td>
					<input type="checkbox" name="etirer_image_ss" id="etirer_image_ss" <?php if (get_option('etirer_image_ss', 'off') == 'on') echo 'checked'; ?> />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="url_redirect_ss"><?php _e('URL de redirection', 'vr-splash-screen');?> :</label>
				</th>
				<td>
					<input type="text" class="regular-text code" name="url_redirect_ss" id="url_redirect_ss" value="<?php echo get_option('url_redirect_ss', ""); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="url_redirect_ss"><?php _e('Texte du bouton de sortie', 'vr-splash-screen');?> :</label>
				</th>
				<td>
					<input type="text" class="regular-text code" name="acceder_button_ss" id="acceder_button_ss" value="<?php echo get_option('acceder_button_ss', "Accéder directement au site"); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="css_ss"><?php _e('CSS supplémentaire', 'vr-splash-screen');?> :</label>
				</th>
				<td>
					<textarea cols="50" rows="10" class="large-text code" name="css_ss" id="css_ss"><?php echo get_option('css_ss', ""); ?></textarea>
					<br/>
					<?php _e('La balise &lt;body&gt; de la Splash Screen a la classe CSS suivante : <i>splash_screen</i><br/>Vous pouvez donc mettre en forme facilement grâce aux CSS.', 'vr-splash-screen');?>
				</td>
			</tr>
		</table>
		
		<p class="submit">
			<input type="submit" class="button-primary" name="valider" value="<?php _e('Enregistrer les modifications', 'vr-splash-screen');?>" />
		</p>
	</form>
	
	
</div>