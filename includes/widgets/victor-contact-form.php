<?php
add_filter( 'kpb_get_widgets_list', array( 'Victor_Contact_Form', 'register_block' ) );

class Victor_Contact_Form extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_block( $blocks ) {
		$blocks['Victor_Contact_Form'] = new Victor_Contact_Form();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-contact-widget mb-100';
		$this->widget_id = 'victorious-contact-form';
		$this->widget_name = __( 'Victorious Contact Form', 'victor-toolkit' );
		$this->widget_description = __( 'Display contact form', 'victor-toolkit' );
		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Contact', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'desc' => array(
				'type' => 'textarea',
				'std' => '',
				'label' => __( 'Description', 'victor-toolkit' )
			),
			'button_text' => array(
				'type' => 'text',
				'std' => __( 'Send Messenge', 'victor-toolkit' ),
				'label' => __( 'Button Text', 'victor-toolkit' )
			)
		);
		parent::__construct();
	}

	function contact_form( $button_text, $style ) {
		?>
		<div class="kopa-contact-form <?php echo esc_attr( $style ); ?>"> 
			<!--<div class="contact-form-box">-->
			<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="contact-form clearfix" method="post" novalidate="novalidate">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="input-block">  
							   <input type="text" placeholder="<?php echo __( 'Name (required)', 'victor-toolkit' ); ?>" onfocus="if (this.value == '<?php echo __( 'Name (required)', 'victor-toolkit' ); ?>')
		                                           this.value = '';" onblur="if (this.value == '')
		                                                       this.value = '<?php echo __( 'Name (required)', 'victor-toolkit' ); ?>';" id="contact_name" name="name" class="valid">    
						</p>                                            
					</div> 

					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="input-block">
							   <input type="text" placeholder="<?php echo __( 'Phone Number', 'victor-toolkit' ); ?>" onfocus="if (this.value == '<?php echo __( 'Phone Number', 'victor-toolkit' ); ?>')
		                                           this.value = '';" onblur="if (this.value == '')
		                                                       this.value = '<?php echo __( 'Phone Number', 'victor-toolkit' ); ?>';" id="contact_phone" name="phone" class="valid">   
						</p>
					</div>
				</div>   

				<div class="row"> 
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="input-block">
							   <input type="text" placeholder="<?php echo __( 'Email (required)', 'victor-toolkit' ); ?>" onfocus="if (this.value == '<?php echo __( 'Email (required)', 'victor-toolkit' ); ?>')
		                                           this.value = '';" onblur="if (this.value == '')
		                                                       this.value = '<?php echo __( 'Email (required)', 'victor-toolkit' ); ?>';" id="contact_email" name="email" class="valid">   
						</p>
					</div>

					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="input-block">
							   <input type="text" placeholder="<?php echo __( 'Website', 'victor-toolkit' ); ?>" onfocus="if (this.value == '<?php echo __( 'Website', 'victor-toolkit' ); ?>')
		                                           this.value = '';" onblur="if (this.value == '')
		                                                       this.value = '<?php echo __( 'Website', 'victor-toolkit' ); ?>';" id="contact_website" name="website" class="valid">
						</p>
					</div>
				</div>
				<!-- row --> 
				<p class="textarea-block">  
						  <textarea name="message" id="contact_message" onfocus="if (this.value == <?php echo __( 'Your comment (required)', 'victor-toolkit' ); ?>')
		                                          this.value = '';"  cols="88" rows="5"></textarea>
				</p>
				<p class="contact-button clearfix">           
					<input type="submit" value="<?php echo esc_attr( $button_text ); ?>" id="input-submit">
				</p>
				<input type="hidden" name="action" value="kopa_send_contact">
				<?php echo wp_nonce_field( 'kopa_send_contact_nicole_kidman', 'kopa_send_contact_nonce', true, false ); ?>
			</form>
			<div id="response"></div>
			<!--</div>-->
		</div>
		<?php
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		$this->contact_form( $instance['button_text'], 's1' );
		echo $after_widget;
	}

}
