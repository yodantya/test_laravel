@extends('layouts.default')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                </h3>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2>Data Penduduk</h2>
                <button class="btn btn-info float-sm-right ml-1 " onclick="tambah()" data-toggle="tooltip"
                    data-placement="top" title="Tambah Data"><span class="fas fa fa-plus"></span> Tambah Data</button>
                <button class="btn btn-default float-sm-right" onclick="reload_table()" data-toggle="tooltip"
                    data-placement="top" title="Reload Table"><i class="fas fa fa-sync"></i> Reload</button>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Tanggal Input</th>
                            <th>User Input</th>
                            <th>Tanggal Update</th>
                            <th>User Update</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="form-group">
                        <input type="text" name="nik" class="form-control" placeholder="Masukan NIK">
                    </div>
                    <div class="form-group">
                        <input type="text" name="nama" class="form-control" placeholder="Masukan NAMA">
                    </div>
                    <div class="form-group">
                        <input type="text" name="jenis_kelamin" class="form-control"
                            placeholder="Masukan Jenis Kelamin">
                    </div>
                    <div class="form-group">
                        <input type="text" name="alamat" class="form-control" placeholder="Masukan Alamat">
                    </div>
                    <div class="form-group">
                        <input type="text" name="tanggalinput" class="form-control" placeholder="Tanggal Input">
                    </div>
                    <div class="form-group">
                        <input type="text" name="userinput" class="form-control" placeholder="User Input">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="save()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    function tambah() {
        // $('#form')[0].reset();
        $('#modal').modal('show')
        $('.modal-title').text('Tambah Data')
    }

</script>
<script type="text/javascript">
    var table;
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        table = $("#table").DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "ajax": {
                "url": "{{ route('getPenduduk') }}",
                "type": "GET",
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ],
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'tanggalinput',
                    name: 'tanggalinput'
                },
                {
                    data: 'userinput',
                    name: 'userinput'
                },
                {
                    data: 'tanggalupdate',
                    name: 'tanggalupdate'
                },
                {
                    data: 'userupdate',
                    name: 'userupdate'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ],
            "dom": 'Bfrtip',
            "buttons": [
                'pageLength',
                'excelHtml5',
                {
                    extend: 'pdfHtml5',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                'colvis'
            ],
        });

        table.buttons().container()
            .insertBefore('#example_filter');
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
        info();
    }

    function save(){
      $.ajax({
        url : "{{ route('penduduk.store') }}",
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data) {
          if(data.status) {
            $('#modal').modal('hide');
            reload_table();
            }
        },
        error: function (jqXHR, textStatus , errorThrown){ 
          
        }
      });
    }

</script>
@endsection