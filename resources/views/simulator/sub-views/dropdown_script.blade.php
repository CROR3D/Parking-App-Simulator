<script>
    $(window).on('load', function() {
        $("#select1").val('---');
        $("#select2").val('---');
    });

    $("#select1").click(function(event) {
        event.preventDefault();
        if($(this).val() == '---'){
            $('#select2').prop("disabled", true);
        } else {
            $('#select2').prop("disabled", false);
        }
    });

    $("#select1").change(function() {
        if ($(this).data('options') === undefined) {
            $(this).data('options', $('#select2 option').clone());
        }
        var id = $(this).val();
        var options = $(this).data('options').filter('[value=' + id + ']');
        $('#select2').html(options).change();
    });

    $("#select2").change(function() {
        var slug = $('#select2').find(':selected').attr('name');
        $('button[name=select]').val(slug);
    });
</script>
