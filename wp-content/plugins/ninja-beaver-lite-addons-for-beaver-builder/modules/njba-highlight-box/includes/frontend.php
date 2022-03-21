<?php 
    $hover_effect = $settings->hover_effect;
    switch ($hover_effect) {
    case '1':
?>
    <?php echo $module->njba_highlight_module($settings->select); ?>
<?php break;
    case '2':
?>
    <div class="njba-layout-two">
        <?php echo $module->njba_highlight_module($settings->select); ?>
    </div>
<?php break;
    case '3':
?>
    <div class="njba-layout-three">
        <?php echo $module->njba_highlight_module($settings->select); ?>
    </div>
<?php break;
    case '4':
?>
    <div class="njba-layout-four">
        <?php echo $module->njba_highlight_module($settings->select); ?>
    </div>
<?php break;
    case '5':
?>
    <div class="njba-layout-five">
        <?php echo $module->njba_highlight_module($settings->select); ?>
    </div>
<?php break;
    case '6':
?>
    <?php echo $module->njba_highlight_module($settings->select); ?>
<?php break;
} ?>
    