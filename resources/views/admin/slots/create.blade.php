@extends('admin.layout')

@section('content')
<div class="max-w-xl bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">➕ Open New Live Event Slot</h2>
        <p class="text-xs text-gray-500 mt-0.5">Initialize a calendar date threshold for the booking system</p>
    </div>
    
    <form action="{{ route('admin.slots.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Select Event Date</label>
            <input type="date" name="event_date" required class="w-full border-gray-300 rounded-xl focus:border-green-600 focus:ring-green-600 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Maximum Capacity Allocation (Max: 40)</label>
            <input type="number" name="max_capacity" value="40" max="40" required class="w-full border-gray-300 rounded-xl focus:border-green-600 focus:ring-green-600 shadow-sm">
        </div>
        <div class="pt-4 flex space-x-3">
            <button type="submit" class="bg-[#1E4620] text-white px-6 py-2.5 rounded-xl hover:bg-green-800 transition font-semibold shadow-sm">Create Slot</button>
            <a href="{{ route('admin.slots.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-200 transition font-semibold">Cancel</a>
        </div>
    </form>
</div>
@endsection