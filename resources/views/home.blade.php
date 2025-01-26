<x-layout>
    <div class="w-100 d-flex justify-content-between">
        <form class="w-50" id="add-post">
            @csrf
            <input class="form-control mb-4" placeholder="Title"  type="text" name="title">
            <input class="form-control mb-4" placeholder="Description"  type="text" name="description">
            <button type="submit" class="btn btn-primary w-100">Add</button>
        </form>
        <div class="w-50" id="post-list">
            @foreach ($posts as $post)
                <p class="text-end">{{ $post->title }}</p>
            @endforeach
        </div>
    </div>
</x-layout>

<script type="text/javascript">

    $(document).ready(function() {

        $('#add-post').on('submit', function(event) {
            
            event.preventDefault();

            jQuery.ajax({
                type: 'POST',
                url: "{{ url('ajaxupload') }}",
                data: jQuery('#add-post').serialize(),

                success: function(result) {
                    console.log(result);
                    if (result.status === 200) {
                        $('#post-list').append(`<p class="text-end">${result.post.title}</p>`);
                        $('#add-post')[0].reset();
                    } else {
                        console.error('Une erreur est survenue.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur:', error);
                }
            });
        });
    });

</script>