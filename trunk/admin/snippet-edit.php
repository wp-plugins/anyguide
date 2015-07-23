<?php 
  global $wpdb;
  global $current_user;
  get_currentuserinfo();

  function anyguide_mandatory_fields_notice() {
    echo '<div class="error"><p>Please fill in all mandatory fields.</p></div>';
  }

  function anyguide_invalid_snippet_notice() {
    echo '<div class="error"><p>The title can only have alphabets,numbers or hyphen.</p></div>';
  }

  function anyguide_existing_snippet_notice() {
    echo '<div class="error"><p>This Snippet already exists.</p></div>';
  }

  add_action('admin_notices', 'anyguide_mandatory_fields_notice');
  add_action('admin_notices', 'anyguide_invalid_snippet_notice');
  add_action('admin_notices', 'anyguide_existing_snippet_notice');

  $anyguide_snippetId = abs(intval($_GET['snippetId']));

  if(isset($_POST) && isset($_POST['updateSubmit'])){

  	$_POST = stripslashes_deep($_POST);
  	$_POST = anyguide_trim_deep($_POST);
  	
  	$anyguide_snippetId = intval($_GET['snippetId']);
  	
  	$temp_anyguide_title = str_replace(' ', '', sanitize_text_field($_POST['snippetTitle']));
  	$temp_anyguide_title = str_replace('-', '', $temp_anyguide_title);
  	
  	$anyguide_title = str_replace(' ', '-', sanitize_text_field($_POST['snippetTitle']));
  	$anyguide_type  = sanitize_text_field($_POST['snippetType']);
  	$anyguide_slug  = sanitize_text_field($_POST['snippetSlug']);
  	$anyguide_token = sanitize_text_field($_POST['snippetToken']);

    if ($anyguide_title != "" && $anyguide_type != "" && $anyguide_slug != "" && $anyguide_token != "") {
  		
      if(ctype_alnum($temp_anyguide_title)) {
        $snippet_count = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'anyguide_short_code WHERE id!=%d AND title=%s LIMIT 0,1',$anyguide_snippetId,$anyguide_title)) ;

        if($snippet_count == 0){
          $anyguide_shortCode = '[anyguide snippet="'.$anyguide_title.'"]';

          $wpdb->update(
            $wpdb->prefix.'anyguide_short_code',
            array(
              'title' => $anyguide_title,
              'type' => $anyguide_type,
              'slug' => $anyguide_slug,
              'token' => $anyguide_token,
              'short_code' => $anyguide_shortCode
            ),
            array('id'=>$anyguide_snippetId)
          );

          header("Location:".admin_url('admin.php?page=anyguide-manage&any_msg=5'));
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


  global $wpdb;


  $snippetDetails = $wpdb->get_results($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'anyguide_short_code WHERE id=%d LIMIT 0,1',$anyguide_snippetId )) ;
  $snippetDetails = $snippetDetails[0];

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
          <input type="hidden" id="snippetId" name="snippetId" value="<?php if(isset($_POST['snippetId'])){ echo esc_attr($_POST['snippetId']);}else{ echo esc_attr($snippetDetails->id); }?>">

          <div class="text-center" style="color:#999;margin-bottom:20px;font-family: 'Titillium Web', sans-serif;">
            <h1>
              Edit your Snippet
            </h1>
          </div>

          <!-- Snippet Type -->
          <div class="radios text-center">
            <input name="snippetType" type="radio" id="tours" <?php if (isset($_POST['snippetType']) && $_POST['snippetType'] == "tours") { ?> checked="checked" <?php } else if ($snippetDetails->type == "tours") { ?> checked="checked" <?php } ?>  value="tours" />
            <label class="radio" for="tours">
              <i class="fa fa-list-ul"></i><br>
              Tours Listing
            </label>
            <input name="snippetType" type="radio" id="contact" <?php if (isset($_POST['snippetType']) && $_POST['snippetType'] == "contact") { ?> checked="checked" <?php } else if ($snippetDetails->type == "contact") { ?> checked="checked" <?php } ?>  value="contact" />
            <label class="radio" for="contact">
              <i class="fa fa-at"></i><br>
              Contact Form
            </label>
          </div>

          <br>

          <!-- Form -->
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter your Snippet name here" name="snippetTitle" id="snippetTitle" value="<?php if(isset($_POST['snippetTitle'])){ echo esc_attr($_POST['snippetTitle']);} else { echo $snippetDetails->title; }?>">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter your Slug here" name="snippetSlug" id="snippetSlug" value="<?php if(isset($_POST['snippetSlug'])){ echo esc_attr($_POST['snippetSlug']);} else { echo $snippetDetails->slug; }?>"></td>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter your Token here" name="snippetToken" id="snippetToken" value="<?php if(isset($_POST['snippetToken'])){ echo esc_attr($_POST['snippetToken']);} else { echo $snippetDetails->token; }?>"></td>
          </div>

          <br>

          <div class="form-group">
            <div class="col-sm-6 col-md-offset-3">
              <button class="add-new-snippet-button" type="submit" name="updateSubmit">
                <i class="fa fa-retweet"></i>
                Update Snippet
              </button>
            </div>
          </div>
        </form>

      </div>
      </div>
    </div>
  </div>
</div>
