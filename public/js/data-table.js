$(document).ready(function() {
    $('.app-data-table').DataTable({
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
