jQuery(document).ready(function ($) {

    // Using this var to track which item on a page full of multiple upload buttons is currently being uploaded.
    var current_gwen_upload = 0;

    // Define uploader settings
    var frame = wp.media({
        title: 'Upload or Select an Image',
        multiple: false,
        library: {type: 'image'},
        button: {text: 'Insert Image'}
    });

    // Call this from the upload button to initiate the upload frame.
    gwen_open_uploader = function (id) {
        current_gwen_upload = id;
        frame.open();
        return false;
    };

    // Handle results from media manager.
    frame.on('close', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        gwen_render_image(attachment);
    });

    // Output selected image HTML.
    // This part could be totally rewritten for your own purposes to process the results!
    gwen_render_image = function (attachment) {

        var imageElem = $("#" + current_gwen_upload + "_image");

        imageElem.removeAttr('srcset').removeAttr('sizes').attr('src', attachment.url).attr('width', attachment.width).attr('height', attachment.height).css({
            'max-width': '100%',
            'height': 'auto'
        }).show();
        $("#" + current_gwen_upload).val(attachment.id);
        $("#" + current_gwen_upload + "_remove").show();
    };

    gwen_clear_uploader = function (current_gwen_upload) {
        $("#" + current_gwen_upload + "_image").attr('src', '').hide();
        $("#" + current_gwen_upload).val('');
        $("#" + current_gwen_upload + "_remove").hide();
        return false;
    }

});