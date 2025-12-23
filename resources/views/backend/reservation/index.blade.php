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
                                        <th> Kode Reservasi </th>
                                        <th> Tanggal Reservasi </th>
                                        <th> Waktu Reservasi </th>
                                        <th> Jumlah Orang </th>
                                        <th> Status </th>
                                        <th> Status Pembayaran</th>
                                        <th></th>
                                        <th>Aksi</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($reservation as $data)
                                    <tr>
                                        <td> {{$loop->iteration}} </td>
                                        <td> {{$data->reserve_code}} </td>
                                        <td> {{\Carbon\Carbon::parse($data->reservation_date)->format('d-m-Y')}} </td>
                                        <td> {{\Carbon\Carbon::parse($data->reservation_time)->format('H:i')}} </td>
                                        <td> {{$data->guest_count}} </td>
                                        <td> 
                                            <span class="badge
                                                {{ $data->status == 'pending'
                                                    ? 'bg-warning text-dark'
                                                    : ($data->status == 'confirmed'
                                                        ? 'bg-primary'
                                                        : ($data->status == 'cancelled'
                                                            ? 'bg-danger'
                                                            : 'bg-success')) }}">
                                                {{ ucfirst($data->status) }}
                                            </span>
                                        </td>
                                        
                                        <td> 
                                            <span class="badge
                                                {{ $data->payment_status == 'unpaid'
                                                    ? 'bg-warning text-dark'
                                                    : ($data->payment_status == 'paid'
                                                        ? 'bg-success'
                                                        : 'bg-danger') }}">
                                                {{ ucfirst($data->payment_status) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('backend.reservation.show', $data->id) }}"
                                                class="btn btn-sm btn-info">
                                                Lihat
                                            </a>                                             
                                        </td>

                                        <td>
                                            <a href="{{ route('backend.reservation.edit', $data->id) }}"
                                                class="btn btn-sm btn-warning">
                                                Ubah
                                            </a> 
                                        </td>

                                        <td>
                                            <a href="{{ route('backend.reservation.destroy', $data->id) }}"
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