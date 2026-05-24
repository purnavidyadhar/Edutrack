@extends('layouts.public')
@section('title', 'Contact Us')

@section('content')
<div class="py-24 px-6 max-w-3xl mx-auto space-y-16">
    <div class="text-center space-y-4">
        <h1 class="text-5xl font-display font-extrabold text-brand-950">Contact Us</h1>
        <p class="text-xl text-[#64748B] font-medium">We're here to help you transform your institution.</p>
    </div>

    <form onsubmit="event.preventDefault(); alert('Thank you for reaching out!\nOur support team has received your message and will get in touch with you shortly.'); this.reset();" class="glass-card p-10 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-widest">First Name</label>
                <input type="text" class="w-full px-5 py-3 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-widest">Last Name</label>
                <input type="text" class="w-full px-5 py-3 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-700 uppercase tracking-widest">Email Address</label>
            <input type="email" class="w-full px-5 py-3 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
        </div>
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-700 uppercase tracking-widest">Message</label>
            <textarea rows="5" class="w-full px-5 py-3 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-brand-500/20 outline-none transition-all"></textarea>
        </div>
        <button type="submit" class="w-full py-4 bg-brand-950 text-white font-bold rounded-xl shadow-xl shadow-brand-950/20 hover:bg-brand-900 transition-all">Send Message</button>
    </form>
</div>
@endsection
