@extends('index')

@section('main')
    <button class="btn-rounded btn btn-m btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <span data-feather="plus" class="align-text-bottom"></span>
        Add Language
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('language.store') }}" method="post">
            @csrf
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Language</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Language Name:</p>
              <input type="text" name="languages_name" value="{{ old('languages_name') }}" class="form-control" required maxlength="255">
              @error('languages_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <br>

    <h2>Your Language's</h2>
    <div class="table-responsive">
      <table class="table table-striped table-sm" id="myTable">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Language's Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($languages as $key=>$language)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $language->languages_name }}</td>
              <td><a href="{{ route('category.show',$language->languages_id) }}" class="btn btn-sm btn-outline-primary"><span data-feather="plus" class="align-text-bottom"></span> Add Categories</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if ($errors->has('languages_name'))
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          new bootstrap.Modal(document.getElementById('exampleModal')).show();
        });
      </script>
    @endif
@endsection
