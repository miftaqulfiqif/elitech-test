@extends('utils.index')
@section('title', 'Setting Profile')

@section('content')
    <div class="flex flex-col gap-4 bg-slate-900 text-white mx-10 md:mx-32 lg:mx-56">
        <div class="flex flex-col items-center justify-center px-4 py-4 mx-auto lg:py-6">
            <p class="text-2xl lg:text-4xl">Edit Profile</p>
        </div>
        <div class="flex flex-row bg-gray-600 max-w-full p-6 rounded-2xl justify-between">
            <div class="flex flex-row gap-4 lg:gap-6">
                <div class="flex items-center justify-center">
                    <div
                        class="w-[70px] h-[70px] md:w-[100px] md:h-[100px] lg:w-[150px] lg:h-[150px] border rounded-full overflow-hidden">
                        <img src="{{ asset('assets/icons/person.png') }}" alt="Profile Picture"
                            class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="flex flex-col justify-center lg:gap-4">
                    <p class="font-bold lg:text-4xl">{{ $user->username }}</p>
                    <p class="lg:text-2xl">{{ $user->name }}</p>
                </div>
            </div>
            <div class="flex flex-col justify-center">
                <a href="" class=" bg-blue-500 py-2 px-4 rounded-lg lg:text-2xl lg:py-3 lg:px-8">
                    Ubah foto profil
                </a>
            </div>
        </div>

        <div class="">
            <form action="{{ route('save-user-profile') }}" method="post" class="flex flex-col gap-4">
                @csrf
                <label for="username" class="flex flex-col gap-2">
                    <p class="text-lg lg:text-xl">Username</p>
                    <input id="username" name="username"
                        class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan Username" value="{{ old('bio', $user->username) }}">
                </label>
                <label for="bio" class="flex flex-col gap-2">
                    <p class="text-lg lg:text-xl">Bio</p>
                    <textarea id="bio" name="bio"
                        class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan Bio">{{ old('bio', $userProfile->bio) }}</textarea>
                </label>
                <label for="feed_row" class="flex flex-col gap-2">
                    <p class="text-lg lg:text-xl">Jumlah Feed Per Row</p>
                    <input type="number" id="feed_row" name="feed_row"
                        class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan Username" value="{{ old('bio', $feedRow->feed_row_count) }}">
                </label>
                <button type="submit"
                    class="bg-blue-500 w-full text-white hover:bg-blue-400 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ringbg-blue-400">Simpan</button>
            </form>
        </div>
    </div>
@endsection
