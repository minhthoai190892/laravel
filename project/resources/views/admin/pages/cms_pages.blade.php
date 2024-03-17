  {{-- tạo phần nội dung --}}
  @extends('admin.layout.layout')
  @section('content')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1 class="m-0">CMS Pages</h1>
                      </div><!-- /.col -->
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">CMS Pages</li>
                          </ol>
                      </div><!-- /.col -->
                  </div><!-- /.row -->
              </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-12">

                          <!-- /.card -->

                          <div class="card">
                              <div class="card-header">
                                  <h3 class="card-title">CMS Pages</h3>
                                  <a style="max-width: 150px;float: right;display: inline-block;"
                                      class="btn btn-block btn-primary" href="{{ url('admin/add-edit-cms-page') }}"
                                      target="_blank" rel="noopener noreferrer">Add CMS Page</a>

                              </div>
                              <!-- /.card-header -->
                              <div class="card-body">
                                  <table id="cmspages" class="table table-bordered table-striped">
                                      <thead>
                                          <tr>
                                              <th>ID</th>
                                              <th>Title</th>
                                              <th>URL</th>
                                              <th>Create on</th>
                                              <th>Actions</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($CmsPages as $page)
                                              <tr>
                                                  <td>{{ $page['id'] }}</td>
                                                  <td>{{ $page['title'] }}</td>
                                                  <td>{{ $page['url'] }}</td>
                                                  <td>{{ $page['created_at'] }}</td>
                                                  {{-- kiểm tra trạng thái --}}
                                                  @if ($page['status'] == 1)
                                                      <td><a href="javascript:void(0)" class="updateCmsPageStatus"
                                                              id="page-{{ $page['id'] }}" page_id={{ $page['id'] }}><i
                                                                  class="fas fa-toggle-on" status="Active"></i></a></td>
                                                  @else
                                                      <td><a href="javascript:void(0)" class="updateCmsPageStatus"
                                                              id="page-{{ $page['id'] }}" page_id={{ $page['id'] }}
                                                              style="color: grey"><i class="fas fa-toggle-off"
                                                                  status="Inactive"></i></a></td>
                                                  @endif
                                              </tr>
                                          @endforeach

                                      </tbody>

                                  </table>
                              </div>
                              <!-- /.card-body -->
                          </div>
                          <!-- /.card -->
                      </div>
                      <!-- /.col -->
                  </div>
                  <!-- /.row -->
              </div>
              <!-- /.container-fluid -->
          </section>
          <!-- /.content -->
      </div>
  @endsection
