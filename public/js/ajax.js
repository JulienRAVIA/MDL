$('button[data-value]').on('click', function() {
	var atelier = $('input[name="atelier"]').val();
	var type = $(this).attr('data-value');
  	$.ajax({
	  	type: "POST",
	  	url: "avis",
	  	data: {atelier: atelier, type: type},
	  	dataType: "json",
	  	success: function(data) {
	  		toastr[data.code](data.message);
  		},
	  	error: function(data) {
	  		toastr["error"]('Erreur');
  		},
  		beforeSend: function() {
  			$('button[data-value]').attr('disabled', 'disabled');
  			$('.message').removeClass('alert-success alert-danger').hide();
  		},
  		complete: function() {
  			setTimeout(function() {
  				$('button[data-value]').removeAttr('disabled');}
  			, 500);
  			resultats(atelier);
  			nombre(atelier);
  		}
	});
});

function resultats(atelier) {
	$.ajax({
	  	type: "POST",
	  	url: "resultats",
	  	data: {atelier: atelier},
	  	dataType: "json",
	  	success: function(results) {
	  		$('ul#resultats').html('');
	  		$.each( results.data, function( key, value ) {
	  			$('ul#resultats').append('<li>' + value.libelle + ' : ' + value.total + '</li>');
			});
	  	}
	});
} 

function nombre(atelier) {
	$.ajax({
	  	type: "POST",
	  	url: "avis/nb",
	  	data: {atelier: atelier},
	  	dataType: "json",
	  	success: function(results) {
	  		$('span#nombre').html(results.data.nombre);
	  	}
	});
} 

$('#ateliers').on('change', function(event, el) {
	var atelierSelectionne = $(this).find('option:selected');
	$('input[name="atelier"]').val(atelierSelectionne.val());
	$('#nom').html(atelierSelectionne.text());
	$('#places').html(atelierSelectionne.attr('data-places'));
	resultats(atelierSelectionne.val());
	nombre(atelierSelectionne.val());
});

$(document).ready(function() {
	var atelier = $('input[name="atelier"]').val();
	resultats(atelier);
	nombre(atelier);
});
