@extends('admin.layouts.default')
@section('content')
  <div class="admin-modal " id="create-product" >
    @if (session('status'))
      <div class="message is-dark" >
        <div class="message-body" >
          {{ session('status') }}
        </div >
      </div >
    @endif
    <form action="{{ route('storeBanner')}}" method="post" enctype="multipart/form-data" >
      @csrf
      <div class="field" >
        <label for="location" class="label" >Выберите локацию</label >
        <div class="control" >
          <div class="select is-fullwidth" >
            <select id="location" name="location" >
              <option value="top_slider" >Верхний слайдер</option >
              <option value="bottom_slider" >Нижний слайдер</option >
            </select >
          </div >
        </div >
      </div >
      <div class="url" >
        <div class="field" >
          <label for="url" class="label" >URL</label >
          <div class="control" >
            <input id="url" class="input" type="text" placeholder="URL" name="url" >
          </div >
        </div >
      </div >
      <div class="position" >
        <div class="field" >
          <label for="position" class="label" >Position</label >
          <div class="control" >
            <input id="position" class="input" type="text" placeholder="Position" name="position" >
          </div >
        </div >
      </div >
      <div class="file-inputs is-flex is-flex-wrap-wrap py-2" >
        <div class="file has-name  is-flex is-flex-direction-column is-align-items-center is-justify-content-flex-end
    my-3 mr-3" >
          <img class="file-image " src="" alt="" >
          <label class="file-label my-3" >
            <input class="file-input" type="file" accept="image/gif, image/jpeg, image/png" name="image[]" >
            <span class="file-cta" >
        <span class="file-icon" >
          <i class="fas fa-upload" ></i >
        </span >
        <span class="file-label" >
          Выберите файл
        </span >
        </span >
            <span class="file-name" >
        </span >
          </label >

        </div >
      </div >

      <div class="field is-grouped" >
        <div class="control" >
          <button type="submit" class="button is-success" >Отправить</button >
        </div >
      </div >

    </form >

  </div >
@endsection
