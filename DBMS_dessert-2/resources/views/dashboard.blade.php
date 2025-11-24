<x-app-layout >
    <x-slot name="header" >
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dessert') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-[50px]">
        <h1 class="text-2xl font-semibold mb-6 text-center">Add New Dessert</h1>

        @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('desserts.store') }}" method="POST" enctype="multipart/form-data">
            <!-- เพิ่ม enctype -->
            @csrf

            <!-- Dessert Name -->
            <div class="mb-4">
                <label for="name" class="block text-lg font-medium text-gray-700">Dessert Name</label>
                <input type="text" name="name" id="name"
                    class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('name') }}" required>
                @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-lg font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price"
                    class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('price') }}" min=0 required>
                @error('price')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image -->
            <div class="form-group mb-4">
                <label for="image" class="block text-lg font-medium text-gray-700">Dessert Image</label>
                <input type="file" name="image" id="image"
                    class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    accept="image/*">
                @error('image')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="festival_id" class="block text-gray-700 font-semibold mb-2">เลือกเทศกาล</label>
                <select name="festival_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($festivals as $festival)
                    <option value="{{ $festival->FestivalID }}">{{ $festival->Festival_name }}</option>
                    @endforeach
                </select>
            </div>



            <button type="submit"
                class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-5">
                Add Dessert
            </button>
        </form>
    </div>
</x-app-layout>