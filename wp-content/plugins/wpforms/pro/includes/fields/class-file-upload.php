<?php
/**
 * File upload field.
 *
 * @package    WPForms
 * @author     WPForms
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2016, WPForms LLC
 */
class WPForms_Field_File_Upload extends WPForms_Field {

	/**
	 * Files that are now allowed.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $blacklist = array( 'ade', 'adp', 'app', 'asp', 'bas', 'bat', 'cer', 'cgi', 'chm', 'cmd', 'com', 'cpl', 'crt', 'csh', 'csr', 'dll', 'drv', 'exe', 'fxp', 'flv', 'hlp', 'hta', 'htaccess', 'htm', 'htpasswd', 'inf', 'ins', 'isp', 'jar', 'js', 'jse', 'jsp', 'ksh', 'lnk', 'mdb', 'mde', 'mdt', 'mdw', 'msc', 'msi', 'msp', 'mst', 'ops', 'pcd', 'php', 'pif', 'pl', 'prg', 'ps1', 'ps2', 'py', 'rb', 'reg', 'scr', 'sct', 'sh', 'shb', 'shs', 'sys', 'swf', 'tmp', 'torrent', 'url', 'vb', 'vbe', 'vbs', 'vbscript', 'wsc', 'wsf', 'wsf', 'wsh' );

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Define field type information
		$this->name  = __( 'File Upload', 'wpforms' );
		$this->type  = 'file-upload';
		$this->icon  = 'fa-upload';
		$this->order = 15;
		$this->group = 'fancy';

		// Define additional field properties.
		add_filter( 'wpforms_field_properties_file-upload' , array( $this, 'field_properties' ), 5, 3 );

		// Customize value format for HTML emails.
		add_filter( 'wpforms_html_field_value', array( $this, 'html_email_value' ), 10, 4 );
	}

	/**
	 * Define additional field properties.
	 *
	 * @since 1.3.7
	 * @param array $properties
	 * @param array $field
	 * @param array $form_data
	 * @return array
	 */
	public function field_properties( $properties, $field, $form_data ) {

		$form_id  = absint( $form_data['id'] );
		$field_id = absint( $field['id'] );

		// Input Primary: adjust name.
		$properties['inputs']['primary']['attr']['name'] = "wpforms_{$form_id}_{$field_id}";

		// Input Primary: allowed file extensions.
		if ( ! empty( $field['extensions'] ) ) {

			// User provided specific extensions.
			$extensions = explode( ',', strtolower( preg_replace( '/[^A-Za-z0-9,]/', '', $field['extensions'] ) ) );

		} else {

			// No extensions specified, use WordPress defaults.
			$extensions = array();
			$allowed    = get_allowed_mime_types();

			foreach ( $allowed as $wordpress_extensions => $mime ) {
				$exts = explode( '|', $wordpress_extensions );
				foreach ( $exts as $ext ) {
					$valid = true;
					foreach( $this->blacklist as $nope ) {
						if ( strpos( $ext, $nope ) !== FALSE ) {
							$valid = false;
							break;
						}
					}
					if ( $valid ) {
						$extensions[] = strtolower( preg_replace( '/[^A-Za-z0-9 ]/', '', $ext ) );
					}
				}
			}
		}
		$properties['inputs']['primary']['data']['rule-extension'] = implode( ',', $extensions );

		// Input Primary: max file size
		$properties['inputs']['primary']['data']['rule-maxsize'] = $this->max_file_size( $field );

		return $properties;
	}

	/**
	 * Customize format for HTML email notifications.
	 *
	 * @since 1.1.3
	 * @param string $val
	 * @param array $field
	 * @param array $form_data
	 * @param string $context
	 * @return string
	 */
	public function html_email_value( $val, $field, $form_data = '', $context = '' ) {

		if ( ! empty( $field['value'] ) && 'file-upload' === $field['type'] ) {

			return sprintf(
				'<a href="%s" rel="noopener" target="_blank">%s</a>',
				esc_url( $field['value'] ),
				sanitize_text_field( $field['file_original'] )
			);
		}

		return $val;
	}

	/**
	 * Field options panel inside the builder.
	 *
	 * @since 1.0.0
	 * @param array $field
	 */
	public function field_options( $field ) {

		// -------------------------------------------------------------------//
		// Basic field options.
		// -------------------------------------------------------------------//

		// Options open markup.
		$args = array(
			'markup' => 'open',
		);
		$this->field_option( 'basic-options', $field, $args );

		// Label.
		$this->field_option( 'label', $field );

		// Description.
		$this->field_option( 'description', $field );

		// Allowed extensions.
		$lbl = $this->field_element(
			'label',
			$field,
			array(
				'slug'    => 'extensions',
				'value'   => __( 'Allowed File Extensions', 'wpforms' ),
				'tooltip' => __( 'Enter the extensions you would like to allow, comma separated.', 'wpforms' ),
			),
			false
		);
		$fld = $this->field_element(
			'text',
			$field,
			array(
				'slug'  => 'extensions',
				'value' => ! empty( $field['extensions'] ) ? $field['extensions'] : '',
			),
			false
		);
		$args = array(
			'slug'    => 'extensions',
			'content' => $lbl . $fld,
		);
		$this->field_element( 'row', $field, $args );

		// Max filesize.
		$lbl  = $this->field_element(
			'label',
			$field,
			array(
				'slug'    => 'max_size',
				'value'   => __( 'Max File Size', 'wpforms' ),
				'tooltip' => __( 'Enter the max file size, in megabytyes, to allow. If left blank, the value defaults to the maximum size the server allows which is ', 'wpforms' ) . wpforms_max_upload(),
			),
			false
		);
		$fld = $this->field_element(
			'text',
			$field,
			array(
				'slug'  => 'max_size',
				'value' => ! empty( $field['max_size'] ) ? $field['max_size'] : '',
			),
			false
		);
		$args = array(
			'slug'    => 'max_size',
			'content' => $lbl . $fld,
		);
		$this->field_element( 'row', $field, $args );

		// Required toggle.
		$this->field_option( 'required', $field );

		// Options close markup.
		$args = array(
			'markup' => 'close',
		);
		$this->field_option( 'basic-options', $field, $args );

		// -------------------------------------------------------------------//
		// Advanced field options.
		// -------------------------------------------------------------------//

		// Options open markup.
		$args = array(
			'markup' => 'open',
		);
		$this->field_option( 'advanced-options', $field, $args );

		// Hide Label.
		$this->field_option( 'label_hide', $field );

		// Media Libary toggle.
		$fld  = $this->field_element(
			'checkbox',
			$field,
			array(
				'slug'    => 'media_library',
				'value'   => ! empty( $field['media_library'] ) ? 1 : '',
				'desc'    => __( 'Store file in WordPress Media Library', 'wpforms' ),
				'tooltip' => __( 'Check this option to store the final uploaded file in the WordPress Media Library', 'wpforms' ),
			),
			false
		);
		$args = array(
			'slug'    => 'media_library',
			'content' => $fld,
		);
		$this->field_element( 'row', $field, $args );


		// Custom CSS classes.
		$this->field_option( 'css', $field );

		// Options close markup.
		$args = array(
			'markup' => 'close',
		);
		$this->field_option( 'advanced-options', $field, $args );
	}

	/**
	 * Field preview inside the builder.
	 *
	 * @since 1.0.0
	 * @param array $field
	 */
	public function field_preview( $field ) {

		// Label.
		$this->field_preview_option( 'label', $field );

		// Primary input.
		echo '<input type="file" class="primary-input" disabled>';

		// Description.
		$this->field_preview_option( 'description', $field );
	}

	/**
	 * Field display on the form front-end.
	 *
	 * @since 1.0.0
	 * @param array $field
	 * @param array $deprecated
	 * @param array $form_data
	 */
	public function field_display( $field, $deprecated, $form_data ) {

		// Define data.
		$primary = $field['properties']['inputs']['primary'];

		// Primary field.
		printf( '<input type="file" %s %s>',
			wpforms_html_attributes( $primary['id'], $primary['class'], $primary['data'], $primary['attr'] ),
			$primary['required']
		);
	}

	/**
	 * Validates field on form submit.
	 *
	 * @since 1.0.0
	 * @param int $field_id
	 * @param array $field_submit
	 * @param array $form_data
	 */
	public function validate( $field_id, $field_submit, $form_data ) {

		$field     = $form_data['fields'][ $field_id ];
		$form_id   = absint( $form_data['id'] );
		$file_slug = 'wpforms_' . $form_data['id'] . '_' . $field_id;

		// -------------------------------------------------------------------//
		// If upload is not required and nothing is uploaded, don't process.
		// -------------------------------------------------------------------//
		if ( empty( $field['required'] ) && 4 == $_FILES[ $file_slug ]['error'] ) {
			return;
		}

		// -------------------------------------------------------------------//
		// Basic upload validation.
		// -------------------------------------------------------------------//
		if ( 0 != $_FILES[ $file_slug ]['error'] && 4 != $_FILES[ $file_slug ]['error'] ) {

			$errors = array(
				 false,
				__( 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'wpforms' ),
				__( 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.', 'wpforms' ),
				__( 'The uploaded file was only partially uploaded.', 'wpforms' ),
				__( 'No file was uploaded.', 'wpforms' ),
				'',
				__( 'Missing a temporary folder.', 'wpforms' ),
				__( 'Failed to write file to disk.', 'wpforms' ),
				__( 'File upload stopped by extension.', 'wpforms' ),
			);
			wpforms()->process->errors[ $form_id ][ $field_id ] = __( 'File upload error. ', 'wpforms' ) . $errors[ $_FILES[ $file_slug ]['error'] ];
			return;
		}

		// -------------------------------------------------------------------//
		// Validate if file is required and provided.
		// -------------------------------------------------------------------//
		if ( ! empty( $field['required'] ) && ( empty( $_FILES[ $file_slug ]['tmp_name'] ) || 4 == $_FILES[ $file_slug ]['error'] ) ) {

			wpforms()->process->errors[ $form_id ][ $field_id ] = apply_filters( 'wpforms_required_label', __( 'This field is required', 'wpforms' ) );
			return;
		}

		// -------------------------------------------------------------------//
		// Validate file size.
		// -------------------------------------------------------------------//
		$max_size = $this->max_file_size( $field );
		if ( $_FILES[ $file_slug ]['size'] > $max_size ) {

			wpforms()->process->errors[ $form_id ][ $field_id ] = $sprintf( '%s (%s)', __( 'File exceeds max size allowed', 'wpforms' ), wpforms_size_to_megabytes( $max_size ) );
			return;
		}

		// -------------------------------------------------------------------//
		// Validate extension against blacklist.
		// There are certain extensions we do not allow under any circumstances,
		// with no exceptions, for security purposes. Validate against this
		// blacklist below, before proceeded any further.
		// -------------------------------------------------------------------//
		$valid = true;
		$ext   = strtolower( pathinfo( $_FILES[ $file_slug ]['name'], PATHINFO_EXTENSION ) );
		$nope  = $this->blacklist;

		// Make sure file has an extension first.
		if ( empty( $ext ) ) {
			wpforms()->process->errors[ $form_id ][ $field_id ] = __( 'File must have an extension.', 'wpforms' );
			return;
		}

		foreach ( $nope as $extension ) {
			// Instead of doing the check with in_array, we do a string compare.
			// This way 'php' will hit for php3, php4, php5 etc.
			if ( strpos( $extension, $ext ) !== FALSE ) {
				$valid = false;
				wpforms()->process->errors[ $form_id ][ $field_id ] = __( 'File type is not allowed.', 'wpforms' );
				break;
			}
		}
		if ( ! $valid ) {
			return;
		}

		// -------------------------------------------------------------------//
		// Validate extension against user provided setting.
		// -------------------------------------------------------------------//
		if ( ! empty( $field['extensions'] ) ) {

			$allow = explode( ',', strtolower( preg_replace( '/[^A-Za-z0-9,]/', '', $field['extensions'] ) ) );

			if ( ! in_array( $ext , $allow, true ) ) {
				wpforms()->process->errors[ $form_id ][ $field_id ] = __( 'File type is not allowed.', 'wpforms' );
				return;
			}
		}

		// -------------------------------------------------------------------//
		// Validate file against what WordPress is set to allow.
		// At the end of the day, if you try to upload a file that WordPress
		// doesn't allow, we won't allow it either. Users can use a plugin to
		// filter the allowed mime types in WordPress if this is an issue.
		// -------------------------------------------------------------------//
		$wp_filetype     = wp_check_filetype_and_ext( $_FILES[ $file_slug ]['tmp_name'], $_FILES[ $file_slug ]['name'] );
		$ext             = empty( $wp_filetype['ext'] ) ? '' : $wp_filetype['ext'];
		$type            = empty( $wp_filetype['type'] ) ? '' : $wp_filetype['type'];
		$proper_filename = empty( $wp_filetype['proper_filename'] ) ? '' : $wp_filetype['proper_filename'];

		if ( $proper_filename || ! $ext || ! $type ) {
			wpforms()->process->errors[ $form_id ][ $field_id ] = __( 'File type is not allowed.', 'wpforms' );
			return;
		}
	}

	/**
	 * Formats and sanitizes field.
	 *
	 * @since 1.0.0
	 * @param int $field_id
	 * @param array $field_submit
	 * @param array $form_data
	 */
	public function format( $field_id, $field_submit, $form_data ) {

		$name      = ! empty( $form_data['fields'][ $field_id] ['label'] ) ? $form_data['fields'][ $field_id ]['label'] : '';
		$field     = $form_data['fields'][ $field_id ];
		$form_id   = absint( $form_data['id'] );
		$file_slug = sprintf( 'wpforms_%d_%d', $form_id, $field_id );
		$file      = $_FILES[ $file_slug ];

		// If there was no file uploaded stop here before we continue with the
		// upload process.
		if ( 0 !== $file['error'] ) {
			wpforms()->process->fields[ $field_id ] = array(
				'name'          => sanitize_text_field( $name ),
				'value'         => '',
				'file'          => '',
				'file_original' => '',
				'ext'           => '',
				'id'            => absint( $field_id ),
				'type'          => $this->type,
			);
			return;
		}

		// Define data.
		$file_name            = sanitize_file_name( $file['name'] );
		$file_ext             = pathinfo( $file_name, PATHINFO_EXTENSION );
		$file_base            = wp_basename( $file_name, ".$file_ext" );
		$file_name_new        = sprintf( '%s-%s.%s', $file_base, uniqid(), strtolower( $file_ext ) );
		$uploads              = wp_upload_dir();
		$form_directory       = absint( $form_id ) . '-' . md5( $form_id . $form_data['created'] );
		$wpforms_uploads_root = trailingslashit( $uploads['basedir'] ) . 'wpforms';
		$wpforms_uploads_form = trailingslashit( $wpforms_uploads_root ) . $form_directory;
		$file_new             = trailingslashit( $wpforms_uploads_form ) . $file_name_new;
		$file_url             = trailingslashit( $uploads['baseurl'] ) . 'wpforms/' . trailingslashit( $form_directory ) . $file_name_new;
		$attachment_id        = '0';

		// Check for form upload directory destination.
		if ( ! file_exists( $wpforms_uploads_form ) ) {
			wp_mkdir_p( $wpforms_uploads_form );
		}

		// Check if the index.html exists in the root uploads director, if not create it.
		if ( ! file_exists( trailingslashit( $wpforms_uploads_root ) . 'index.html' ) ) {
			file_put_contents( trailingslashit( $wpforms_uploads_root ) . 'index.html', '' );
		}

		// Check if the index.html exists in the form uploads director, if not create it.
		if ( ! file_exists( trailingslashit( $wpforms_uploads_form ) . 'index.html' ) ) {
			file_put_contents( trailingslashit( $wpforms_uploads_form ) . 'index.html', '' );
		}

		// Move the file to the uploads dir - similar to _wp_handle_upload().
		$move_new_file = @ move_uploaded_file( $file['tmp_name'], $file_new );
		if ( false === $move_new_file ) {
			wpforms_log(
				'Upload Error, could not upload file',
				$file_url,
				array(
					'type'    => array( 'entry', 'error' ),
					'form_id' => $form_data['id'],
				)
			);
			return;
		}

		// Set correct file permissions.
		$stat = stat( dirname( $file_new ));
		$perms = $stat['mode'] & 0000666;
		@ chmod( $file_new, $perms );

		// Maybe move file to the WordPress media library.
		if ( ! empty( $field['media_library'] ) && '1' === $field['media_library'] ) {

			// Include necessary code from core.
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			// Copy our file into WordPress uploads.
			$file_args = array(
				'error'    => '',
				'tmp_name' => $file_new,
				'name'     => $file_name_new,
				'type'     => $file['type'],
				'size'     => $file['size'],
			);
			$upload = wp_handle_sideload( $file_args, array( 'test_form' => false ) );

			// Create the attachment for the file.
			$attachment_args = array(
				'post_type'      => 'attachment',
				'post_type'      => '',
				'post_content'   => '',
				'post_status'    => 'publish',
				'post_mime_type' => $file['type'],
			);
			$attachment_id = wp_insert_attachment( $attachment_args, $upload['file'] );

			// Generate attachment meta.
			$meta = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
			wp_update_attachment_metadata( $attachment_id,  $meta );

			// Update file url/name.
			$file_url      = $upload['url'];
			$file_name_new = basename( $upload['url'] );

			// Remove the original non-media library file.
			@ unlink( $file_new );
		}

		// Set final field details.
		wpforms()->process->fields[ $field_id ] = array(
			'name'          => sanitize_text_field( $name ),
			'value'         => esc_url_raw( $file_url ),
			'file'          => $file_name_new,
			'file_original' => $file_name,
			'ext'           => $file_ext,
			'attachment_id' => absint( $attachment_id ),
			'id'            => absint( $field_id ),
			'type'          => $this->type,
		);
	}

	/**
	 * Determine max file size allowed.
	 *
	 * @since 1.0.0
	 * @param array $field
	 * @return int bytes allowed
	 */
	public function max_file_size( $field ) {

		if ( ! empty( $field['max_size'] ) ) {

			// Strip any suffix provided (eg M, MB etc), which leaves is wit the raw MB value
			$max_size = preg_replace( '/[^0-9.]/', '', $field['max_size'] );
			$max_size = wpforms_size_to_bytes( $max_size . 'M' );

		} else {
			$max_size = wpforms_max_upload( true );
		}
		return $max_size;
	}
}
new WPForms_Field_File_Upload;
