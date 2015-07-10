<?php 
  global $wpdb;

  $_POST = stripslashes_deep($_POST);
  $_POST = anyguide_trim_deep($_POST);

  function anyguide_mandatory_fields_notice() {
    ?>
      <div class="AnyNotification clearfix" id="system_notice_area">
        <div class="pull-left Message">
          <i class="fa fa-info-circle"></i> Please fill out all Fields
        </div>
        <div class="pull-right Close">
          <span id="system_notice_area_dismiss">
            <i class="fa fa-times-circle"></i> Close
          </span>
        </div>
      </div>
    <?php
  }

  function anyguide_invalid_snippet_notice() {
    ?>
      <div class="AnyNotification clearfix" id="system_notice_area">
        <div class="pull-left Message">
          <i class="fa fa-info-circle"></i> The Title can only include alphabets, numbers or hyphens
        </div>
        <div class="pull-right Close">
          <span id="system_notice_area_dismiss">
            <i class="fa fa-times-circle"></i> Close
          </span>
        </div>
      </div>
    <?php
  }

  function anyguide_existing_snippet_notice() {
    ?>
      <div class="AnyNotification clearfix" id="system_notice_area">
        <div class="pull-left Message">
          <i class="fa fa-info-circle"></i> A Snippet with this Title already exists
        </div>
        <div class="pull-right Close">
          <span id="system_notice_area_dismiss">
            <i class="fa fa-times-circle"></i> Close
          </span>
        </div>
      </div>
    <?php
  }

  add_action('admin_notices', 'anyguide_mandatory_fields_notice');
  add_action('admin_notices', 'anyguide_invalid_snippet_notice');
  add_action('admin_notices', 'anyguide_existing_snippet_notice');

  if (isset($_POST) && isset($_POST['addSubmit'])) {

    $temp_anyguide_title = str_replace(' ', '', sanitize_text_field($_POST['snippetTitle']));
    $temp_anyguide_title = str_replace('-', '', $temp_anyguide_title);

    $anyguide_title = str_replace(' ', '-', sanitize_text_field($_POST['snippetTitle']));
    $anyguide_type  = sanitize_text_field($_POST['snippetType']);
    $anyguide_slug  = sanitize_text_field($_POST['snippetSlug']);
    $anyguide_token = sanitize_text_field($_POST['snippetToken']);

    // print_r($_POST);

    if ($anyguide_title != "" && $anyguide_type != "" && $anyguide_slug != "" && $anyguide_token != "") {
      if (ctype_alnum($temp_anyguide_title)) {

        $snippet_count = $wpdb->query($wpdb->prepare( 'SELECT * FROM '. $wpdb->prefix .'anyguide_short_code WHERE title = %s', $anyguide_title)) ;

        if ($snippet_count == 0) {
          $anyguide_shortCode = '[anyguide snippet="'.$anyguide_title.'"]';

          $wpdb->insert(
            $wpdb->prefix.'anyguide_short_code', array(
              'title' => $anyguide_title,
              'type' => $anyguide_type,
              'slug' => $anyguide_slug,
              'token' => $anyguide_token,
              'short_code' => $anyguide_shortCode,
              'status' => '1'
            ), array('%s', '%s', '%s', '%s', '%s', '%d'));

          header("Location:" . admin_url('admin.php?page=anyguide-manage&any_msg=1'));
        } else {
          anyguide_existing_snippet_notice();
        }
      } else {
        anyguide_invalid_snippet_notice();
      }
    } else {
      anyguide_mandatory_fields_notice();
    }
  }
?>

<div class="AnyguideWrapper">
  <div class="Header">
    <div class="Navbar clearfix">
      <div class="pull-left">
        <ul class="list-inline">
          <li>
            <a href="<?php echo admin_url('admin.php?page=anyguide-manage');?>">
              <img src="<?php echo plugins_url('assets/images/anyguide_logo.png', dirname(__FILE__)) ?>" class="img-responsive" style="height: 40px;">
            </a>
          </li>
          <li class="navbtn">
            <a href="<?php echo admin_url('admin.php?page=anyguide-settings');?>">Settings</a>
          </li>
          <li class="navbtn">
            <a href="<?php echo admin_url('admin.php?page=anyguide-help');?>">Help</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="clouds-sm"></div>
  </div>

  <div class="AnySection">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          
          <form name="frmmainForm" id="frmmainForm" method="post">

            <div class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #999;">
              <h1>Create a Snippet</h1>
            </div>

            <!-- Snippet Type -->
            <div class="radios text-center">
              <input type="radio" name="snippetType" value="tours" id="tours" checked="checked" />
              <label class="radio" for="tours">
                <i class="fa fa-list-ul"></i><br>
                Tours Listing
              </label>
              <input type="radio" name="snippetType" value="contact" id="contact" <?php if (isset($_POST['snippetType']) && $_POST['snippetType'] == "contact") { ?> checked="checked" <?php } ?> />
              <label class="radio" for="contact">
                <i class="fa fa-at"></i><br>
                Contact Form
              </label>
            </div>

            <br>

            <!-- Form -->
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Enter your Snippet name here" name="snippetTitle" id="snippetTitle" value="<?php if(isset($_POST['snippetTitle'])){ echo esc_attr($_POST['snippetTitle']);}?>">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" placeholder="Enter your Slug here" name="snippetSlug" id="snippetSlug" value="<?php if(isset($_POST['snippetSlug'])){ echo esc_attr($_POST['snippetSlug']);}?>"></td>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" placeholder="Enter your Token here" name="snippetToken" id="snippetToken" value="<?php if(isset($_POST['snippetToken'])){ echo esc_attr($_POST['snippetToken']);}?>"></td>
            </div>

            <br>

            <div class="form-group">
              <div class="col-sm-6 col-md-offset-3 text-center">
                <button class="add-new-snippet-button" type="submit" name="addSubmit">
                  <i class="fa fa-plus-circle"></i>
                  Create Snippet
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>