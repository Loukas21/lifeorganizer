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

$("#blood-donation-list").hide();


var grapharea = $('#lastSixBloodDonationsChart');

var lastSixBloodDonationsChart = new Chart(grapharea, {
    type: 'bar',
    data: {
        labels: lastSixBloodDonationsDates,
        datasets: [{
            label: 'oddana krew',
            data: lastSixBloodDonationsAmounts,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
        scales: {
            y: {
                beginAtZero: true,

            },
            x: {
                title: {
                  display: true,
                  text: '[ml]'
                },
                min: 0,
                max: 500
            }
        }
    }
});


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

//nav tabs - click blood donation list bookmark button
$('#blood-donation-list-btn').on("click", function() {
  $("#blood-donation-dashboard").hide();
  $("#blood-donation-list").show();
  $("#blood-donation-dashboard-btn").addClass('btn-light');
  $("#blood-donation-dashboard-btn").removeClass('btn-secondary');
  $("#blood-donation-list-btn").addClass('btn-secondary');
  $("#blood-donation-list-btn").removeClass('btn-light');
});

//nav tabs - click blood donation dashboard bookmark button
$('#blood-donation-dashboard-btn').on("click", function() {
  $("#blood-donation-list").hide();
  $("#blood-donation-dashboard").show();
  $("#blood-donation-list-btn").addClass('btn-light');
  $("#blood-donation-list-btn").removeClass('btn-secondary');
  $("#blood-donation-dashboard-btn").addClass('btn-secondary');
  $("#blood-donation-dashboard-btn").removeClass('btn-light');
});
