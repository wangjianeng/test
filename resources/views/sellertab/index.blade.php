@extends('layouts.layout')
@section('label', 'Seller Tab Config')
@section('content')
    <h1 class="page-title font-red-intense"> Seller Tab Config
        <small>Seller Tab Config.</small>
    </h1>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Seller Tab List</span>
                    </div>
                </div>
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="{{ url('sellertab/create')}}"><button id="sample_editable_1_2_new" class="btn sbold blue"> Add New
                                    <i class="fa fa-plus"></i>
                                </button>
                                </a>
                            </div>
                        </div>
                        <!--
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <button class="btn blue  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="manage_account">
                        <thead>
                        <tr>
                            <th > ID </th>
                            <th> Tab Name </th>
							<th> Users </th>
                            <th> Actions </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tabs as $tab)
                            <tr class="odd gradeX">
                                <td>
                                    {{$tab['id']}}
                                </td>
                                <td>
                                    {{$tab['tab']}}
                                </td>
								
								
								<td>
                                   
                                </td>

                                <td>

                                    <a href="{{ url('sellertab/'.$tab['id'].'/edit') }}">
                                        <button type="submit" class="btn btn-success btn-xs">Edit</button>
                                    </a>
                                    <form action="{{ url('sellertab/'.$tab['id']) }}" method="POST" style="display: inline;">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>




    <script>
        $(function() {
        var TableDatatablesManaged = function () {

            var initTable = function () {

                var table = $('#manage_account');

                // begin first table
                table.dataTable({

                    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "No data available in table",
                        "info": "Showing _START_ to _END_ of _TOTAL_ records",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
                        "lengthMenu": "Show _MENU_",
                        "search": "Search:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous":"Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                    "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

                    "lengthMenu": [
                        [5, 15, 20, -1],
                        [5, 15, 20, "All"] // change per page values here
                    ],
                    // set the initial value
                    "pageLength": 20,
                    "pagingType": "bootstrap_full_number",
                    "columnDefs": [

                        {
                            "className": "dt-right",
                            //"targets": [2]
                        }
                    ],
                    "order": [
                        [1, "asc"]
                    ] // set first column as a default sort by asc
                });

            }


            return {

                //main function to initiate the module
                init: function () {
                    if (!jQuery().dataTable) {
                        return;
                    }

                    initTable();
                }

            };

        }();



            TableDatatablesManaged.init();
        });


</script>


@endsection
