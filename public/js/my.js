

      $(function() {
        var route = <? php route("userdata"); ?>;
        alert(route);
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ route("userdata") }}',
               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'name', name: 'Zone Name' },
                         { data: 'email', name: 'User Email' },
                         { data: 'display_name', name: 'User Role' },
                         { data: 'action', name: 'Actions' },              
                        
                     ]
            });
         });
    