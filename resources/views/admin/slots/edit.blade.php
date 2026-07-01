@extends('admin.layout')

@section('content')
<div class="max-w-xl bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">⚙️ Modify Live Slot State</h2>
        <p class="text-xs text-gray-500 mt-0.5">Adjust capacity limits or alter availability status flags</p>
    </div>
    
    <form action="{{ route('admin.slots.update', $slot->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Event Target Date (Immutable)</label>
            <input type="text" disabled value="{{ $slot->event_date }}" class="w-full bg-gray-50 border-gray-300 rounded-xl text-gray-400 cursor-not-allowed">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Maximum Capacity Limit</label>
            <input type="number" name="max_capacity" value="{{ $slot->max_capacity }}" max="40" required class="w-full border-gray-300 rounded-xl focus:border-green-600 focus:ring-green-600 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Operational Availability Status</label>
            <select name="status" class="w-full border-gray-300 rounded-xl focus:border-green-600 focus:ring-green-600 shadow-sm">
                <option value="available" {{ $slot->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="fully_booked" {{ $slot->status == 'fully_booked' ? 'selected' : '' }}>Fully Booked</option>
                <option value="maintenance" {{ $slot->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>
        <div class="pt-4 flex space-x-3">
            <button type="submit" class="bg-[#1E4620] text-white px-6 py-2.5 rounded-xl hover:bg-green-800 transition font-semibold shadow-sm">Save Changes</button>
            <a href="{{ route('admin.slots.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-200 transition font-semibold">Cancel</a>
        </div>
    </form>
</div>
@endsection