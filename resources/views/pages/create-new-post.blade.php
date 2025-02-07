@extends('utils.index')
@section('title', 'Create New Post')

@section('content')
    <div class="flex flex-col gap-4 bg-slate-900 text-white mx-10 md:mx-32 lg:mx-56">
        <div class="flex flex-col items-center justify-center px-4 py-4 mx-auto lg:py-6">
            <p class="text-2xl lg:text-4xl">Create New Post</p>
        </div>

        @if ($errors->any())
            <div class="flex flex-col items-center justify-center px-4 py-4 mx-auto lg:py-6">
                @foreach ($errors->all() as $error)
                    <p class="text-red-500 text-lg">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="">
            <form action="{{ route('save-user-content') }}" method="post" class="flex flex-col gap-4"
                enctype="multipart/form-data">
                @csrf
                <label id="dropzone-file" for="file_path"
                    class="flex px-20 flex-col items-center justify-center w-full h-64 border-2 border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-800 hover:border-gray-500">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                upload</span> or </p>
                        <p>drag and drop photo/video here</p>
                    </div>
                </label>
                <input id="file_path" name="file_path" type="file"
                    accept="image/jpeg,image/png,video/mp4,video/quicktime" class="hidden" />
                <label for="caption" class="flex flex-col gap-2">
                    <p class="text-lg lg:text-xl">Caption</p>
                    <textarea id="caption" name="caption"
                        class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan Caption" maxlength="150"></textarea>
                </label>
                {{-- Input Thumbnail --}}
                <input type="hidden" name="thumbnail" id="thumbnailInput">
                {{-- Input Thumbnail --}}
                <button type="submit"
                    class="bg-blue-500 w-full text-white hover:bg-blue-400 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ringbg-blue-400">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const dropzone = document.getElementById('dropzone-file');
        const fileInput = document.getElementById('file_path');

        // Event: Ketika Input File Berubah (File Dipilih)
        // fileInput.addEventListener('change', async function() {
        //     if (this.files.length > 0) {

        //         previewFile(this.files[0]);

        //     }
        // });
        fileInput.addEventListener('change', async function() {
            if (this.files.length > 0) {

                const file = this.files[0];

                if (file.type.startsWith("video/")) {
                    generateThumbnail(file);
                    previewFile(file);
                } else {
                    previewFile(file);
                }

                // if (file.type === 'video/quicktime') {
                //     const convertedUrl = await convertMovToMp4(file);
                //     const output = await fetchFile(convertedUrl);

                //     previewFile(output);
                // }

            }
        });

        // Event: Drag & Drop File
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            const file = e.dataTransfer.files[0];

            if (file) {
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                // if (file.type === 'video/quicktime') {
                //     const convertedUrl = await convertMovToMp4(file);
                //     const output = await fetchFile(convertedUrl);

                //     previewFile(output);
                // }

                previewFile(file);
            }
        });

        // Fungsi untuk Menampilkan Preview File
        function previewFile(file) {
            const reader = new FileReader();

            reader.onload = function(event) {
                dropzone.innerHTML = ""; // Kosongkan isi container

                if (file.type.startsWith("image/")) {
                    const imgElement = document.createElement("img");
                    imgElement.src = event.target.result;
                    imgElement.classList.add("w-full", "h-full", "object-contain");
                    dropzone.appendChild(imgElement);
                } else if (file.type.startsWith("video/")) {
                    const videoElement = document.createElement("video");
                    videoElement.src = event.target.result;
                    videoElement.controls = true;
                    videoElement.classList.add("w-full", "h-full", "object-contain");

                    dropzone.appendChild(videoElement);


                }
            };

            reader.readAsDataURL(file);
        }

        async function generateThumbnail(videoFile) {
            const video = document.createElement("video");
            video.src = URL.createObjectURL(videoFile);
            video.currentTime = 1; // Ambil frame pertama setelah 1 detik
            video.muted = true;
            video.play();

            video.oncanplay = () => {
                const canvas = document.createElement("canvas");
                canvas.width = 150;
                canvas.height = 150;
                const ctx = canvas.getContext("2d");

                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const thumbnailData = canvas.toDataURL("image/png");

                document.getElementById("thumbnailInput").value = thumbnailData;

                video.pause();
            };
        }
    </script>
@endsection
