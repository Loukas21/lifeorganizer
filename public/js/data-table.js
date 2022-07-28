$.fn.dataTable.ext.type.detect.unshift(function (d) {
  return d === '--nieokreślony--' ||
  d === 'początkujący (A1)' ||
  d === 'podstawowy (A2)' ||
  d === 'średnio zaawansowany (B1)' ||
  d === 'wyższy średnio zaawansowany (B2)' ||
  d === 'zaawansowany (C1)' ||
  d === 'zaawansowany biegły (C2)' ||
  d === 'język ojczysty' ? 'language-level' : null;
});

$.fn.dataTable.ext.type.order['language-level-pre'] = function (d) {
  switch (d) {
      case '--nieokreślony--':
          return 0;
      case 'początkujący (A1)':
          return 1;
      case 'podstawowy (A2)':
          return 2;
      case 'średnio zaawansowany (B1)':
          return 3;
      case 'wyższy średnio zaawansowany (B2)':
          return 4;
      case 'zaawansowany (C1)':
          return 5;
      case 'zaawansowany biegły (C2)':
          return 6;
      case 'język ojczysty':
          return 7;
  }
  return 0;
};

$(document).ready(function() {
    $('.app-data-table').DataTable({
      columnDefs: [
        { orderable: false, targets: 'nosort' },
        { searchable: false, targets: 'noorder' },
      ],
      "language": {
        "paginate": {
          "previous": "Poprzednia",
          "next": "Następna"
        },
        "search": "Wyszukaj:",
        "lengthMenu": "Pokaż _MENU_ rekordów",
        "info": "Wyświetlane rekordy _START_-_END_ / _TOTAL_",
        "infoEmpty": "Wyświetlane rekordy 0-0 / 0",
        "infoFiltered": "(wyfiltrowane z _MAX_)",
        "zeroRecords": "Nie znaleziono rekordów"
      }
  });
  $('.blood-donation-table').DataTable({
    columnDefs: [
      { orderable: false, targets: 'nosort' },
      { searchable: false, targets: 'noorder' },
    ],
    order: [0, "desc"],
    "language": {
      "paginate": {
        "previous": "Poprzednia",
        "next": "Następna"
      },
      "search": "Wyszukaj:",
      "lengthMenu": "Pokaż _MENU_ rekordów",
      "info": "Wyświetlane rekordy _START_-_END_ / _TOTAL_",
      "infoEmpty": "Wyświetlane rekordy 0-0 / 0",
      "infoFiltered": "(wyfiltrowane z _MAX_)",
      "zeroRecords": "Nie znaleziono rekordów"
    }
  });

  $('.languages-table').DataTable({
    columnDefs: [
      { orderable: false, targets: 'nosort' },
      { searchable: false, targets: 'noorder' },
    ],
    order: [0, "desc"],
    "language": {
      "paginate": {
        "previous": "Poprzednia",
        "next": "Następna"
      },
      "search": "Wyszukaj:",
      "lengthMenu": "Pokaż _MENU_ rekordów",
      "info": "Wyświetlane rekordy _START_-_END_ / _TOTAL_",
      "infoEmpty": "Wyświetlane rekordy 0-0 / 0",
      "infoFiltered": "(wyfiltrowane z _MAX_)",
      "zeroRecords": "Nie znaleziono rekordów"
    }
  });


} );
