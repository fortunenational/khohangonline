(function( $ ) {
	'use strict';

	$( document ).ready(function() {
		//console.log(tppdil);
		$("#tppdil-tabs").tabs();
		
		$('.tp_colorpiker').minicolors();

		$('.tp_colorpiker_rgba').minicolors({
			format: 'rgb',
			opacity: true,
		});

		$('#tppdil_description_position').on('change', function() {
			var position = this.value;
			var priority = $(this).find(':selected').data('priority');
			$("#tppdil_description_priority").val(priority);
		});

		if($("#tppdil_description_font_size").length) {
			var slider = document.getElementById("tppdil_description_font_size");
			var output = document.getElementById("tppdil_description_font_size_range_show");
			output.innerHTML = slider.value+'px';

			slider.oninput = function() {
				output.innerHTML = this.value+'px';
			}
		}

		//-----------------------
		$("#tppdil_exclude_description_from_categories , #tppdil_exclude_description_from_tags").easySelect({
			buttons: false,
			search: false,
			placeholder: "Select",
			placeholderColor: "#96588a",
			selectColor: "#96588a",
			itemTitle: "Selected",
			showEachItem: true,
			width: "30%",
			dropdownMaxHeight: "250px",
		});
		//-----------------------

		$('#tppdil_show_product_description').change(function() {
			//alert($(this).is(":checked"));
			if($(this).is(":checked")){
				$('#tppdil_show_product_short_description').prop('checked',false);
				//$('#tppdil_show_product_short_description').attr('checked', false);
			}    
		});
		
		$('#tppdil_show_product_short_description').change(function() {
			//alert($(this).is(":checked"));
			if($(this).is(":checked")){
				$('#tppdil_show_product_description').prop('checked',false);
				//$('#tppdil_show_product_description').attr('checked', false);
			}    
		});

	});

})( jQuery );

function startTimer(duration, display) {
	var timer = duration, minutes, seconds;
	setInterval(function () {
		minutes = parseInt(timer / 60, 10)
		seconds = parseInt(timer % 60, 10);

		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.text(seconds);

		if (--timer < 0) {
			timer = duration;
		}
	}, 1000);
}