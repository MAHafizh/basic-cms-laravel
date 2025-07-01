@props(['value'=> ''])
<textarea name="body" id="article-body">{!!$value!!}</textarea>

<script src="https://cdn.tiny.cloud/1/bm9bguzatsfr1on2fjbbkeqxd03xpvr8ptdeppwisuhjhtdh/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#article-body', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
</script>
