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
        <h1 style="visibility: visible;"> (V <?php echo anyguide_plugin_get_version(); ?>)</h1> 
					Anyguide Snippet is developed and maintained by <a href="http://anyguide.com">Anyguide</a>.
      </div>
    </div>
  </div>
</div>