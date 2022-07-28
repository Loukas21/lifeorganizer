//on page load
$(document).ready(function() {
  // 'hascertificate' field is checked
  if ($('#hascertificate').is(":checked")) {
    $('#certificatedescriptionarea').parent().show();
    $('#certificatedatearea').parent().show();
  }
  else {
    $('#certificatedescriptionarea').parent().hide();
    $('#certificatedatearea').parent().hide();
  }
});

//after click 'iswanted' checkbox
$('#hascertificate').on("click", function() {
  if ($('#hascertificate').is(":checked")) {
      $('#certificatedescriptionarea').parent().show();
      $('#certificatedatearea').parent().show();
  }
  else {
      $('#certificatedescriptionarea').parent().hide();
      $('#certificatedatearea').parent().hide();
  }
});
