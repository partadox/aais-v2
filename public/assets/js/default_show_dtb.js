// Change Default Show Entries Page
$(document).ready(function() {
  $('#datatable').dataTable( {
  "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
  "pageLength": 25,
  "destroy": true,
  "stateSave": true,
  } );
} );