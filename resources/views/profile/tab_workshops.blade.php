<div class="tab-pane fade justify-content-center" id="navs-workshops-card" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="workshops" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>نام خدمت</th>
                        <th>نوع خدمت</th>
                        <th>مبلغ خدمت</th>
                        <th>مبلغ پرداخت شده</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @if(Auth::user()->level == 'site')
        <script type="text/javascript">
            $(document).ready(function () {
                const walletsTable = $('#workshops.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('invoice.edit' , Auth::user()->id) }}",
                        data: function (d) {
                            d.id = "{{ Auth::user()->id }}";
                        }
                    },
                    columns: [
                        {data: 'id'             , name: 'id'  },
                        {data: 'product_name'   , name: 'product_name'  },
                        {data: 'product_type'   , name: 'product_type'  },
                        {data: 'product_price'  , name: 'product_price' },
                        {data: 'final_price'    , name: 'final_price'   },
                        {data: 'status'         , name: 'status'        },
                    ],
                    order: [[0, 'desc']],
                    paging: true,
                    searching: true,
                    info: false,
                    language: {
                        url: "{{ asset('assets/vendor/js/fa.json') }}"
                    }
                });
            });
        </script>
    @endif
@endpush
