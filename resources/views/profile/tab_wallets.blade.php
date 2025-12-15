<div class="tab-pane fade justify-content-center" id="navs-wallets-card" role="tabpanel">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMinutesModal">
            <i class="mdi mdi-plus"></i>شارژ کیف پول
        </button>
    </div>
    <div class="modal fade" id="addMinutesModal" tabindex="-1" aria-labelledby="addMinutesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">شارژ کیف پول</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="card-body">
                    <div class="modal-body">
                        <form onsubmit="handleCreate(this); return false;" id="addform" class="row g-4 mb-4" data-table-target="#wallets" action="{{ route('wallet.store') }}" method="POST">
                            @csrf
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="مبلغ شارژ">
                            <label for="amount">مبلغ شارژ</label>
                        </div>
                    </div>
                        <div class="col-12 text-center">
                            <button type="submit" id="submit" class="btn btn-primary">ارسال</button>
                        </div>
                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="wallets" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>سریال تراکنش</th>
                        <th>کد رهگیری</th>
                        <th>نوع تراکنش</th>
                        <th>مبلغ</th>
                        <th>توضیحات</th>
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
                const walletsTable = $('#wallets.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('wallet.show' , Auth::user()->id) }}",
                        data: function (d) {
                            d.id = "{{ Auth::user()->id }}";
                        }
                    },
                    columns: [
                        {data: 'id'             , name: 'id'   },
                        {data: 'referenceId'    , name: 'referenceId'   },
                        {data: 'type'           , name: 'type'          },
                        {data: 'amount'         , name: 'amount'        },
                        {data: 'description'    , name: 'description'   },
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
