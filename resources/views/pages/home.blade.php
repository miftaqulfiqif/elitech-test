@extends('utils.index')

@section('title', 'Welcome')

@section('content')
    <div class="flex flex-col w-full px-2 md:px-10 lg:px-20 bg-slate-900 text-white gap-10">
        <div class="flex flex-row gap-2 lg:gap-10 lg:py-10">
            {{-- Start Profile Picture --}}
            <div class="flex items-center justify-center">
                <div
                    class="w-[100px] h-[100px] md:w-[150px] md:h-[150px] lg:w-[200px] lg:h-[200px] border rounded-full overflow-hidden">
                    <img src="{{ asset($userPicture ? 'storage/' . $userPicture : 'assets/icons/person.png') }}"
                        alt="Profile Picture" class="w-full h-full object-cover">
                </div>
            </div>
            {{-- End Profile Picture --}}

            {{-- Start Profile Info --}}
            <div class="flex flex-col gap-4 p-4 w-full">
                <div class="flex flex-row  gap-4 items-center justify-between">
                    <div class="">
                        <p class="text-xl lg:text-2xl">{{ $user->username }}</p>
                    </div>

                    {{-- Start Mobile Menu --}}
                    <a href="#" id="menu" class="block md:hidden relative">
                        <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M4 18L20 18" stroke="#ffffff" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M4 12L20 12" stroke="#ffffff" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M4 6L20 6" stroke="#ffffff" stroke-width="2" stroke-linecap="round"></path>
                            </g>
                        </svg>
                        <div id="menu-content" style="z-index: 9999;"
                            class="hidden absolute flex-col gap-2 top-12 right-2 bg-slate-800 p-2 rounded-lg">
                            <a href="{{ route('pages.edit-profile') }}"
                                class="hover:bg-slate-700 bg-slate-900 px-4 py-2 rounded-lg">Edit Profile</a>
                            <a href="{{ route('pages.view-archive') }}"
                                class="hover:bg-slate-700 bg-slate-900 px-4 py-2 rounded-lg">View Archive</a>

                            <form action="{{ route('auth.sign-out') }}" method="post" class="mx-auto">
                                @csrf
                                <button type="submit" class="hover:bg-red-400 bg-red-500 px-4 py-2 rounded-lg">Log
                                    Out</button>
                            </form>
                        </div>
                    </a>
                    {{-- End Mobile Menu --}}

                    {{-- Start Desktop Menu --}}
                    <div class="flex-row gap-4 hidden md:flex lg:flex">
                        <a href="{{ route('pages.edit-profile') }}"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-400 rounded-xl ">Edit
                            Profile</a>
                        <a href="{{ route('pages.view-archive') }}"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-400 rounded-xl">View Archive</a>

                        <form action="{{ route('auth.sign-out') }}" method="post">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-400 rounded-xl">Log
                                Out</button>
                        </form>
                    </div>
                    {{-- End Desktop Menu --}}
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-sm lg:text-lg">{{ $user->name }}</p>
                    <p class="text-xs lg:text-sm text-gray-400 " id="bio">
                        {{ Str::limit($userProfile->bio, 100) }}
                    </p>
                    <span id="more_bio" class="text-xs lg:text-sm text-gray-400 underline mt-3 cursor-pointer">Selengkapnya
                        ...</span>
                    <script></script>
                </div>
            </div>
            {{-- End Profile Info --}}
        </div>

        {{-- Start Feed --}}
        <div class="flex flex-col items-center">

            {{-- Start Create New Feed --}}
            <div class="relative w-full h-20 ">
                <hr class="absolute top-2 border-gray-300 dark:border-gray-700 w-full">
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    Feed
                </div>
                <a href="{{ route('pages.create-new-post') }}" class="absolute top-1/2 right-5 transform -translate-y-1/2">
                    <div class="flex flex-row gap-2 bg-blue-500 hover:bg-blue-400 py-2 px-4 rounded-lg">
                        <svg fill="#ffffff" width="24px" height="24px" viewBox="0 0 32 32" data-name="Layer 1"
                            id="Layer_1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <title></title>
                                <path
                                    d="M27.2,8.22H23.78V5.42A3.42,3.42,0,0,0,20.36,2H5.42A3.42,3.42,0,0,0,2,5.42V20.36a3.42,3.42,0,0,0,3.42,3.42h2.8V27.2A2.81,2.81,0,0,0,11,30H27.2A2.81,2.81,0,0,0,30,27.2V11A2.81,2.81,0,0,0,27.2,8.22ZM5.42,21.91a1.55,1.55,0,0,1-1.55-1.55V5.42A1.54,1.54,0,0,1,5.42,3.87H20.36a1.55,1.55,0,0,1,1.55,1.55v2.8H11A2.81,2.81,0,0,0,8.22,11V21.91ZM28.13,27.2a.93.93,0,0,1-.93.93H11a.93.93,0,0,1-.93-.93V11a.93.93,0,0,1,.93-.93H27.2a.93.93,0,0,1,.93.93Z">
                                </path>
                                <path
                                    d="M24.09,18.18H20v-4a.93.93,0,1,0-1.86,0v4h-4a.93.93,0,0,0,0,1.86h4v4.05a.93.93,0,1,0,1.86,0V20h4.05a.93.93,0,1,0,0-1.86Z">
                                </path>
                            </g>
                        </svg>
                        <p class="hidden md:block lg:block">Create New Post</p>
                    </div>
                </a>
                <hr class="absolute bottom-2 border-gray-300 dark:border-gray-700 w-full">
            </div>
            {{-- End Create New Feed --}}

            {{-- Start Show Content --}}
            <div id="grid-view" class="grid grid-co gap-2 md:gap-5 lg:gap-8 md:mt-4 lg:mt-8">
                @foreach ($userContent as $feed)
                    <div class="flex flex-col border rounded-xl p-2">
                        @if (Str::contains($feed->file_path, '.mp4') || Str::contains($feed->file_path, '.mov'))
                            <video controls class="w-full h-full object-cover">
                                <source src="{{ asset('storage/' . $feed->file_path) }}" type="video/mp4">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $feed->file_path) }}" class="w-full h-full object-cover">
                        @endif
                        <p class="text-xs md:text-sm lg:text-lg">
                            {{ $feed->caption }}
                        </p>
                    </div>
                @endforeach
            </div>
            {{-- End Show Content --}}
        </div>
        {{-- End Feed --}}
    </div>
@endsection

@section('script')
    <script>
        // Script Menu
        const menu = document.getElementById('menu');
        const menuContent = document.getElementById('menu-content');
        menu.addEventListener('click', () => {
            menuContent.classList.toggle('hidden');
            menuContent.classList.toggle('flex');
        });
        window.addEventListener('click', (event) => {
            if (!event.target.closest('#menu-content') && !event.target.closest('#menu')) {
                menuContent.classList.add('hidden');
                menuContent.classList.remove('flex');
            }
        });
        // Script Menu

        // Script Menampilkan Bio
        let isLimit = true;
        document.getElementById('more_bio').addEventListener('click', function() {
            let bio = document.getElementById('bio');
            if (isLimit) {
                bio.innerText = `{{ Str::limit($userProfile->bio, 100) }}`;
                more_bio.innerText = "Selengkapnya ..."
                isLimit = false;
            } else {
                bio.innerText = `{{ $userProfile->bio }}`;
                more_bio.innerText = "Sembunyikan ..."
                isLimit = true;
            }
        });
        // Script Menampilkan Bio

        // Script Menampilkan Feed sesuai data user
        const gridView = document.getElementById('grid-view');
        const feedRowCount = {{ $feedRowCount }};

        gridView.style.gridTemplateColumns = 'repeat(' + feedRowCount + ', minmax(0, 1fr))';
        // Script Menampilkan Feed sesuai data user
    </script>

@endsection
