<?php
/**
 * class thesis_term_options
 *
 * @package Thesis
 * @since 1.8
 */
class thesis_term_options {
	var $table_name = 'thesis_terms';
	var $options = array(
		'head' => array(
			'heading' => '<acronym title="Search Engine Optimization">SEO</acronym> Details',
			'options' => array(
				'title' => array(
					'type' => 'text',
					'label' => 'Title Tag <code>&lt;title&gt;</code>',
					'description' => '',
					'counter' => 'Search engines allow a maximum of 70 characters for the title.'
				),
				'description' => array(
					'type' => 'textarea',
					'label' => 'Meta Description <code>&lt;meta&gt;</code>',
					'description' => '',
					'counter' => 'Search engines allow a maximum of roughly 150 characters for the description.'
				),
				'keywords' => array(
					'type' => 'text',
					'label' => 'Meta Keywords <code>&lt;meta&gt;</code>',
					'description' => ''
				),
				'robots' => array(
					'type'=> 'checkbox',
					'options' => array(
						'noindex' => '<code>noindex</code> this page',
						'nofollow' => '<code>nofollow</code> this page',
						'noarchive' => '<code>noarchive</code> this page',
					),
					'label' => 'Robots Meta Tags <code>&lt;meta&gt;</code>'
				)
			)
		),
		'body' => array(
			'heading' => '',
			'options' => array(
				'headline' => array(
					'type' => 'text',
					'label' => 'Introductory Headline',
					'description' => ''
				),
				'content' => array(
					'type' => 'textarea',
					'label' => 'Introductory Content',
					'description' => ''
				)
			)
		)
	);

	function actions() {
		add_action('create_term', array($this, 'create_term'));
		add_action('edit_terms', array($this, 'edit_term'));
		add_action('delete_term', array($this, 'delete_term'));
		add_action('category_add_form_fields', array($this, 'option_fields'));
		add_action('edit_category_form_fields', array($this, 'option_fields'));
		add_action('add_tag_form_fields', array($this, 'option_fields'));
		add_action('edit_tag_form_fields', array($this, 'option_fields'));
	}

	function create_table() {
		global $wpdb;
		$table = $wpdb->prefix . $this->table_name;

		if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
			$create_table = "CREATE TABLE `$table` (
				`option_id` bigint(20) NOT NULL auto_increment,
				`term_id` bigint(20) NOT NULL default '0',
				`name` varchar(100) NOT NULL,
				`taxonomy` varchar(32) NOT NULL,
				`title` varchar(256) NOT NULL,
				`description` varchar(256) NOT NULL,
				`keywords` varchar(256) NOT NULL,
				`robots` varchar(100) NOT NULL,
				`headline` varchar(256) NOT NULL,
				`content` longtext NOT NULL,
				PRIMARY KEY (`option_id`)
			) COLLATE utf8_general_ci;";
		    $wpdb->query($create_table);
		}
	}

	function get_terms() {
		global $wpdb; #wp
		$table = $wpdb->prefix . $this->table_name; #wp
		
		$terms = $wpdb->get_results("SELECT * FROM $table ORDER BY option_id ASC", ARRAY_A); #wp
		if ($terms) {
			foreach ($terms as $term) {
				foreach ($term as $option => $value) {
					$value = (is_serialized($value)) ? unserialize($value) : $value; #wp
					$this->terms[$term['taxonomy']][$term['term_id']][$option] = $value;
				}
			}
		}
	}

	function create_term($term_id) {
		global $wpdb, $thesis_site; #wp
		$table = $wpdb->prefix . $this->table_name; #wp
		$type = ($_POST['taxonomy'] == 'category') ? 'category' : 'tag';

		if (is_array($_POST['thesis'])) {
			foreach ($_POST['thesis'] as $name => $new_value) {
				if (is_array($new_value)) {
					foreach ($this->options['head']['options']['robots']['options'] as $sub_name => $unused) {
						if ((bool) $new_value[$sub_name] != (bool) $thesis_site->head['meta'][$name][$sub_name][$type])
							$option[$name][$sub_name] = (bool) $new_value[$sub_name];
					}
				}
				elseif ($new_value)
					$option[$name] = $new_value;
			}
		}

		if (is_array($option)) {
			foreach ($option as $name => $value)
				$values[$name] = (is_array($value)) ? serialize($value) : $value;

			$query = "INSERT INTO $table (term_id, name, taxonomy, title, description, keywords, robots, headline, content) VALUES ('$term_id', '{$_POST['tag-name']}', '{$_POST['taxonomy']}', '{$values['title']}', '{$values['description']}', '{$values['keywords']}', '{$values['robots']}', '{$values['headline']}', '{$values['content']}')";
			$wpdb->query($query);
		}
	}

	function edit_term() {
		global $wpdb, $thesis_site; #wp
		$table = $wpdb->prefix . $this->table_name; #wp
		$type = ($_POST['taxonomy'] == 'category') ? 'category' : 'tag';
		$current_data = $this->terms[$_POST['taxonomy']][$_POST['tag_ID']];

		if (is_array($_POST['thesis'])) {
			foreach ($_POST['thesis'] as $name => $new_value) {
				if (is_array($new_value)) {
					foreach ($new_value as $sub_name => $value) {
						if ((bool) $value != (bool) $thesis_site->head['meta'][$name][$sub_name][$type])
							$option[$name][$sub_name] = (bool) $value;
					}
				}
				elseif (!$new_value && $current_data[$name])
					$option[$name] = '';
				elseif ($new_value)
					$option[$name] = $new_value;
			}
		}

		$update = ($current_data) ? true : false;

		if (is_array($option)) {
			foreach ($option as $name => $value) {
				$values[$name] = (is_array($value)) ? serialize($value) : $value;
				$set[$name] = "$name = '{$values[$name]}'";
			}

			if ($update)
				$query = "UPDATE $table SET " . implode(', ', $set) . " WHERE term_id = '{$_POST['tag_ID']}' AND taxonomy = '{$_POST['taxonomy']}'";
			else
				$query = "INSERT INTO $table (term_id, name, taxonomy, title, description, keywords, robots, headline, content) VALUES ('{$_POST['tag_ID']}', '{$_POST['name']}', '{$_POST['taxonomy']}', '{$values['title']}', '{$values['description']}', '{$values['keywords']}', '{$values['robots']}', '{$values['headline']}', '{$values['content']}')";
		}
		elseif ($update)
			$query = "DELETE FROM $table WHERE term_id = '{$_POST['tag_ID']}' AND taxonomy = '{$_POST['taxonomy']}'";

		$wpdb->query($query); #wp
	}

	function delete_term($term, $tt_id, $taxonomy) {
		global $wpdb; #wp
		$table = $wpdb->prefix . $this->table_name; #wp
		if ($this->terms[$_POST['taxonomy']][$term]) unset($this->terms[$_POST['taxonomy']][$term]);
		$wpdb->query("DELETE FROM $table WHERE term_id = '$term' AND taxonomy = '{$_POST['taxonomy']}'"); #wp
	}

	function option_fields() {
		global $thesis_site;
		echo "<script>jQuery.noConflict();function charCount(ctrlId, counterId){jQuery(counterId).val(jQuery(ctrlId).val().trim().length);}</script>\n";

		if ($_GET['action'] == 'edit') {
			$type = ($_GET['taxonomy'] == 'category') ? 'category' : 'tag';
			$data = $this->terms[$_GET['taxonomy']][$_GET['tag_ID']];

			foreach ($this->options as $section_name => $section) {
				echo "\t\t<table class=\"form-table\">\n";

				foreach ($section['options'] as $option_name => $option) {
					echo "\t\t\t<tr class=\"form-field\">\n";
					echo "\t\t\t\t<th scope=\"row\" valign=\"top\"><label for=\"thesis[$option_name]\">" . $option['label'] . "</label></th>\n";

					if ($option['type'] == 'text') {
						echo "\t\t\t\t<td><input type=\"text\" name=\"thesis[$option_name]\" id=\"thesis_$option_name\" value=\"$data[$option_name]\" />";
						if ($option['counter']) {
							echo "\n\t\t\t\t<script>jQuery('#thesis_$option_name').keyup(function(){charCount('#thesis_$option_name', '#length_thesis_$option_name');});</script>\n";
							echo "\t\t\t\t<input type=\"text\" readonly=\"readonly\" class=\"counter\" id=\"length_thesis_$option_name\" size=\"2\" maxlength=\"3\" value=\"0\">\n\t\t\t\t<label>{$option['counter']}</label>\n\t\t\t\t";
						}
						echo "</td>\n";
					}
					elseif ($option['type'] == 'textarea') {
						echo "\t\t\t\t<td><textarea id=\"thesis_$option_name\" name=\"thesis[$option_name]\" rows=\"4\" cols=\"40\">{$data[$option_name]}</textarea>";
						if ($option['counter']) {
							echo "\n\t\t\t\t<script>jQuery('#thesis_$option_name').keyup(function(){charCount('#thesis_$option_name', '#length_thesis_$option_name');});</script>\n";
							echo "\t\t\t\t<input type=\"text\" readonly=\"readonly\" class=\"counter\" id=\"length_thesis_$option_name\" size=\"2\" maxlength=\"3\" value=\"0\">\n\t\t\t\t<label>{$option['counter']}</label>\n\t\t\t\t";
						}
						echo "</td>\n";
					}
					elseif ($option['type'] == 'checkbox') {
						echo "\t\t\t\t<td>\n\t\t\t\t\t<ul class=\"form-list\">\n";
						foreach ($option['options'] as $name => $label) {
							$checked = ($data[$option_name][$name] || (!isset($data[$option_name][$name]) && $thesis_site->head['meta'][$option_name][$name][$type])) ? 'checked="checked" ' : '';
							echo "\t\t\t\t\t\t<li><input type=\"hidden\" name=\"thesis[$option_name][$name]\" value=\"0\" /><input type=\"checkbox\" name=\"thesis[$option_name][$name]\" value=\"1\" $checked/> <label for=\"thesis_" . $option_name . "_$name\">$label</label></li>\n";
						}
						echo "\t\t\t\t\t</ul>\n\t\t\t\t</td>\n";
					}

					echo "\t\t\t</tr>\n";
				}

				echo "\t\t</table>\n";
			}
		}
		else {
			$type = ($_GET['taxonomy'] == 'category') ? 'category' : 'tag';

			foreach ($this->options as $section_name => $section) {
				echo "\t\t<h3>" . $section['heading'] . "</h3>\n";

				foreach ($section['options'] as $option_name => $option) {
					echo "\t\t<div class=\"form-field\">\n";
					echo "\t\t\t<label for=\"thesis[$option_name]\">" . $option['label'] . "</label>\n";

					if ($option['type'] == 'text') {
						echo "\t\t\t<input type=\"text\" name=\"thesis[$option_name]\" id=\"thesis_$option_name\" value=\"\" />\n";
						if ($option['counter']) {
							echo "\t\t\t<script>jQuery('#thesis_$option_name').keyup(function(){charCount('#thesis_$option_name', '#length_thesis_$option_name');});</script>\n";
							echo "\t\t\t<input type=\"text\" readonly=\"readonly\" class=\"counter\" id=\"length_thesis_$option_name\" size=\"2\" maxlength=\"3\" value=\"0\">\n\t\t\t<label class=\"inline\">{$option['counter']}</label>\n";
						}
					}
					elseif ($option['type'] == 'textarea') {
						echo "\t\t\t<textarea id=\"thesis_$option_name\" name=\"thesis[$option_name]\" rows=\"4\" cols=\"40\"></textarea>\n";
						if ($option['counter']) {
							echo "\t\t\t<script>jQuery('#thesis_$option_name').keyup(function(){charCount('#thesis_$option_name', '#length_thesis_$option_name');});</script>\n";
							echo "\t\t\t<input type=\"text\" readonly=\"readonly\" class=\"counter\" id=\"length_thesis_$option_name\" size=\"2\" maxlength=\"3\" value=\"0\">\n\t\t\t<label class=\"inline\">{$option['counter']}</label>\n";
						}
					}
					elseif ($option['type'] == 'checkbox') {
						echo "\t\t\t<ul class=\"form-list\">\n";
						foreach ($option['options'] as $name => $label) {
							$checked = ($thesis_site->head['meta'][$option_name][$name][$type]) ? 'checked="checked" ' : '';
							echo "\t\t\t\t<li><input type=\"hidden\" name=\"thesis[$option_name][$name]\" value=\"0\" /><input type=\"checkbox\" name=\"thesis[$option_name][$name]\" value=\"1\" $checked/> <label for=\"thesis[$option_name][$name]\">$label</label></li>\n";
						}
						echo "\t\t\t</ul>\n";
					}

					echo "\t\t</div>\n";
				}
			}
		}
	}
}