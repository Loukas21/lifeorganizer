//on page load
$(document).ready(function() {
  // 'iswanted' field is checked
  if ($('#iswanted').is(":checked")) {
    // unset type
    $('#type').val(0);
    // disable 'type' field
    $('#type').prop("disabled", "disabled");
    // set 0 value in 'currentprogress' field
    $('#currentprogress').val(0);
    // disable 'currentprogress' field
    $('#currentprogress').prop("disabled", "disabled");
    // uncheck 'isfinished' checkbox
    $('#isfinished').prop("checked", false);
    // disable 'isfinished' checkbox
    $('#isfinished').prop("disabled", "disabled");
  }
  // 'isfinished' field is checked
  if ($('#isfinished').is(":checked")) {
    // uncheck 'iswanted' checkbox
    $('#iswanted').prop("checked", false);
    // disable 'iswanted' checkbox
    $('#iswanted').prop("disabled", "disabled");
    // disable 'totality' field
    $('#totality').prop("disabled", "disabled");
    // disable 'currentprogress' field
    $('#currentprogress').prop("disabled", "disabled");
  }
  // 'currentprogress' is greather than 0
  if ($('#currentprogress').val() > 0) {
    // uncheck 'iswanted' checkbox
    $('#iswanted').prop("checked", false);
    // disable 'iswanted' checkbox
    $('#iswanted').prop("disabled", "disabled");
    if ($('#currentprogress').val() == $('#totality').val()) {
      // enable 'isfinished' checkbox
      $('#isfinished').prop("disabled", "");
    }
    else {
      // disable 'isfinished' checkbox
      $('#isfinished').prop("disabled", "disabled");
      // uncheck 'isfinished' checkbox
      $('#isfinished').prop("checked", false);
    }
  }
  else {
    // disable 'isfinished' checkbox
    $('#isfinished').prop("disabled", "disabled");
  }

  $("#publications-book-list").hide();
  $("#publications-recording-list").hide();
  $("#publications-wish-list").hide();
});

//after click 'iswanted' checkbox
$('#iswanted').on("click", function() {
  // 'iswanted' checkbox is checked
  if ($('#iswanted').is(":checked")) {
    // unset type
    $('#type').val(0);
    // disable 'type' field
    $('#type').prop("disabled", "disabled");
    // set 0 value in 'currentprogress' field
    $('#currentprogress').val(0);
    // disable 'currentprogress' field
    $('#currentprogress').prop("disabled", "disabled");
    // uncheck 'isfinished' checkbox
    $('#isfinished').prop("checked", false);
    // disable 'isfinished' checkbox
    $('#isfinished').prop("disabled", "disabled");
  }
  else {
    // enable 'type' field
    $('#type').prop("disabled", "");
    // enable 'currentprogress' field
    $('#currentprogress').prop("disabled", "");
    // 'totality' field value is greather than 0 and the same as 'currentprogress' field value
    if ($('#totality').val() > 0 && ($('#totality').val() == $('#currentprogress').val())) {
        // enable 'isfinished' checkbox
        $('#isfinished').prop("disabled", "");
    }
    else {
        // disable 'isfinished' checkbox
        $('#isfinished').prop("disabled", "disabled");
    }
  }
});

//after change value in 'totality' field
$('#totality').on("change", function() {
  // 'totality' value is greather than 0
  if ($('#totality').val() > 0) {
    // 'totality' value is the same as 'currentprogress' value
    if ($('#totality').val() == $('#currentprogress').val()) {
      // enable 'isfinished' checkbox
      $('#isfinished').prop("disabled", "");
    }
    else {
      // disable 'isfinished' checkbox
      $('#isfinished').prop("disabled", "disabled");
    }
  }
});

//after change value in 'currentprogress' field
$('#currentprogress').on("change", function() {
  // 'currentprogress' value is greather than 0
  if ($('#currentprogress').val() > 0) {
    // uncheck 'iswanted' checkbox
    $('#iswanted').prop("checked", false);
    // disable 'iswanted' checkbox
    $('#iswanted').prop("disabled", "disabled");
    // 'totality' value is the same as 'currentprogress' value
    if ($('#totality').val() == $('#currentprogress').val()) {
      // enable 'isfinished' checkbox
      $('#isfinished').prop("disabled", "");
    }
    else {
      // disable 'isfinished' checkbox
      $('#isfinished').prop("disabled", "disabled");
    }
  }
  else {
    // enable 'iswanted' checkbox
    $('#iswanted').prop("disabled", "");
    // disable 'isfinished' checkbox
    $('#isfinished').prop("disabled", "disabled");
  }
});

//after click 'isfinished' checkbox
$('#isfinished').on("click", function() {
  // 'isfinished' checkbox is checked
  if ($('#isfinished').is(":checked")) {
    // uncheck 'iswanted' checkbox
    $('#iswanted').prop("checked", false);
    // disable 'iswanted' checkbox
    $('#iswanted').prop("disabled", "disabled");
    // disable 'totality' field
    $('#totality').prop("disabled", "disabled");
    // disable 'currentprogress' field
    $('#currentprogress').prop("disabled", "disabled");
  }
  else {
    // 'currentprogress' value is not greather than 0
    if ($('#currentprogress').val() <= 0) {
      // enable 'iswanted' checkbox
      $('#iswanted').prop("disabled", "");
    }
    // enable 'totality' field
    $('#totality').prop("disabled", "");
    // enable 'currentprogress' field
    $('#currentprogress').prop("disabled", "");
  }
});

//nav tabs - click publications dashboard bookmark button
$('#publications-dashboard-btn').on("click", function() {
  $("#publications-book-list").hide();
  $("#publications-recording-list").hide();
  $("#publications-wish-list").hide();
  $("#publications-dashboard").show();
  $("#publications-dashboard-btn").removeClass('btn-light');
  $("#publications-dashboard-btn").addClass('btn-secondary');
  $("#publications-book-list-btn").removeClass('btn-secondary');
  $("#publications-book-list-btn").addClass('btn-light');
  $("#publications-recording-list-btn").removeClass('btn-secondary');
  $("#publications-recording-list-btn").addClass('btn-light');
  $("#publications-wish-list-btn").removeClass('btn-secondary');
  $("#publications-wish-list-btn").addClass('btn-light');
});

//nav tabs - click publications book list bookmark button
$('#publications-book-list-btn').on("click", function() {
  $("#publications-recording-list").hide();
  $("#publications-wish-list").hide();
  $("#publications-dashboard").hide();
  $("#publications-book-list").show();
  $("#publications-dashboard-btn").removeClass('btn-secondary');
  $("#publications-dashboard-btn").addClass('btn-light');
  $("#publications-book-list-btn").removeClass('btn-light');
  $("#publications-book-list-btn").addClass('btn-secondary');
  $("#publications-recording-list-btn").removeClass('btn-secondary');
  $("#publications-recording-list-btn").addClass('btn-light');
  $("#publications-wish-list-btn").removeClass('btn-secondary');
  $("#publications-wish-list-btn").addClass('btn-light');
});

//nav tabs - click publications recording list bookmark button
$('#publications-recording-list-btn').on("click", function() {
  $("#publications-recording-list").show();
  $("#publications-wish-list").hide();
  $("#publications-dashboard").hide();
  $("#publications-book-list").hide();
  $("#publications-dashboard-btn").removeClass('btn-secondary');
  $("#publications-dashboard-btn").addClass('btn-light');
  $("#publications-book-list-btn").addClass('btn-light');
  $("#publications-book-list-btn").removeClass('btn-secondary');
  $("#publications-recording-list-btn").addClass('btn-secondary');
  $("#publications-recording-list-btn").removeClass('btn-light');
  $("#publications-wish-list-btn").removeClass('btn-secondary');
  $("#publications-wish-list-btn").addClass('btn-light');
});

//nav tabs - click publications wish list bookmark button
$('#publications-wish-list-btn').on("click", function() {
  $("#publications-recording-list").hide();
  $("#publications-wish-list").show();
  $("#publications-dashboard").hide();
  $("#publications-book-list").hide();
  $("#publications-dashboard-btn").removeClass('btn-secondary');
  $("#publications-dashboard-btn").addClass('btn-light');
  $("#publications-book-list-btn").addClass('btn-light');
  $("#publications-book-list-btn").removeClass('btn-secondary');
  $("#publications-recording-list-btn").removeClass('btn-secondary');
  $("#publications-recording-list-btn").addClass('btn-light');
  $("#publications-wish-list-btn").addClass('btn-secondary');
  $("#publications-wish-list-btn").removeClass('btn-light');
});
