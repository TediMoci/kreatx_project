<ul>
    @foreach($childs as $child)
        <li>
            <a href="/departments/{{$child->id}}">{{$child->title}}</a>
            @if(count($child->childs))
                @include('departments.manageChild',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>