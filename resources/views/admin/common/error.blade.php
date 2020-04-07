@if(count($errors)>0)
    @foreach($errors->all() as $v)
    <div class="Huialert Huialert-error"><i class="Hui-iconfont">&#xe6a6;</i>{{$v}}</div>
    @endforeach
@endif