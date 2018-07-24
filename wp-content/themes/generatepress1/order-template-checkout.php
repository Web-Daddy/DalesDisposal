<?php /* Template Name: Checkout */ ?>
<?php 
get_header();
echo '<pre>';
parse_str(stripslashes($_COOKIE['form_data']), $form_data);
print_r($form_data);
echo "</pre>";
echo "<pre>";
$date = $_COOKIE['date_range'];
print_r($date);
echo "</pre>";
?>
<?php get_footer(); ?>