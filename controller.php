<?php
session_start();

// Validate and sanitize the page parameter
$page = isset($_GET['page']) ? basename($_GET['page']) : 'home'; // Default to 'home' if 'page' is not set
$pageFile = $page . '.php';

// Check if the file exists before including it
if (file_exists($pageFile)) {
    include $pageFile;
} else {
    // Optionally include a 404 page or show an error
    echo 'Page not found.';
}

// Your existing content
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <?php
            $title = ucwords(str_replace("_", ' ', $page));
            ?>
            <h1 class="m-0 text-gradient-primary"><?php echo $title ?></h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <hr class="border-primary">
</div><!-- /.container-fluid -->

<script>
$(function () {
    bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "Please select here",
        width: "100%"
    });
    $('.summernote').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ol', 'ul', 'paragraph', 'height']],
            ['table', ['table']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
        ]
    });
    $('.datetimepicker').datetimepicker({
        format: 'Y/m/d H:i',
    });
    $(".switch-toggle").bootstrapToggle();
    $('.number').on('input keyup keypress', function(){
        var val = $(this).val();
        val = val.replace(/[^0-9]/g, '');
        val = val.replace(/,/g, '');
        val = val > 0 ? parseFloat(val).toLocaleString("en-US") : 0;
        $(this).val(val);
    });
});
</script>
