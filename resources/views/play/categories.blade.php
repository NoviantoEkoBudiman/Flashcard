@extends('index')

@section('main')

    <h2>{{ $language->languages_name }}'s Categories</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category's Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($categories as $key=>$category)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $category->categories_name }}</td>
                  <td>
                    <div class="d-flex flex-wrap gap-2">
                      <a href="{{ route('play.show', ['play' => $category->categories_id, 'mode' => 'question-first']) }}" class="btn btn-sm btn-outline-primary">
                        <span data-feather="help-circle" class="align-text-bottom"></span> Question First
                      </a>
                      <a href="{{ route('play.show', ['play' => $category->categories_id, 'mode' => 'answer-first']) }}" class="btn btn-sm btn-outline-success">
                        <span data-feather="message-circle" class="align-text-bottom"></span> Answer First
                      </a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
@endsection
