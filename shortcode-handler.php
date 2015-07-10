<?php 
global $wpdb;

add_shortcode('anyguide', 'anyguide_display_content');		

function anyguide_display_content($anyguide_snippet_name) {
  global $wpdb;

  if (is_array($anyguide_snippet_name)) {
    $snippet_name = $anyguide_snippet_name['snippet'];

    $query = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."anyguide_short_code WHERE title=%s" ,$snippet_name));

    if (count($query) > 0) {
      foreach ($query as $sippetdetails) {
        if ($sippetdetails->status == 1) {
          switch($sippetdetails->type) {
          case "tours":
            return anyguide_tours_view($sippetdetails->slug, $sippetdetails->token);
            break;
          case "curated":
            return anyguide_curated_view($sippetdetails->slug, $sippetdetails->token);
            break;
          case "contact":
            return anyguide_contact_view($sippetdetails->slug);
            break;
          }
        }
      }
    }
  }
}

function anyguide_tours_view($slug, $token) {
  ?>
  <div id="iframe_wrapper"></div>
  <script language="javascript" type="text/javascript">
    (function(){
      window.anyroad = new AnyRoad({
        container: "#iframe_wrapper",
        tours: { guide: "<?php echo $slug; ?>" },
        iframe_style: { width: '100%', background: 'transparent' },
        referrer: { name: "<?php echo $slug; ?>", token: "<?php echo $token; ?>" }
      });
    })();
  </script>
  <?php
};

function anyguide_contact_view($slug) {
  ?>
  <div id="contact_wrapper"></div>
  <script language="javascript" type="text/javascript">
    (function(){
      window.anyroad = new AnyRoad({
        tours: {guide: '<?php echo $slug; ?>'},
        components: ['contact']
      });
      ar.contact.fullForm('#contact_wrapper');
    })();
  </script>
  <?php
};

function anyguide_curated_view($slug, $token) {
  ?>
  <div id="iframe_wrapper"></div>
  <script language="javascript" type="text/javascript">
    (function(){
      window.anyroad = new AnyRoad({
        container: "#iframe_wrapper",
        tours: { curated_list: '<?php echo $slug; ?>' },
        iframe_style: { width: '100%', background: 'transparent' },
        referrer: { name: '<?php echo $token; ?>' }
      });
    })();
  </script>
  <?php
};
