<div>
    <!-- <form action="/any" method="post"> -->
        <form action="/match" method="post">
        @csrf
        @method('POST')
        <div>
            <label for="title"></label>
            <input type="text" name="title" id="title" required>
        </div>
        <input type="submit" value="Submit">
    </form>
</div>