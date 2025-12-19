@extends('layouts.backend')

@section('styles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        Data Reservasi
                    </div>

                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table" id="datareservasi">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th> Nama Customer </th>
                                        <th> Tanggal Reservasi </th>
                                        <th> Waktu Reservasi </th>
                                        <th> Jumlah Orang </th>
                                        <th> Status </th>
                                        <th> Status Pembayaran</th>
                                        <th> Aksi </th>
                                    </tr>

                                </thead>

                                <tbody>
                                    @foreach ($product as $data)
                                    <tr>
                                        <td> {{$loop->iteration}} </td>
                                        <td> {{$data->user->name}} </td>
                                        <td> {{$data->reservation_date}} </td>
                                        <td> {{$data->reservation_time}} </td>
                                        <td> {{$data->guest_count}} </td>
                                        <td> {{$data->status}} </td>
                                        <td> {{$data->payment_status}} </td>
                                        <td> 
                                            <a href="{{ route('backend.product.show', $data->id) }}"
                                                class="btn btn-sm btn-success">
                                                Tampilkan
                                            </a> |

                                            <a href="{{ route('backend.product.edit', $data->id) }}"
                                                class="btn btn-sm btn-warning">
                                                Ubah
                                            </a> |

                                            <a href="{{ route('backend.product.destroy', $data->id) }}"
                                                class="btn btn-sm btn-danger"
                                                data-confirm-delete="true">
                                                Hapus
                                            </a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#datareservasi').DataTable();
    });
    </script>
@endpush