<form action="{{route('admin.settings.save')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="count_load_important_news">Count load important news</label>
                <input type="number" class="form-control" id="count_load_important_news"
                       name="count_load_important_news"
                       value="{{old('count_load_important_news',$count_load_important_news)}}"
                       min="1" step="1" required>
            </div>
            @error('count_load_important_news')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="form-group">
                <label for="count_load_fix_news">Count load fix news</label>
                <input type="number" class="form-control" id="count_load_fix_news"
                       name="count_load_fix_news" value="{{old('count_load_fix_news',$count_load_fix_news)}}"
                       min="1" step="1" required>
            </div>
            @error('count_load_fix_news')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="form-group">
                <label for="count_load_news">Count load news</label>
                <input type="number" class="form-control" id="count_load_news"
                       name="count_load_news" value="{{old('count_load_news',$count_load_news)}}"
                       min="1" step="1" required>
            </div>
            @error('count_load_news')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="col-6">

        </div>
    </div>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session()->pull('success')}}</strong>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger" role="alert">
            <strong>{{ session()->pull('error')}}</strong>
        </div>
    @endif
    <div class="col-auto my-1">
        <button type="submit" class="btn btn-primary">Send</button>
    </div>
</form>
