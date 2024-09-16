@extends('layouts.index')

@section('files')
    <script src="/quill/quill.js"></script>
    <script src="/quill/quill-resize-module.min.js"></script>
    <link href="/quill/quill.snow.css" rel="stylesheet"/>


    {{--    <link--}}
    {{--        crossorigin="anonymous"--}}
    {{--        integrity="sha384-7kltdnODhBho8GSWnwD9l9rilXkpuia4Anp4TKHPOrp8/MS/+083g4it4MYED/hc"--}}
    {{--        href="http://lib.baomitu.com/quill/2.0.0-dev.3/quill.snow.min.css"--}}
    {{--        rel="stylesheet"--}}
    {{--    />--}}
    {{--    <script--}}
    {{--        crossorigin="anonymous"--}}
    {{--        integrity="sha384-MDio1/ps0nK1tabxUqZ+1w2NM9faPltR1mDqXcNleeuiSi0KBXqIsWofIp4r5A0+"--}}
    {{--        src="http://lib.baomitu.com/quill/2.0.0-dev.3/quill.min.js"--}}
    {{--    ></script>--}}
    {{--    <script src="https://cdn.jsdelivr.net/gh/scrapooo/quill-resize-module@1.0.2/dist/quill-resize-module.js"></script>--}}

@endsection

@section('body')

    <div class="p-2">
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif

        <form method="POST" action="/announcement" id="announcementForm">

            @csrf

            <label class="input input-bordered flex items-center gap-2 mb-2">
                Title
                <input name="title" type="text" class="grow" placeholder="Daisy"/>
            </label>

            <div id="editor"></div>

            <textarea id="content" name="content" type="hidden" class="hidden"></textarea>

            <div>
                <button class="col-span-2 btn bg-slate-400">Cancel</button>
                <button class="col-span-2 btn bg-primary">Save</button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        const announcementForm = document.querySelector('#announcementForm');

        Quill.register("modules/resize", window.QuillResizeModule);

        var icons = Quill.import('ui/icons');

        icons['code-block'] = '<i class="fa-regular fa-file"></i>';

        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],          // Basic text formatting
            [{'list': 'ordered'}, {'list': 'bullet'}],       // Lists
            ['blockquote',],                      // Block-level elements
            [{'size': ['small', 'normal', 'large', 'huge']}],
            [{'header': [1, 2, 3, 4, 5, 6, false]}],          // Headers
            [{'color': []}, {'background': []}],            // Text color and background
            [{'font': []}],                                   // Font family
            [{'align': []}],                                  // Text alignment
            [{'script': 'sub'}, {'script': 'super'}],        // Superscript and subscript
            [{'indent': '-1'}, {'indent': '+1'}],            // Indentation
            ['link', 'image', 'video', 'code-block'],                        // Links, images, and videos
            ['clean'],                                          // Clear formatting
        ];


        var quill = new Quill("#editor", {
            theme: "snow",
            modules: {
                toolbar: toolbarOptions,
                resize: {},
            },
        });

        quill.getModule("toolbar").addHandler("image", function () {

            // Create an input element to select the image file
            const input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("accept", "image/*");
            input.click();

            // Handle the image file selection
            input.onchange = async function () {
                const file = input.files[0];

                // Create a FormData object to store the image file
                const formData = new FormData();
                formData.append("image", file);

                // Log the image uploading process
                console.log("Uploading image:", file.name);
                try {

                    // Send the image file to the server using Fetch
                    const result = await fetch("/announcement-attachment", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": '{{csrf_token()}}'
                        }
                    });

                    const data = await result.json();

                    console.log(data);

                    if (!result.ok) {
                        throw new Error("Error uploading file");
                    }

                    const range = quill.getSelection();
                    quill.insertEmbed(range.index, "image", data.file);
                } catch (error) {
                    console.log(error.message)
                }
            };
        });

        announcementForm.addEventListener("submit", (event) => {
            event.preventDefault();
            document.querySelector('#content').innerHTML = document.querySelector(".ql-editor").innerHTML;
            announcementForm.submit();
        });

    </script>
@endsection
