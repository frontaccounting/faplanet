  
$(document).ready(function() 
{ 
  $(".select2").select2({ placeholder: "Select a State", maximumSelectionSize: 6 });
  var dtable = $("#table-pager").DataTable({"order": [[ 0, "desc" ]], "columnDefs": [{orderable: false, "targets": -1}], "dom": "frtip", "paging": true, "info": false});
  //$("#pager-search").on('keyup', function(){ dtable.search('102').draw(); });
});
