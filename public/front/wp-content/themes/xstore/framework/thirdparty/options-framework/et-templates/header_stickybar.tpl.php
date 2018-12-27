<?php
  /**
   * The template for the header sticky bar.
   * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
   *
   * @author        Redux Framework
   * @package       ReduxFramework/Templates
   * @version:      3.6.10
   */
?>
<div id="redux-sticky">
    <div id="info_bar">
      <div class="etheme-search">
          <input type="text" class="etheme-options-search form-control" placeholder="<?php esc_html_e( 'Search for options', 'xstore' ); ?>" />
          <i class="et-admin-icon et-zoom"></i>
          <span class="spinner">
            <div class="et-loader ">
              <svg class="loader-circular" viewBox="25 25 50 50">
                <circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
              </svg>
            </div>
          </span>
      </div>

      <ul class="etheme-support-links">
        <li class="etheme-deactivate"><i class="et-admin-icon et-documentation"></i> <a href="<?php echo admin_url('admin.php?page=et-panel-support'); ?>" target="blank"><?php esc_html_e('Manual & Support', 'xstore'); ?></a></li>
      </ul>

      <div class="redux-action_bar">
          <span class="spinner"><div class="et-loader "><svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div></span>
        <?php
          if ( false === $this->parent->args['hide_save'] ) {
              $extra = array(
                      'id'=>'testing'
              );
            submit_button( esc_attr__( 'Save Changes', 'xstore' ), 'primary', 'redux_save', false, array(
                'id' => 'redux_top_save'
            ));
          }
          if ( false === $this->parent->args['hide_reset'] ) {
            submit_button( esc_attr__( 'Reset Section', 'xstore' ), 'secondary', $this->parent->args['opt_name'] . '[defaults-section]', false, array( 'id' => 'redux-defaults-section-top' ) );
            submit_button( esc_attr__( 'Reset All', 'xstore' ), 'secondary', $this->parent->args['opt_name'] . '[defaults]', false, array( 'id' => 'redux-defaults-top' ) );
          }
        ?>
      </div>
      <div class="redux-ajax-loading" alt="<?php esc_attr_e( 'Working...', 'xstore' ) ?>">&nbsp;</div>
    </div>

    <!-- Notification bar -->
    <div id="redux_notification_bar">
      <?php $this->notification_bar(); ?>
    </div>
</div>