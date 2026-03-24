<div>
    <table border="1">
        <tr>
            <td>id</td>
            <td>title</td>
            <td>body</td>
        </tr>
        @foreach($data as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->body}}</td>
            </tr>
        @endforeach
    </table>
</div>