@extends('layouts.backend')

@section('content')
 <div class="container-fluid">
          <!--  Owl carousel -->
          <div class="owl-carousel counter-carousel owl-theme">
            <div class="item">
              <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/backend/images/svgs/icon-briefcase.svg')}}" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-warning mb-1">News</p>
                    <h5 class="fw-semibold text-warning mb-0">{{$totalNews}}</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/backend/images/svgs/icon-mailbox.svg')}}" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-info mb-1">Products</p>
                    <h5 class="fw-semibold text-info mb-0">{{$totalProducts}}</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/backend/images/svgs/icon-favorites.svg')}}" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-danger mb-1">Contact</p>
                    <h5 class="fw-semibold text-danger mb-0">{{$totalContacts}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- Row 1 Products table --}}
          @section('styles')
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
          @endsection
          <div class="container-fluid">
              <div class="row">
                  <div class="col">
                      <div class="card">
                          <div class="card-header bg-secondary text-white">
                              Kontak list
                          </div>

                          <div class="card-body">
                              <div class="table table-responsive">
                                  <table class="table" id="dataproducts">
                                      <thead>
                                          <tr>
                                              <th> No </th>
                                              <th> subject  </th>
                                              <th> Nama Pelanggan  </th>
                                              <th> Email Pelanggan  </th>
                                              <th>Baca Pesan</th>
                                          </tr>

                                      </thead>

                                      <tbody>
                                          @foreach ($contacts as $data)
                                          <tr>
                                              <td> {{$loop->iteration}} </td>
                                              <td> {{$data->subject}} </td>
                                              <td> {{$data->name}} </td>
                                              <td> {{$data->email}} </td>
                                              <td>
                                                <a href="{{ route('backend.contact.show', $data->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    Tampilkan
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
    <script src="{{asset('assets/backend/libs/owl.carousel/dist/owl.carousel.min.js')}}"></script>
    <script>
    $(document).ready(function () {
        $('#dataproducts').DataTable();
    });
    </script>
    
@endpush