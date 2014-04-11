jQuery(document).ready(function($) {
	$('#itv_footnotes_meta_box .inside').append("<span class='plus'>+</span>");
	text_fields = $('#itv_footnotes_meta_box .footnote').length;
	$('.footnote:gt(0)').each(function() {
		$(this).after('<span class="footnote_remove">x</span>');
	});
	$('.plus').click(function() {
		text_fields = text_fields + 1;
		$('#itv_footnotes_meta_box .inside').append("<div class=\"footnote_section\"><label for=\"footnote_number_" + text_fields + "\">Footnote " + text_fields + ":</label><br /><input type=\"text\" name=\"itv_footnotes_meta_value[]\" class=\"footnote\" id=\"footnote_number_" + text_fields + " value=\"\"><span class=\"footnote_remove\">x</span><br /></div>");
	});
	$('.footnote_remove').click(function() {
		$(this).parent().remove();
		count = 1;
		$('.footnote_section').each(function() {
			var footnote_label = $(this).children('label');
			var footnote_input = $(this).children('input.footnote');
			footnote_label.attr("for","footnote_number_" + count );
			footnote_label.text("Footnote " + count + ":");
			footnote_input.attr("id","footnote_number_" + count);
			count++;
		});
	});
});