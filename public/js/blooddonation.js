//on page load
$(document).ready(function() {
  // 'isdonationbanned' field is checked
  if ($('#isdonationbanned').is(":checked")) {
    $('#bancausetype').parent().show();
    $('#bancausedescription').parent().show();
    $('#bandateto').parent().show();
    $('#isplanned').prop("disabled","disabled");
    $('#isplanned').prop("checked", false);
  }
  else {
    $('#bancausetype').parent().hide();
    $('#bancausedescription').parent().hide();
    $('#bandateto').parent().hide();
    $('#isplanned').prop("disabled","");
  }

// 'isplanned' field is checked
if ($('#isplanned').is(":checked")) {
  $('#donatedbloodamount').prop("disabled", "disabled");
  $('#donatedbloodamount').val(0);
  $('#isdonationbanned').prop("disabled", "disabled");
}
else {
  $('#donatedbloodamount').prop("disabled", "");
  $('#isdonationbanned').prop("disabled", "");
}
});

//after click 'isdonationbanned' checkbox
$('#isdonationbanned').on("click", function() {
  if ($('#isdonationbanned').is(":checked")) {
    $('#bancausetype').parent().show();
    $('#bancausedescription').parent().show();
    $('#bandateto').parent().show();
    $('#isplanned').prop("disabled","disabled");
    $('#isplanned').prop("checked", false);
  }
  else {
    $('#bancausetype').parent().hide();
    $('#bancausedescription').parent().hide();
    $('#bandateto').parent().hide();
    $('#isplanned').prop("disabled","");
    $('#bancausetype').val(0);
    $('#bancausedescription').val("");
    $('#bandateto').val("");
  }
});

//after click 'isdonationbanned' checkbox
$('#isplanned').on("click", function() {
  if ($('#isplanned').is(":checked")) {
    $('#donatedbloodamount').prop("disabled", "disabled");
    $('#donatedbloodamount').val(0);
    $('#isdonationbanned').prop("disabled", "disabled");
  }
  else {
    $('#donatedbloodamount').prop("disabled", "");
    $('#isdonationbanned').prop("disabled", "");
  }
});
