<script>
jQuery(function($){
    var wp_topBtn = $('#To_top_animate');
    wp_topBtn.hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 150) {
            wp_topBtn.fadeIn();
        } else {
            wp_topBtn.fadeOut();
        }
    });
    wp_topBtn.on('click', function(){
      $('html,body').animate({ scrollTop: 0 }, '<?php echo get_option( 'WP_to_top_speed' ) ?>' ,'swing');
      return false;
    });
});
</script>
