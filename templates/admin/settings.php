<link rel="stylesheet" href="<?php echo Kanban::get_instance()->settings->uri ?>/css/admin.css">



<div class="wrap">
	<h1>
		<?php echo __(sprintf('%s Settings', Kanban::get_instance()->settings->pretty_name), 'kanban') ?>
		<a href="<?php echo sprintf( '%s/%s/board', home_url(), Kanban::$slug ) ?>" class="page-title-action" target="_blank" id="btn-go-to-board" onclick="window.open('<?php echo sprintf( '%s/%s/board', home_url(), Kanban::$slug ) ?>', 'kanbanboard'); return false;">
			<?php echo __('Go to your board', 'kanban') ?>
		</a>

	</h1>

<?php if ( isset($_GET['message']) ) : ?>
	<div class="updated">
		<p><?php echo $_GET['message'] ?></p>
	</div>
<?php endif // message ?>

	<h2 class="nav-tab-wrapper">
		<a href="#tab-settings" class="nav-tab nav-tab-active"><?php echo __('Settings', 'kanban' ) ?></a>
		<a href="#tab-users" class="nav-tab"><?php echo __('Users', 'kanban' ) ?></a>
		<a href="#tab-statuses" class="nav-tab"><?php echo __('Statuses', 'kanban' ) ?></a>
		<a href="#tab-estimates" class="nav-tab"><?php echo __('Estimates', 'kanban' ) ?></a>
		<?php
		echo apply_filters('kanban_settings_tabs', '' );
		?>
	</h2>



	<form action="" method="post">

		<div class="tab" id="tab-settings">

			<table class="form-table">
				<tbody>
					<tr>
						<th width="33%" scope="row">
							<label for="hour_interval">
								<?php echo __('Work hour interval', 'kanban' ) ?><br>
								<small><?php echo __('in hours', 'kanban' ) ?></small>
							</label>
						</th>
						<td>
							<input name="settings[hour_interval]" type="text" id="hour_increment" value="<?php echo isset($settings['hour_interval']) ? $settings['hour_interval'] : 1 ?>" class="regular-text">
							<p class="description">
								<?php echo __('Example: If you want to track work in 10 minute increments, enter ".1667" here.', 'kanban' ) ?>
							</p>
						</td>
					</tr>
					<tr>
						<th width="33%" scope="row">
							<?php echo __('Show all columns all the time', 'kanban' ) ?>
						</th>
						<td>


							<div class="switch-field">
								<input type="radio" id="show_all_cols_1" name="settings[show_all_cols]" value="1" <?php echo (bool) $settings['show_all_cols'] ? 'checked' : '' ?>>
								<label for="show_all_cols_1">Yes</label>
								<input type="radio" id="show_all_cols_0" name="settings[show_all_cols]" value="0" <?php echo !(bool) $settings['show_all_cols'] ? 'checked' : '' ?>>
								<label for="show_all_cols_0">No</label>
							</div>

							<p class="clear description">
								<?php echo __('This disables hiding the first and last status columns.', 'kanban' ) ?>
							</p>
						</td>
					</tr>
					<tr>
						<th width="33%" scope="row">
							<?php echo __('Default the view to "compact"', 'kanban' ) ?>
						</th>
						<td>
							<div class="switch-field">
								<input type="radio" id="default_to_compact_view_1" name="settings[default_to_compact_view]" value="1" <?php echo (bool) $settings['default_to_compact_view'] ? 'checked' : '' ?>>
								<label for="default_to_compact_view_1">Yes</label>
								<input type="radio" id="default_to_compact_view_0" name="settings[default_to_compact_view]" value="0" <?php echo !(bool) $settings['default_to_compact_view'] ? 'checked' : '' ?>>
								<label for="default_to_compact_view_0">No</label>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<?php submit_button(
				__('Save your Settings', 'kanban'),
					'primary',
					'submit'
			) ?>
		</div><!-- tab-settings -->



		<div class="tab" id="tab-users" style="display: none;">

			<table class="form-table">
				<tbody>
					<tr>
						<th width="33%" scope="row">
							<label for="default_estimate">
								<?php echo __('Allowed users', 'kanban' ) ?><br>
								<small>
									<?php echo __('(Users who can make changes to the board)', 'kanban' ) ?>
								</small>
							</label>
						</th>
						<td>
							<fieldset>
<?php foreach ($all_users_arr as $user_id => $user_name) : ?>
								<label>
									<input name="settings[allowed_users][]" type="checkbox" value="<?php echo $user_id ?>" <?php echo isset($settings['allowed_users']) ? in_array($user_id, $settings['allowed_users']) ? 'checked' : '' : '' ?>>
									<?php echo $user_name ?>
								</label><br>
<?php endforeach // $all_users_arr ?>
							</fieldset>
						</td>
					</tr>

					<tr>
						<th width="33%" scope="row">
							<label for="default_assigned_to">
								<?php echo __('Assign all tasks to', 'kanban' ) ?>
							</label>
						</th>
						<td>
							<select  name="settings[default_assigned_to]" style="min-width: 10em;">
<?php foreach ($all_users_arr as $user_id => $user_name) : ?>
								<option value="<?php echo $user_id ?>" <?php echo isset($settings['default_assigned_to']) ? $user_id == $settings['default_assigned_to'] ? 'selected' : '' : '' ?>>
									<?php echo $user_name ?>
								</option>
<?php endforeach // $all_users_arr ?>
								<option value="" <?php echo !isset($settings['default_assigned_to']) || empty($settings['default_assigned_to']) ? 'selected' : '' ?>>
									<?php echo $user_name ?>
								</option>
							</select>
						</td>
					</tr>

					<?php echo apply_filters( 'kanban_settings_tab_users_content', '' ); ?>

				</tbody>
			</table>

			<?php submit_button(
				__('Save your Settings', 'kanban'),
					'primary',
					'submit'
			) ?>
		</div><!-- tab-users -->



		<div class="tab" id="tab-statuses" style="display: none;">

			<ol id="list-statuses" class="sortable">
<?php foreach ($statuses as $status_id => $status) : ?>
				<?php echo Kanban_Template::render_template('admin/t-status', (array) $status) ?>
<?php endforeach // statuses ?>
			</ol><!-- sortable -->
			<p>
				<button type="button" class="button" id="add-status">
					<?php echo __('Add another status', 'kanban') ?>
				</button>
			</p>

			<?php submit_button(
				__('Save your Settings', 'kanban'),
					'primary',
					'submit'
			) ?>
		</div><!-- tab-statuses -->



		<div class="tab" id="tab-estimates" style="display: none;">

			<ol id="list-estimates" class="sortable">
<?php foreach ($estimates as $estimate_id => $estimate) : ?>
				<?php echo Kanban_Template::render_template('admin/t-estimate', (array) $estimate) ?>
<?php endforeach // statuses ?>
			</ol><!-- sortable -->
			<p>
				<button type="button" class="button" id="add-estimate">
					<?php echo __('Add another estimate', 'kanban') ?>
				</button>
			</p>


			<table class="form-table">
				<tbody>
					<tr>
						<th width="33%" scope="row">
							<label for="hour_interval">
								<?php echo __('Default estimate', 'kanban' ) ?>
							</label>
						</th>
						<td>
							<select  name="settings[default_estimate]" style="min-width: 10em;">
<?php foreach ($estimates as $estimate_id => $estimate) : ?>
								<option value="<?php echo $estimate->id ?>" <?php echo isset($settings['default_estimate']) ? $estimate->id == $settings['default_estimate'] ? 'selected' : '' : '' ?>>
									<?php echo $estimate->title ?>
								</option>
<?php endforeach // $estimates ?>
							</select>
						</td>
					</tr>

					<?php echo apply_filters( 'kanban_settings_tab_estimates_content', '' ); ?>

				</tbody>
			</table>

			<?php submit_button(
				__('Save your Settings', 'kanban'),
					'primary',
					'submit'
			) ?>
		</div><!-- tab-estimates -->



		<?php echo apply_filters( 'kanban_settings_tabs_content', '' ); ?>



		<?php wp_nonce_field( 'kanban-options', Kanban_Utils::get_nonce() ); ?>

	</form>



</div><!-- wrap -->



<script type="text/html" id="t-status">

<?php include sprintf('%s/t-status.php', __DIR__) ?>

</script>

<script type="text/html" id="t-estimate">

<?php include sprintf('%s/t-estimate.php', __DIR__) ?>

</script>

