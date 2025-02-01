<x-layout>
    <div class="w-100">
        <form id="add-post">
            @csrf
            <input class="form-control mb-4" placeholder="Title"  type="text" name="title">
            <input class="form-control mb-4" placeholder="Description"  type="text" name="description">
            <button type="submit" class="btn btn-primary w-100">Add</button>
        </form>
    </div>
    <!--
    <div id="post-list" class="d-grid gap-2">
        @foreach ($posts as $post)
            <p>{{ $post->title }}</p>
        @endforeach
    </div>
    -->
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
                        // $('#post-list').append(`<p>${result.post.title}</p>`);
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