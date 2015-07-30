<?php
add_action( 'widgets_init', array( 'Victor_Tab_Container', 'register_widget' ) );

class Victor_Tab_Container extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget() {
		register_widget( 'Victor_Tab_Container' );
	}

	function __construct() {
		$this->widget_cssclass = 'victor-tab-container';
		$this->widget_id = 'victorious-tab-container';
		$this->widget_name = __( 'Victorious Tab Container', 'victor-toolkit' );
		$this->widget_description = __( 'Display article list widget by categories with tab', 'victor-toolkit' );
		$this->settings = victor_widget_settings();
		unset( $this->settings['relation'] );
		unset( $this->settings['tags'] );
		$this->settings['excerpt_length'] = array(
			'type' => 'number',
			'std' => 40,
			'label' => __( 'Excerpt Length', 'victor-toolkit' ),
			'min' => 1
		);
		parent::__construct();
	}

	function victor_article_tab_container( $instance = array(), $catid = null ) {
		unset( $instance['categories'] );
//	$instance['posts_per_page'] = 4;
		if ( !empty( $catid ) ) {
			$instance['categories'] = $catid;
		}
		$query_args = victor_build_query( $instance );

		$query_args['orderby'] = $instance['orderby'];
		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			$i = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
				<div class="content-col">
					<h5 class="title"><?php the_title(); ?></h5>
					<div class="content"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 40  ); ?></div>
				</div>

				<?php
			}
		}
		wp_reset_postdata();
	}

	function widget( $args, $instance ) {
		$rand = rand();
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if ( sizeof( $instance['categories'] ) > 0 ) {
			echo $before_widget;
			?>
			<div class="left-menu">
				<ul>
					<?php
					for ( $i = 0; $i < sizeof( $instance['categories'] ); $i++ ) {
						$class = '';
						if ( $i == 0 ) {
							$class = 'current-item';
						}
						?>
						<li data-tab="#content<?php echo esc_attr( $i . $rand ); ?>" class="menu-tab <?php echo esc_attr( $class ? $class : ''  ); ?>"><?php echo get_cat_name( $instance['categories'][$i] ); ?></li>
						<?php
					}
					?>
				</ul>                                    
			</div>
			<div class="menu-content-wrapper">
				<?php
				for ( $i = 0; $i < sizeof( $instance['categories'] ); $i++ ) {
					$class = '';
					if ( $i == 0 ) {
						$class = 'current-item';
					}
					?>
					<div id="content<?php echo esc_attr( $i . $rand ); ?>" class="menu-content <?php echo esc_attr( $class ? $class : ''  ); ?>">
						<?php $this->victor_article_tab_container( $instance, $instance['categories'][$i] ); ?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		} else {
			$before_widget = '<div id="' . $this->widget_id . rand() . '" class="widget kopa-article-list-widget article-list-16">';
			echo $before_widget;
			$this->victor_article_tab_container( $instance );
		}
		echo $after_widget;
	}

}
